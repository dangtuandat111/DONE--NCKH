@section('DeMuc', 'Danh sách yêu cầu thay đổi giờ giảng')
@section('title', 'Yêu cầu thay đổi giờ giảng')

@extends('admin.dashboard')
@section('content')
<section class="content">
      <div class="container-fluid">
      	  <div class="row">
          <div class="col-12">
          <!--  <div class="card">
              <div class="card-header">
                <h3 class="card-title">Them bo loc</h3>

                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                  <button type="submit" class="btn btn-primary">Vi du</button>
                  
              </div>
          </div> -->
        </div>
      </div>
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
      <div class="row">
    	 <!-- Default box -->
        
          <div class="col-12">
            <!-- Default box -->
	          	 <div class="card">
	              <div class="card-header">
	                <h3 class="card-title">Danh sách:</h3>
	              </div>
	              <!-- /.card-header -->
                
	              <div class="card-body">
                  <form id="frm-example" action="{{ url('/admin/fix/submit') }}" method="POST">
                    @csrf
                   
                   
                <div>
	                <table id="example1" class="table table-bordered table-striped" style = 'font-size: 14px;'>
	                  <thead>
	                  <tr>
                      <th>Mã lịch trình</th>
	                    <th>Mã lớp học phần</th>
	                    <th>Phòng học cũ</th>
	                    <th>Ca học cũ </th>
	                    <th>Ngày học cũ</th>
	                    <th>Tên giảng viên</th>
	                    <th>Ca học mới</th>
	                    <th>Ngày học mới</th>
	                    <th>Mã giảng viên</th>
	                    <th width="16%">Xác nhận</th>
	                    <!-- <th>
	                    	<button type="submitAccept" class="btn btn-primary">Chấp nhận</button>
	                    	<button type="submitDeny" class="btn btn-primary">Từ chối</button>
	                    </th> -->
	                  </tr>
	                  </thead>
	                <tbody>
                	@foreach($fix as $fix_index)
                  <tr>
                    <td>{{$fix_index->ID_Schedules}}</td>
                    <td>{{$fix_index->ID_Module_Class}}</td>
                    <td>{{$fix_index->oldRoom}}</td>
                    <td>{{$fix_index->oldShift}}</td>
                    <td>{{$fix_index->oldDay}}</td>
                    <td>{{$fix_index->ID_Teacher_Option}}</td>
                    <td>{{$fix_index->newShift}}</td>
                    <td>{{$fix_index->newDay}}</td>
                    <td>{{$fix_index->ID_Teacher_Option}}</td>
                    <td>
                      <button type="button" class="btn btn-success btn-sm"><a href="../fix/xacnhan/{{$fix_index->ID_Fix}}" style = " text-decoration: none; color: white" onclick="return confirm('Xác nhận đồng ý thay đổi giờ giảng?');">Chấp nhận</a></button>
                      <button type="button" class="btn btn-danger btn-sm"><a href="../fix/xacnhan/{{$fix_index->ID_Fix}}" style = " text-decoration: none; color: white" onclick="return confirm('Xác nhận từ chối thay đổi giờ giảng?');">Từ chối</a></button>
                    </td>
                  </tr>
                  @endforeach
                	</tbody> 
	                </table>
                  
                  </div>
                </form>
	              </div>

	              <!-- /.card-body -->
	            </div>
	            <!-- /.card -->
          </div>
          <!-- Close col-12-->
         </div>
</section>

@section('scripts')

@endsection()

@stop()