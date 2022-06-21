@extends('dashboard.layout.master')

@section('pagetitle','کاربران')

<!-- Page Loader -->

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="container z-sub-header z-s-h-min">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card z-card p-2 mt-2 shadow border-0">

                            <h6 class="card-title p-2 text-center mt-2" style="color: #654A6C; font-size: 27px;">کاربران</h6>

                            <div class="card-body border-0">
                                <div id="message"></div>
                                <hr>
                                <table class="table table-bordered data-table">
                                    <thead>
                                    <tr>
                                        <th>شماره</th>
                                        <th class="th-rol">نام و نام خانوادگی</th>
                                        <th class="th-rol">ایمیل</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="category-table">
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach($users as $user)
                                        <tr >
                                            <td>{{++$i}}</td>
                                            <td >{{$user->name}}</td>

                                            <td >
                                                {{ $user->email}}

                                            </td>
                                            <td>
                                                <a class="btn btn-info btn-xs" href="{{route("calendar.index" , ['id' => $user->id])}}" >
                                                تعریف تسک</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ csrf_field() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@push('scripts')
    <script src="{{asset("/js/dashboard/app.min.js")}}"></script>
    <!-- Custom Js -->
    <script src="{{asset("/js/dashboard/admin.js")}}"></script>
@endpush

