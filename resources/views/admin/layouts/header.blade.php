<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin" class="nav-link {{$page == 'index' ? 'active': ''}}">Trang chủ</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin" class="nav-link {{$page == 'list-student' ? 'active': ''}}">Danh sách sinh viên</a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin" class="nav-link {{$page == 'list-block' ? 'active': ''}}">Quản lý block</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin/logout" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </li>
  </ul>
</nav>