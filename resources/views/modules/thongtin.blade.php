@section('DeMuc', 'Học Phần')
@section('title', 'Học Phần')

@section('link')

@endsection


@extends('admin.dashboard')
@section('content')

   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Thêm bộ lọc</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">

                  <div class= "row">
                    <div class = "col-6">
                      <select id="select_md" class = "custom-select">
                          <option value ="">Chọn học phần</option>
                          @foreach($module as $hp) 
                          <option class = "option" value = "{{$hp->ID_Module}}">{{$hp->Module_Name}}</option>
                          @endforeach()
                      </select>
                    </div>

                    <!-- <div class = "col-4">
                      <select id="select_dp" class = "custom-select">
                          <option value ="">Chọn bộ môn</option>
                          @foreach($departments as $hp) 
                          <option class = "option" value = "{{$hp->ID_Department}}">{{$hp->Department_Name}}</option>
                          @endforeach()
                      </select>
                    </div> -->

                    <div class = "col-4">
                      <select id="select_cd" class = "custom-select">
                          <option value ="">Chọn số tín chỉ</option>
                          @foreach($credits as $hp) 
                          <option class = "option" value = "{{$hp->Credit}}">{{$hp->Credit}}</option>
                          @endforeach()
                      </select>
                    </div>
                  </div>

                    <div class = "row">
                      <div class = "col-12"><button type="submit" class="btn btn-primary" style = "margin-top:10px;" id="Filter">Tìm kiếm</button></div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
        <div class="row" id = "row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thông tin học phần</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if(session('thongbao')) 
                <div class = "alert alert-success">
                    {{session('thongbao')}}
                </div>
              @endif

              @if(count($errors) > 0) 
                    <div class = "alert alert-danger">
                      @foreach($errors->all() as $err)
                        {{$err}}<br>
                      @endforeach
                    </div>
                  @endif

               <table class="table table-bordered table-striped col-12 col-sm-12 col-md-12" style="font-size:14px">
         				<thread> 
         					<tr>
                    <th width = "10%">Mã học phần</th>
         						<th width = "10%">Tên học phần</th>
         						<th width = "10%">Số tín chỉ</th>
         						<th width = "5%">Số tiết lý thuyết</th>
         						<th width = "5%">Số tiết bài tập</th>
         						<th width = "5%">Số tiết thực hành</th>
         						<th width = "5%">Số tiết bài tập lớn</th>
         						<th width = "5%">Bộ môn</th>
                    @if(Auth::user()->permission == 2)
         						<th width = "5%">Xóa</th>
         						<th width = "5%">Sửa</th>
                    @endif
         					</tr>
         				</thread>
                <tbody id = "tbody">
                	@foreach($modules as $hp)
                		<tr>
                      <td> {{$hp->ID_Module}}</td>
                			<td> {{$hp->Module_Name}}</td>
                			<td> {{$hp->Credit}}</td>
                			<td> {{$hp->Theory}}</td>
                			<td> {{$hp->Exercise}}</td>
                			<td> {{$hp->Practice}}</td>
                			<td> {{$hp->Project}}</td>
                			<td> {{$hp->ID_Department}}</td>
                      @if(Auth::user()->permission == 2)
                			<td class = " center"><i class="fas fa-trash"></i><a href="../hocphan/xoa/{{$hp->ID_Module}}" onclick="return confirm('Xác nhận xóa học phần này?');">Xóa</a></td>
                			<td class = " center"><i class="fas fa-eye"></i><a href = "../hocphan/sua/{{$hp->ID_Module}}">Sửa</a></td>
                      @endif
                		</tr>
                	@endforeach
                </tbody> 
                </table>
	           <nav aria-label = "Page navigation" id="pagination">
	           	{!! $modules->links() !!}
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

<script>
  $(document).ready(function() {

    $("#Filter").click(function() {
      var md = $("#select_md").val();
      var cd = $("#select_cd").val();
      //var dp = $("#select_dp").val();
      var item = "";
      //alert(md+"//"+cd+"//"+dp);
      $.get('filter?md='+md+'&cd='+cd,function(response) {
        
          $("#row").html(response); // 
      },'html');
    });
    
});
</script>

@endsection



@stop()