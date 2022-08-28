@extends('admin/layouts/main')

@section('title')
    Trang chủ
@endsection

@section('pageName')
    Trang chủ
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
    <li class="breadcrumb-item active">Trang chủ</li>
@endsection

@section('content')
    <div class="col-lg-6 col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thiết lập nhanh</h3>
            </div>

            <div class="card-body">
                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Chế độ bảo trì</label>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="maintain"
                                    {{ $maintain->value == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Tắt</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="maintain"{{ $maintain->value == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Bật</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tùy chỉnh trang bảo trì</label>
                        <textarea class="form-control" id="maintain-content" name="maintain-content">{{ $maintain->content }}</textarea>
                    </div>
                    <input type="submit" value="Lưu thay đổi" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tổng quan</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ number_format($counter->value) }}</h3>

                                <p>Lượt truy cập</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $lecturesCount }}</h3>
                                <p>Dữ liệu giảng viên</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $countBlock }}</h3>
                                <p>ID bị block truy cập</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $countPass }}</h3>
                                <p>ID không cần đếm</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('CKEditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('maintain-content', {
            extraPlugins: "justify",
            height: 800
        });
    </script>
@endsection
