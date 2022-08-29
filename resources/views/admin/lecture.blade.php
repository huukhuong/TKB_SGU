@extends('admin/layouts/main')

@section('title')
    Danh sách giảng viên
@endsection

@section('pageName')
    Danh sách giảng viên
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
    <li class="breadcrumb-item active">Danh sách giảng viên</li>
@endsection

@section('content')
    {{ $lectures->links('admin/layouts/pagination') }}
    <div class="col-12">
        <div class="card card-primary">
            <div class="row">
                <div class="col-md-6 col-12">
                    <form method="post" class="p-4">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Mã GV</label>
                                    <input type="text" class="form-control" placeholder="10001" name="id" required>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Họ tên</label>
                                    <input type="text" class="form-control" placeholder="Nguyễn Văn A" name="name"
                                        required>
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="Thêm mới" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive p-0" style="border-bottom: 1px solid #ccc">
                <table class="table table-head-fixed text-nowrap bg-white">
                    <thead>
                        <tr>
                            <th>MSVG</th>
                            <th>Họ tên</th>
                            <th>Ngày thêm</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lectures as $lecture)
                            <tr>
                                <td>{{ $lecture->id }}</td>
                                <td>{{ $lecture->name }}</td>
                                <td>{{ $lecture->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $lectures->links('admin/layouts/pagination') }}
@endsection
