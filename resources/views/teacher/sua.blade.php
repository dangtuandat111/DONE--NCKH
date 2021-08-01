@section('DeMuc', 'Giảng Viên')
@section('title', 'Giảng viên')

@extends('admin.dashboard')
@section('content')

<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
            	<h3 class="card-title">Sửa giảng viên</h3>
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
            	
				@foreach($teachers as $gv)
              <form action = "{{$gv->ID_Teacher}}" method = "POST">
              	
           		
              	<input type = "hidden"  name = "_token" value = "{{csrf_token()}}" />
	              <div class="form-group">
	                <label for="inputID_Teacher">Mã giảng viên</label>
	                <input type="text" name="inputID_Teacher" class="form-control" placeholder="Nhập vào mã giảng viên" value="{{$gv->ID_Teacher}}" >
	              </div> 

	              <div class="form-group">
	                <label for="inputName_Teacher">Tên giảng viên</label>
	                <input type="text" name="inputName_Teacher" class="form-control" placeholder="Nhập tên giảng viên" value = "{{$gv->Name_Teacher}}">
	              </div>

	              <div class="form-group">
	                <label for="inputDoB_Teacher">Ngày sinh giảng viên</label>
	                <input type="date" name="inputDoB_Teacher" class="form-control" placeholder="Nhập ngày sinh giảng viên" value = "{{$gv->DoB_Teacher}}">
	              </div>

	              <div class="form-group">
	                <label for="inputPhone_Teacher">Số điện thoại liên lạc</label>
	                <input type="text" name="inputPhone_Teacher" class="form-control" placeholder="Nhập vào số điện thoại" value = "{{$gv->Phone_Teacher}}">
	              </div>

	              <div class="form-group">
	                <label for="inputPermission">Phân Quyền</label>
	                <select class="form-control custom-select" name = "inputPermission" >
	                  <option selected disabled >Chọn Phân quyền</option>
		                	
		                	<option value = 'Giảng viên'>Giảng Viên</option>
		                	

	                </select>
	              </div>

	              <div class="form-group">
	                <label for="inputEmail_Teacher">Địa chỉ email</label>
	                <input type="text" name="inputEmail_Teacher" class="form-control" placeholder="Nhập vào email" value = "{{$gv->Email_Teacher}}">
	              </div>

	               <div class="form-group">
	                <label for="inputID_Department">Bộ môn</label>
	                <select class="form-control custom-select" name = "inputID_Department" >
	                  <option selected disabled >Chọn bộ môn</option>
		                	@foreach($department as $dp)
		                		<option value="{{$dp->ID_Department}}" >{{$dp->Department_Name}}</option>
		                	@endforeach
	                </select>
	              </div>
	       
	        	     @endforeach
					
	              <div class="row">
			        <div class="col-12">
			          <a href="{{ url('/admin/teacher/thongtin') }}" class="btn btn-secondary">Hủy</a>
			          <input type="submit" value="Sửa" class="btn btn-success float-right">
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