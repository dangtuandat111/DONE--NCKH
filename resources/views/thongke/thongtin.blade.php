@section('DeMuc', 'Thống kê thay đổi giờ giảng')
@section('title', 'Thống kê')

@extends('admin.dashboard')
@section('content')

   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         <div class="col-md-12 text-right" style = "padding-bottom: 10px;"> <button id="exporttable" class="btn btn-primary">Export Excel</button> </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thông tin thay đổi giờ giảng</h3>
              </div>
              <!-- /.card-header -->
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

               <table class="table table-bordered table-striped col-xs-6" id = "htmltable">
             				<thread> 
             					<tr>
             						<th>Tên giảng viên</th>
             						<th>Yêu cầu thay đổi</th>
             						<th>Thời gian gửi yêu cầu</th>
             						<th>Thời gian xác nhận</th>
                        <th>Tình trạng</th>
             					</tr>
             				</thread>
                <tbody>
                	@foreach($data as $dt)
                    <tr>
                      <td>{{$dt->Name_Teacher}}</td>
                      <td><?php  echo "Lớp HP:".$dt->ID_Module_Class." ;Phòng: ".$dt->ID_Room." ;Ca học: ".$dt->Shift_Fix." ;Ngày học: ".$dt->Day_Fix ?></td>
                      <td>{{\Carbon\Carbon::parse($dt->Time_Fix_Request)->format('d/m/Y')}}</td>
                      <td>{{\Carbon\Carbon::parse($dt->Time_Accept_Request)->format('d/m/Y')}}</td>
                      <td>{{$dt->Status_Fix}}</td>
                    </tr>
                  @endforeach
                </tbody> 
                </table>
	           <nav aria-label = "Page navigation">
              {{ $data->links() }}
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>
<script>
 $(function() {
    $("#exporttable").click(function(e) {
        var table = $("#htmltable");
        if (table && table.length) {
            $(table).table2excel({
                exclude: ".noExl",
                name: "Excel Document Name",
                filename: "YEUCAUTHAYDOI-" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                fileext: ".xls",
                
            });
        }
    });
});
</script>
@endsection
@stop()