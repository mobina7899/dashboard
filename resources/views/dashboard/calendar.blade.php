@extends('dashboard.layout.master')

@section('pagetitle','تسک ها ')

<!-- Page Loader -->

@section('content')
    @csrf
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style">
                            <li class="breadcrumb-item 	bcrumb-1">
                                <a href="index_7.html">
                                    <i class="material-icons">home</i>
                                    خانه</a>
                            </li>
                            <li class="breadcrumb-item active">تقویم</li>
                        </ul>
                    </div>
                </div>
            </div>
            <span>{{$user->name}}</span>
            <span id="user_id" class="d-none">{{$user->id}}</span>
            <br>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>رویدادهای</strong> قابل جابجایی</h2>
                        </div>
                        <div class="body">
                            <div id="external-events">
                                <form class="inline-form">
                                    <input type="text" value class="form-control" placeholder="عنوان رویداد ..." id="event_title">
                                    <button type="button" id="event_add" class="btn btn-primary waves-effect m-t-15">افزودن رویداد
                                    </button>
                                </form>
                                <div id="event_box" class="mg-bottom-10"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>رویدادها</strong>
                            </h2>
                        </div>
                        <div class="body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal-box-container text-dark">
        <div class="modal-box">
            <div class="modal-header">
                <h1>توضیحات را وارد کنید:</h1>
            </div>
            <div class="modal-main">
                <input id="description" type="textarea" class="form-control" />
            </div>
            <div class="modal-footer">
                <button id="btn_close" class="btn btn-primary ms-2">بستن</button>
                <button id="btn_save" class="btn btn-danger ms-3 me-2">ذخیره تغییرات</button>
            </div>
        </div>
        <div class="modal-box-shadow"></div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset("/js/dashboard/app.min.js")}}"></script>
    <!-- Custom Js -->
    <script src="{{asset("/js/dashboard/admin.js")}}"></script>

    <script src="{{asset("/fullcalendar/main.js")}}" ></script>
    <script src="{{asset("/js/dashboard/calendar-custom.js")}}"></script>
{{--    <script src="{{asset("/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js")}}"></script>--}}
{{--    <script src="{{asset("/bootstrap-5.0.2-dist/js/bootstrap.bundle.js")}}"></script>--}}
{{--    <script src="{{asset("/bootstrap-5.0.2-dist/js/bootstrap.min.js")}}"></script>--}}
{{--    <script src="{{asset("/bootstrap-5.0.2-dist/js/bootstrap.js")}}"></script>--}}
    <script src="{{asset("/dragula/dragula.min.js")}}"></script>
    <script src="{{asset("/Sortable-master/Sortable.min.js")}}"></script>
@endpush

