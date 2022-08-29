@extends('admin/layouts/main')

@section('title')
    Danh sách thông báo
@endsection

@section('pageName')
    Danh sách thông báo
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
    <li class="breadcrumb-item active">Danh sách thông báo</li>
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-end my-3">
        <a href="/admin/notifications/add" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Thêm mới
        </a>
    </div>
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-body table-responsive p-0" style="border-bottom: 1px solid #ccc">
                <table class="table table-head-fixed text-nowrap bg-white">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Loại</th>
                            <th>Vị trí hiển thị</th>
                            <th>Thứ tự hiển thị</th>
                            <th>Nội dung</th>
                            <th>Ngày tạo</th>
                            <th>Ngày sửa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $notification->id }}</td>
                                <td>
                                    <span class="{{ $notification->type }}">
                                        {{ $notification->type }}
                                    </span>
                                </td>
                                <td>{{ $notification->position }}</td>
                                <td>{{ $notification->order }}</td>
                                <td>{!! $notification->content !!}</td>
                                <td>{{ $notification->created_at }}</td>
                                <td>{{ $notification->updated_at }}</td>
                                <td>
                                    <a href="/admin/notifications/edit/{{ $notification->id }}" class="btn btn-info">
                                        <i class="fas fa-edit"></i>
                                        Sửa
                                    </a>
                                    <a href="/admin/notifications/delete/{{ $notification->id }}" class="btn btn-danger">
                                        <div class="fas fa-trash"></div>
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
