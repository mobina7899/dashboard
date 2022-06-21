
document.addEventListener("DOMContentLoaded", function () {

    const state = {
        events: [],
        tasks: [],
    };

    $.ajax({
        url: "/dashboard/task/fetch",
        method: "GET",
        success: function(response){
            state.tasks = response;
            updateTasks();
        }
    })

    $.ajax({
        url: "/dashboard/event/fetch",
        method: "GET",
        success: function(response){
                console.log(response)
                state.events = response;
                state.events.forEach(item => calendar.addEvent(item))
        }
    })

    var _token = $('input[name="_token"]').val();
    const event_box = document.getElementById("event_box");
    const event_title = document.getElementById("event_title");
    const event_add = document.getElementById("event_add");

    let user_id = Number.parseInt(document.getElementById("user_id").innerHTML);


    event_add.addEventListener("click", add_events);
    event_title.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            add_events();
        }
    });

    function add_events() {
        if (event_title.value != "") {
            let task = {
                content: event_title.value,
            };

            event_title.value = "";

            $.ajax({
                url: "/dashboard/task/create",
                method: "POST",
                data: {task: task, id: user_id, _token: _token},
                success: function (response) {
                    if (response) {
                        console.log(response);

                        state.tasks.push(response);

                        console.log(state.tasks);
                        updateTasks();
                    }
                }
            });
        }
        event_title.focus();
    }

    function deleteBtn(e) {
        console.log(e.target.parentNode)

        $.ajax({
            url: "/dashboard/task/delete",
            method: "POST",
            data: {id: Number.parseInt(e.target.parentNode.id), _token: _token},
            success: function () {
                const newTasks = state.tasks.filter(
                    (item) => item.id != e.target.parentNode.id
                );
                console.log(newTasks)
                state.tasks = newTasks;
                updateTasks();
            }
        });
    }

    function updateTasks() {
        event_box.innerHTML = "";
        state.tasks.map((item) => {
            event_box.innerHTML += `<div class="fc-event lable-event-${item.content} ui-draggable ui-draggable-handle hover-event" id="${item.id}" draggable="true">${item.content}<span class="btn-del-event">✖</span></div>`;
        });

        const btn_del = document.querySelectorAll(".btn-del-event");
        btn_del.forEach((item) => {
            item.removeEventListener("click", deleteBtn);
            item.addEventListener("click", deleteBtn);
        });
    }

    let calendarEl = document.getElementById("calendar");

    const btnDel = document.createElement("span");
    btnDel.innerHTML = "✖";
    btnDel.classList.add("btn-del-task");
    btnDel.addEventListener("click", function (e) {
        const deletedEvent = calendar.getEventById(
            e.target.parentNode.parentNode.parentNode.parentNode.fcSeg.eventRange.def
                .publicId
        );

        $.ajax({
            url: '/dashboard/event/delete',
            method: "POST",
            data: {
                id: deletedEvent.id,
                _token: _token
            },
            success: function (response) {
                state.tasks.push({
                    id: deletedEvent._def.publicId,
                    content: deletedEvent._def.title,
                });
                updateTasks();
                deletedEvent.remove();
            }
        });


    });

    let eventDescriptionId = "";
    const description = document.getElementById("description");


    const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            themeSystem: "bootstrap4",
            contentHeight: "auto",
            selectable: true,
            droppable: true,
            editable: true,
            dropAccept: ".fc-event",
            drop: function (date) {
                const element = state.tasks.find((item) => item.id == date.draggedEl.id);
                console.log(element);

                const addedEvent = {
                    id: date.draggedEl.id,
                    title: element.content,
                    start: date.dateStr,
                    end: date.dateStr,
                    description: "",
                };


                $.ajax({
                    url: "/dashboard/event/create",
                    method: "POST",
                    data: {
                        id: element.id,
                        user_id: user_id,
                        title: addedEvent.title,
                        start: date.dateStr,
                        end: date.dateStr,
                        _token: _token
                    },
                    success: function (response) {
                        console.log(response)
                        state.tasks = state.tasks.filter((item) => item.id !== element.id);
                        updateTasks();
                        const addedEvent = {
                            id: response.id,
                            title: response.title,
                            start: response.start,
                            end: response.end,
                            description: response.description,
                        };
                        calendar.addEvent(addedEvent);
                    }
                });
            },
            eventDrop: function (info) {

                const newEnd = new Date(info.event._instance.range.end);
                const end = `${newEnd.getFullYear()}-${newEnd.getMonth() + 1}-${newEnd.getDate()}`;

                const newStart = new Date(info.event._instance.range.start);
                const start = `${newStart.getFullYear()}-${newStart.getMonth() + 1}-${newStart.getDate()}`;

                $.ajax({
                    url: "/dashboard/event/update",
                    method: "PUT",
                    data: {
                        id: info.event._def.publicId,
                        start: start,
                        end: end,
                        _token: _token
                    },
                    success: function () {

                    }
                });

            }

            ,
            eventMouseEnter: function (info) {
                let element = info.el;

                element.dataset.toggle = "tooltip";
                element.dataset.placement = "top";

                state.events.forEach((item) => {
                    if (item.id == info.event._def.publicId) {
                        element.title = `start : ${new Date(item.start).toLocaleDateString(
                            "fa-IR"
                        )}\nend : ${new Date(item.end).toLocaleDateString("fa-IR")}`;
                    }
                });

                if (info.el.querySelector(".btn-del-task") === null) {
                    info.el.classList.add("hover-event");
                    info.el.querySelector(".fc-event-title-container").appendChild(btnDel);
                }
            }
            ,
            eventResize: function (info) {

                const newDate = new Date(info.event._instance.range.end);
                const end = `${newDate.getFullYear()}-${newDate.getMonth() + 1}-${newDate.getDate()}`;
                console.log(end)
                $.ajax({
                    url: "/dashboard/event/update",
                    method: "PUT",
                    data: {
                        id: info.event._def.publicId,
                        end: end,
                        _token: _token
                    },
                    success: function () {

                    }
                });
            }
            ,
            eventDidMount: function (info) {
                const mountedElement = info.el;
                const modalBoxContainer = document.querySelector(".modal-box-container");
                mountedElement.addEventListener("dblclick", function (e) {
                    modalBoxContainer.classList.add("modal-box-open");

                    eventDescriptionId = info.event._def.publicId;
                    description.focus();
                    state.events.forEach((item) => {
                        if (item.id === info.event._def.publicId) {
                            description.value = item.description;
                        }
                    });
                });
            }
            ,
            events: state.events,
        })
    ;

    calendar.render();
    calendar.setOption("locale", "fa");

    new FullCalendar.Draggable(event_box, {
        itemSelector: ".fc-event",
    });

    console.log(calendar);

    // let drake = dragula([event_box], {
    //   removeOnSpill: true,
    //   // copy: true,
    // });

    // new Sortable(event_box, {
    //   itemSelector: ".fc-event",
    //   removeOnSpill: true,
    //   // mirrorSelector: ".gu-mirror",
    // });

    document.getElementById("btn_close").addEventListener("click", closeDesc);
    document
        .querySelector(".modal-box-shadow")
        .addEventListener("click", closeDesc);

    function closeDesc() {
        const modalBoxContainer = document.querySelector(".modal-box-container");
        modalBoxContainer.classList.remove("modal-box-open");
    }

    const btn_save = document.getElementById("btn_save");
    btn_save.addEventListener("click", savingDesc);

    description.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            savingDesc();
        }
    });

    function savingDesc() {
        if (description.value !== "") {

            console.log(eventDescriptionId)
            $.ajax({
                url: "/dashboard/event/update",
                method: "PUT",
                data: {
                    id: eventDescriptionId,
                    description: description.value,
                    _token: _token
                }
            });

            const modalBoxContainer = document.querySelector(".modal-box-container");
            modalBoxContainer.classList.remove("modal-box-open");
        }
    }
});
