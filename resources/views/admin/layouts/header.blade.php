<nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin" class="nav-link {{$page == 'index' ? 'active': ''}}">Trang chủ</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/students" class="nav-link {{$page == 'students' ? 'active': ''}}">Thống kê truy cập</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/blocks" class="nav-link {{$page == 'blocks' ? 'active': ''}}">Danh sách block</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/skips" class="nav-link {{$page == 'skips' ? 'active': ''}}">Danh sách skip</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/lectures" class="nav-link {{$page == 'lectures' ? 'active': ''}}">Danh sách giảng viên</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/notifications" class="nav-link {{$page == 'notifications' ? 'active': ''}}">Quản lý thông báo</a>
    </li>

  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/logout" class="nav-link"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </li>
  </ul>
</nav>