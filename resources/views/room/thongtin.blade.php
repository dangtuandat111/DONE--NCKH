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
                  <form id="frm-example" action="{{ url('/admin/room/submit') }}" method="POST">
                    @csrf
                   
                   
                <div>
	                <table id="example1" class="table table-bordered table-striped" style = 'font-size: 14px;'>
	                  <thead>
	                  <tr>
	                  	<th></th>
                      	<th>Mã lịch trình</th>
	                    
	                    <th>Ca học mới</th>
	                    <th>Ngày học mới</th>
	                    <th>Mã giảng viên</th>
	                    <th width="16%">Xác nhận</th>
	                    <!-- <th>
	                    	<button type="submitAccept" class="btn btn-primary">Chấp nhận</button>
	                    	<button type="submitDeny" class="btn btn-primary">Từ chối</button>
	                    </th> -->
	                    <th>Phòng học</th>
	                  </tr>
	                  </thead>
	                <tbody>
                	@foreach($fix as $fix_index)
                  <tr>
                  	<td><input type ="checkbox"  name = <?php echo $fix_index->ID_Fix ?>></td>
                    <td>{{$fix_index->ID_Schedules}}</td>
                    
                    <td>{{$fix_index->ID_Teacher_Option}}</td>
                    <td>{{$fix_index->Shift_Fix}}</td>
                    <td>{{$fix_index->Day_Fix}}</td>
                    <td>{{$fix_index->ID_Teacher_Option}}</td>
                    <td>
                    	<select class="form-control custom-select" name = <?php echo "inputID_Department_".$fix_index->ID_Schedules ?> >
		                  <option selected disabled >Chọn phòng học</option>
			                	@foreach($room as $rm)
			                		<option value="{{$rm->ID_Room}}" >{{$rm->ID_Room}}</option>
			                	@endforeach
		                </select>
                    </td>
                  </tr>
                  @endforeach
                	</tbody> 
	                </table>
                  <div class="row">
			        <div class="col-12">
			          <input type="submit" value="Phân phòng" class="btn btn-primary float-right">
			        </div>
			      </div>
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