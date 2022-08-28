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
            <div class="card-body table-responsive p-0" style="max-height: 60vh; border-bottom: 1px solid #ccc">
                <table class="table table-head-fixed text-nowrap table-bordered table-hover dataTable dtr-inline">
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
            <!-- /.card-body -->
            <div class="row">
                {{ $students->links('admin/layouts/pagination') }}
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection
