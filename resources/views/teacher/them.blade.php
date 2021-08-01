@section('DeMuc', 'Giảng Viên')
@section('title', 'Giảng Viên')

@extends('admin.dashboard')
@section('content')

<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
            	<h3 class="card-title">Thêm giảng viên</h3>
              <div class="card-tools">
                
              </div>
            </div>

            <div class="card-body">
            	@if(count($errors) > 0) 
            		<div class = "alert alert-danger">
            			@foreach($errors->all() as $err)
            				{{$err}}<br>
            			@endforeach
            		</div>
            	@endif

            	@if(session('thongbao')) 
            		<div class = "alert alert-success">
            				{{session('thongbao')}}
            		</div>
            	@endif

              <form action = "them" method = "POST">
              	<input type = "hidden"  name = "_token" value = "{{csrf_token()}}" />

              	<div class="form-group">
	                <label for="inputID_Teacher">Mã giảng viên</label>
	                <input type="text" name="inputID_Teacher" class="form-control" placeholder="Nhập vào mã giảng viên" value = "{{old('inputID_Teacher')}}">
	            </div>

	            <div class="form-group">
	                <label for="inputTeacher_name">Tên giảng viên / Tên tài khoản</label>
	                <input type="text" name="inputTeacher_name" class="form-control" placeholder="Nhập vào tên giảng viên" value = "{{old('inputTeacher_name')}}">
	            </div>

	            <div class="form-group">
	                <label for="inputPhone_number">Số điện thoại</label>
	                <input type="text" name="inputPhone_number" class="form-control" placeholder="Nhập vào số điện thoại" value = "{{old('inputPhone_number')}}">
	            </div>

	            <div class="form-group">
	                <label for="inputPermission">Phân Quyền</label>
	                 <select class="form-control custom-select" name = "inputPermission">
	                  <option selected disabled>Chọn quyền</option>
	            				<option value="Giảng viên">Giảng viên</option>
	            				<option value="Quản lý phòng học">Quản lý phòng học</option>
	                </select>
	            </div>

	            <div class="form-group">
	                <label for="inputEmail_Teacher">Địa chỉ email</label>
	                <input type="email" name="inputEmail_Teacher" class="form-control" placeholder="Nhập vào địa chỉ email" value = "{{old('inputEmail_Teacher')}}">
	            </div>

	            <div class="form-group">
	                <label for="inputPassword_Teacher">Mật khẩu</label>
	                <input type="password" name="inputPassword_Teacher" class="form-control" placeholder="Nhập mật khẩu" value = "{{old('inputPassword_Teacher')}}"> 
	            </div>

	            <div class="form-group">
	                <label for="inputDoB_Teacher">Ngày sinh</label>
	                <input type="date" name="inputDoB_Teacher" class="form-control" placeholder="Nhập ngày sinh" value = "{{old('inputDoB_Teacher')}}">
	            </div>

	            <div class="form-group">
	                <label for="inputTeacher_Rank">Học vị</label>
	                <select class="form-control custom-select" name = "inputTeacher_Rank" value = "{{old('inputTeacher_Rank')}}">
	                  <option selected disabled>Chọn học vị</option>
		                		<option value="Thạc sĩ">Không có</option>
                				<option value="Thạc sĩ">Thạc sĩ</option>
                				<option value="Tiến sĩ">Tiến sĩ</option>
                				<option value="Giáo sư">Giáo sư</option>

	                </select>
	            </div>

	            <div class="form-group">
	                <label for="inputID_Department">Bộ môn</label>
	                <select class="form-control custom-select" name = "inputID_Department" value = "{{old('inputID_Department')}}">
	                  <option selected disabled>Chọn bộ môn</option>
		                	@foreach($department as $bm)
		                	
                				<option value="{{$bm->ID_Department}}">{{$bm->Department_Name}}</option>

		                	@endforeach
	                </select>
	            </div>

	              <div class="row">
			        <div class="col-12">
			          <a href="{{ url('/admin/teacher/thongtin') }}" class="btn btn-secondary">Hủy</a>
			          <input type="submit" value="Thêm mới" class="btn btn-success float-right">
			        </div>
			      </div>
             	</form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
    </section>
    <!-- /.content -->
@stop()