<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="index3.html" class="brand-link">
    <img src="{{asset('AdminLTE/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Admin TKB SGU</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
          <a href="/admin" class="nav-link {{$page == 'index' ? 'active': ''}}">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Trang chủ
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link {{$page == 'list-student' ? 'active': ''}}">
            <i class="nav-icon fas fa-user-clock"></i>
            <p>
              Thống kê truy cập
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link {{$page == 'list-block' ? 'active': ''}}">
            <i class="nav-icon fas fa-user-lock"></i>
            <p>
              Quản lý block
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>