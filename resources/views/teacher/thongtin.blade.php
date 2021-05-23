@section('DeMuc', 'Giảng Viên')
@section('title', 'Giảng viên')

@extends('admin.dashboard')
@section('content')

   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thông tin Giảng viên</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if(session('thongbao')) 
                <div class = "alert alert-success">
                    {{session('thongbao')}}
                </div>
              @endif

               <table class="table table-bordered table-striped col-xs-6">
             				<thread> 
             					<tr>
             						<th>Tên giảng viên</th>
             						<th>Số điện thoại</th>
             						<th>Địa chỉ email</th>
             						
             						<th>Trình độ chuyên môn</th>
             						<th>Bộ môn</th>
             						<th>Xóa</th>
             						<th>Sửa</th>  
             					</tr>
             				</thread>
                <tbody>
                	@foreach($teachers as $gv)
                		<tr>
                			<td> {{$gv->Name_Teacher}}</td>
                			<td> {{$gv->Phone_Teacher}}</td>
                			<td> {{$gv->Email_Teacher}}</td>
                			
                			<td> {{$gv->University_Teacher_Degree}}</td>
                			<td> {{$gv->ID_Department}}</td>
                			<td class = " center"><i class="fas fa-trash"></i><a href="../teacher/xoa/{{$gv->ID_Teacher}}" onclick="return confirm('Xác nhận xóa giảng viên này?');">Xóa</a></td>
                			<td class = " center"><i class="fas fa-eye"></i><a href = "../teacher/sua/{{$gv->ID_Teacher}}" >Sửa</a></td>
                		</tr>
                	@endforeach
                </tbody> 
                </table>
	           <nav aria-label = "Page navigation">
	           	{!! $teachers->links() !!}
	           </nav> 
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@stop()