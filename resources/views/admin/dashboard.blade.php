<?php 
use Carbon\Carbon;
?>
@extends('admin.master')
@section('body')

<div class="wrapper"  style = 'font-size: 14px;'>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/home') }}" class="nav-link">Trang chủ</a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link">
      <img src="{{ asset('AdminLTE-3.0.5/dist/img/LogoUTC.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light " style = "color: white; font-size: 18px; padding-left: 20px;">Hỗ trợ giảng dạy</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3" style = 'text-align: center; font-size: 18px; text-decoration: underline; padding-bottom: 0px!important;'>
       
        <div class="info " > <!--20-->
          <a href="{{ url('/home') }}" class="d-block" style = 'text-decoration: underline; padding-bottom: 0px;'>
            <?php 
              $id = Auth::user()->id; 
              $permission = Auth::user()->permission;
              if($permission == 1){
                $dt = DB::table('teacher')->where('ID_Account','=',$id)->get();
                echo $dt[0]->Name_Teacher;
              }
              else {
                $name = Auth::user()->username;
                echo $name;
              }
            ?>
            
          </a>
        
        </div>
      </div>

      <!-- Sidebar Menu -->

        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <!-- Phan them hoc phan -->
         
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Học phần
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="  {{ url('/admin/hocphan/thongtin') }}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thông tin học phần</p>
                </a>
              </li>
              
             @if(Auth::user()->permission == 2)
             <li class="nav-item">
                <a href="{{ url('/admin/hocphan/them') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm học phần</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <!--Phan them Giang vien -->
          
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
           <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Giảng viên 
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/teacher/thongtin') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thông tin về giảng viên </p>
                </a>
              </li>
              @if(Auth::user()->permission == 2)
              <li class="nav-item">
                <a href="{{ url('/admin/teacher/them') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm giảng viên </p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <!--Phan them lop hoc phan -->
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Lớp học phần
                <i class="right fas fa-angle-left"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/module_class/thongtin') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thông tin lớp học phần</p>
                </a>
              </li>
            </ul>
          </li>

          <!--Phan lich giang day -->
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Lịch giảng dạy
                <i class="right fas fa-angle-left"></i>
                
              </p>
            </a>
            @if(Auth::user()->permission == 1 )
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/calendar') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lịch giảng</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/fix/thongtin') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thay đổi giờ giảng</p>
                </a>
              </li>
              
            </ul>
            <ul class="nav nav-treeview"><hr style = " border-top: 1px solid grey; width: 80%; margin-left:20px"></ul>
            @endif
            @if(Auth::user()->permission == 2)
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/fullcalendar') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thông tin giờ giảng</p>
                </a>
              </li>
            </ul>
            @endif
            
            @if(Auth::user()->permission == 2)
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/fix/yeucau') }}" class="nav-link">
                  <i class="far fa-circle nav-icon" ></i>
                  <p>Yêu cầu thay đổi</p>
                </a>
              </li>

            </ul>
            <ul class="nav nav-treeview"><hr style = " border-top: 1px solid grey; width: 80%; margin-left:20px"></ul>
            @endif
            @if(Auth::user()->permission == 5) 
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/room/thongtin') }}" class="nav-link">
                  <i class="far fa-circle nav-icon" style = "font: 5px;"></i>
                  <p >Phân phòng </p>
                </a>
              </li>
            </ul>
            @endif
          </li>
           <!--Phan phan giang -->
           @if(Auth::user()->permission == 2)
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Phân giảng
                <i class="right fas fa-angle-left"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/assign/thongtin') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lớp phân giảng</p>
                </a>
              </li>
            </ul>
            <!--Xoa lop da phan giang-->
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/assign/list') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Danh sách phân giảng</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          <!--Phan Import bang file Excel -->
          @if(Auth::user()->permission == 2)
          <li class="nav-item has-treeview ">
            <a href="" class="nav-link active">
              <i class="nav-icon fas fa-upload"></i>
              <p>
                Import 
                <i class="right fas fa-angle-left"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/import/giangvien') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm giảng viên</p>
                </a>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/import/lophocphan') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thêm lớp học phần</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          </li>
          <!-- Thong ke du lieu -->
          @if(Auth::user()->permission == 2)
          <li class="nav-item has-treeview ">
            <a href="{{ url('/admin/thongke/thongtin') }}" class="nav-link active">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Thống kê
                <!-- <i class="right fas fa-angle-left"></i> -->
                
              </p>
            </a>
            
          </li>
          @endif
          </li>
          <!--Phan them Phong -->
          <!-- @if(Auth::user()->permission == 2)
          <li class="nav-item has-treeview ">
            <a href="{{ url('/admin/room/thongtin') }}" class="nav-link active">
              <i class="nav-icon fas fa-school"></i>
              
              <p>
                Phòng học 
                <i class="right fas fa-angle-left"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/room/thongtin') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Thông tin phòng học </p>
                </a>
              </li>
            </ul>
          </li>
          @endif -->
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('DeMuc')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/logout') }}">Đăng xuất</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  @yield('content')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@stop()
