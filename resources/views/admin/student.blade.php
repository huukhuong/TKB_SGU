@extends('admin/layouts/main')

@section('title')
    Thống kê truy cập
@endsection

@section('pageName')
    Thống kê truy cập
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
    <li class="breadcrumb-item active">Thống kê truy cập</li>
@endsection

@section('content')
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-body">
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <label>Nhập thông tin tìm kiếm</label>
                        <textarea name="keyword" rows="5" class="form-control" placeholder="Mỗi từ khóa cách nhau 1 dòng">{{ $keyword }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="byId" id="byId"
                                {{ $type == 'byId' ? 'checked' : '' }}>
                            <label for="byId" class="form-check-label">Tìm theo mã</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="byName" id="byName"
                                {{ $type == 'byId' ? '' : 'checked' }}>
                            <label for="byName" class="form-check-label">Tìm theo tên</label>
                        </div>
                    </div>

                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    {{ $students->links('admin/layouts/pagination') }}
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-body table-responsive p-0" style="border-bottom: 1px solid #ccc">
                <table class="table table-head-fixed text-nowrap bg-white">
                    <thead>
                        <tr>
                            <th>MSSV</th>
                            <th>Count</th>
                            <th>Họ tên</th>
                            <th>Ngày sinh</th>
                            <th>Lớp</th>
                            <th>Khoa</th>
                            <th>Ngành</th>
                            <th>Thời gian truy cập</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->visit_count }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->birthday }}</td>
                                <td>{{ $student->class }}</td>
                                <td>{{ $student->faculty }}</td>
                                <td>{{ $student->branch }}</td>
                                <td>{{ $student->visited_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $students->links('admin/layouts/pagination') }}
@endsection
