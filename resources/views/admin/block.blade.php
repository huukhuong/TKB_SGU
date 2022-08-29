@extends('admin/layouts/main')

@section('title')
    Danh sách chặn
@endsection

@section('pageName')
    Danh sách chặn
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
    <li class="breadcrumb-item active">Danh sách chặn</li>
@endsection

@section('content')
    <div class="col-12">
        <div class="card card-primary">
            <div class="row">
                <div class="col-md-6 col-12">
                    <form method="post" class="p-4">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>MSSV</label>
                                    <input type="text" class="form-control" placeholder="Nhập MSSV" name="id" required>
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Thêm id" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive p-0" style="border-bottom: 1px solid #ccc">
                <table class="table table-head-fixed text-nowrap bg-white">
                    <thead>
                        <tr>
                            <th>MSSV</th>
                            <th>Họ tên</th>
                            <th>Ngày thêm</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->created_at }}</td>
                                <td>
                                    <a href="/admin/blocks/delete/{{ $student->id }}" class="btn btn-danger">
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
