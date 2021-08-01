@section('DeMuc', 'Thống kê thay đổi giờ giảng')
@section('title', 'Thống kê')

@extends('admin.dashboard')
@section('content')

   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <form action = "{{ url('/admin/export/thongke') }}" method = "POST">
            <input type = "hidden"  name = "_token" value = "{{csrf_token()}}">

              <div class="form-group">
                <select  class = "custom-select" style = "padding-right: 0px;" name = "month" >
                      <option value ="00" size="3" >Chọn tháng</option>
                      <option value="01">Tháng 1</option>
                      <option value="02">Tháng 2</option>
                      <option value="03">Tháng 3</option>
                      <option value="04">Tháng 4</option>
                      <option value="05">Tháng 5</option>
                      <option value="06">Tháng 6</option>
                      <option value="07">Tháng 7</option>
                      <option value="08">Tháng 8</option>
                      <option value="09">Tháng 9</option>
                      <option value="10">Tháng 10</option>
                      <option value="11">Tháng 11</option>
                      <option value="12">Tháng 12</option>
                  </select>
              </div>
          
              <div class="row">
                <div class="col-12">
                  <input type="submit" value="Xuất báo cáo" class="btn btn-primary">
                </div>
              </div>

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

               <table class="table-bordered table-striped table-hover" id = "htmltable" style = 'font-size: 14px;' >
             				<thead > 
             					<tr >
                        <th>STT</th>
             						<th >Giảng viên</th>
             						<th>Yêu cầu thay đổi</th>
                        <th>Thời gian cũ</th>
                        <th>Thời gian mới</th>
                        <th>Phòng mới</th>
             						<th>Thời gian gửi yêu cầu</th>
             						<th>Thời gian xác nhận</th>
                        <th>Tình trạng</th>
             					</tr>
             				</thead>
                <tbody>
                  <?php $i=1;?>
                	@foreach($data as $dt)
                    <tr>
                      <td><?php echo $i; $i++ ?></td>
                      <td>{{$dt->Name_Teacher}}</td>
                      <td><?php  echo "Lớp:".$dt->ID_Module_Class?></td>
                      <td width="15%"><?php  echo "Ca:".$dt->Shift_Fix."<br>Ngày: ".\Carbon\Carbon::parse($dt->Day_Fix)->format('d/m/Y') ?></td>
                      <td width="15%"><?php  echo "Ca:".$dt->Shift_Schedules."<br>Ngày: ".\Carbon\Carbon::parse($dt->Day_Schedules)->format('d/m/Y') ?></td>
                      <td><?php echo $dt->ID_Room ?></td>
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

<!-- @section('scripts')
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
@endsection -->
@stop()