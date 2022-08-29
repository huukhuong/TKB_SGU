@extends('admin/layouts/main')

@section('title')
    Thêm mới thông báo
@endsection

@section('pageName')
    Thêm mới thông báo
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
    <li class="breadcrumb-item"><a href="/admin/notifications">Danh sách thông báo</a></li>
    <li class="breadcrumb-item active">Thêm mới thông báo</li>
@endsection

@section('content')
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-body">
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>Loại thông báo</label>
                                <select name="type" class="form-control">
                                    <option value="alert alert-warning">Warning</option>
                                    <option value="alert alert-info">Info</option>
                                    <option value="alert alert-success">Success</option>
                                    <option value="alert alert-danger">Danger</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>Vị trí hiển thị</label>
                                <select name="position" class="form-control">
                                    <option value="top">Bên trên ô search</option>
                                    <option value="bottom">Bên dưới ô search</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>Thứ tự hiển thị</label>
                                <input type="number" class="form-control" name="order" min="0" value="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>Ngày tạo</label>
                                <input type="text" class="form-control" disabled value="{{ date('d/m/Y | H:i:s') }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <label>Nội dung</label>
                            <textarea class="form-control" id="notification-content" name="content" required></textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <input type="submit" value="Thêm mới" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('CKEditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('notification-content', {
            extraPlugins: "justify",
            height: 200
        });
    </script>
@endsection
