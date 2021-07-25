@section('DeMuc', 'Thống kê thay đổi giờ giảng')
@section('title', 'Thống kê')

@extends('admin.dashboard')
@section('content')

   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form action="{{ url('/admin/export/giangvien') }}" method="POST" role="form" enctype="multipart/form-data" style = "margin-bottom: 10px; border-color: black;">
             @csrf   
            
              <label >Thời gian</label>
                <select id="select_sy" class = "custom-select" style = "padding-right: 0px;">
                    <option value ="" size="3" >Chọn năm học</option>
                    @foreach($school as $sch) 
                      <option class = "option" value = "{{$sch->School_Year}}">
                      <?php 
                        // $HK = explode( '-', $sch->School_Year)[0];
                        // $NH = explode( '-', $sch->School_Year)[1];
                        // $NH = "20".$NH;
                        // $NH_number = (int) $NH+1;
                        // $NH = $NH."-".$NH_number;
                        // echo "Kì ".$HK." ".$NH;
                        echo $sch->School_Year;
                      ?>

                      </option>
                    @endforeach()
                </select>
           
            <button type="submit" class="btn btn-primary">Xuất báo cáo</button>
        </form>

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

               <table class="table-responsive table-bordered table-striped table-hover" id = "htmltable" >
             				<thead > 
             					<tr >
             						<th >Giảng viên</th>
             						<th>Yêu cầu thay đổi</th>
                        <th>Thời gian cũ</th>
                        <th>Thời gian mới</th>
                        <th>Phòng cũ</th>
                        <th>Phòng mới</th>
             						<th>Thời gian gửi yêu cầu</th>
             						<th>Thời gian xác nhận</th>
                        <th>Tình trạng</th>
             					</tr>
             				</thead>
                <tbody>
                	@foreach($data as $dt)
                    <tr>
                      <td>{{$dt->Name_Teacher}}</td>
                      <td><?php  echo "Lớp HP:".$dt->ID_Module_Class." ;Phòng: ".$dt->ID_Room." ;Ca học: ".$dt->Shift_Fix." ;Ngày học: ".$dt->Day_Fix ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
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

@section('link')

<style>
#htmltable {
  width: 100%;
  border: 1px solid black;
  border-collapse: collapse;
}

#htmltable thead {
  background-color: #e5ebff;

}

thead >tr {
  text-align: center; vertical-align: center;
}

</style>

@endsection

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