@section('DeMuc', 'Import')
@section('title', 'Giảng viên')

@extends('admin.dashboard')
@section('content')



<section class="content">
       @if(session('thongbao')) 
                                <div class = "alert alert-success">
                                    {{session('thongbao')}}
                                </div>
                              @endif
       @if ( Session::has('error') )
          <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>{{ Session::get('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Đóng</span>
            </button>
          </div>
        @endif
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thêm lich</h3>

                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                <a class="btn btn-primary" data-toggle="modal" href='#modal-add'>Nhập tệp tin</a><br><br>
                <div class="modal fade" id="modal-add">
            	<div class="modal-dialog">
	                    <div class="modal-content">
	                        <div class="modal-body">

	                            <form action="{{ url('/admin/lich') }}" method="POST" role="form" enctype="multipart/form-data">
	                                <legend>FILE</legend>
	                                @csrf
	                                <div class="form-group">
	                                    <input type="file" class="form-control" name="hocphan" id="hocphan" placeholder="Input field">
	                                </div>
	                                <button type="submit" class="btn btn-primary">Gửi</button>
	                            </form>
	                        </div>
	                    </div>
	                </div>
	            </div>
              </div>
              <!-- /.card-body -->
             
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>

       <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Mẫu hướng dẫn thêm phòng</h3>

                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                
                <form action="{{ url('/admin/export/phong') }}" method="POST" role="form" enctype="multipart/form-data">
                     @csrf   
                    <button type="submit" class="btn btn-primary">Tải file</button>
                </form>
              </div>
              <!-- /.card-body -->
             
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
</section>

@stop()