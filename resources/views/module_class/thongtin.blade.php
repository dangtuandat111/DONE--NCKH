@section('DeMuc', 'Lớp học phần')
@section('title', 'Lớp học phần')

@extends('admin.dashboard')
@section('content')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Thêm bộ lọc</h3>
            </div>
            <div class="card-body">
              <div class= "row">
                <!--module-->
                <div class = "col-6">
                  <select id="select_md" class = "custom-select">
                    <option value ="">Chọn học phần</option>
                      @foreach($module as $hp) 
                      <option class = "option" value = "{{$hp->ID_Module}}">{{$hp->Module_Name}}</option>
                      @endforeach()
                  </select>
                </div>

                <!--nam hoc-->
                <div class = "col-4">
                  <select id="select_dp" class = "custom-select">
                    <option value ="">Chọn bộ môn</option>
                      @foreach($departments as $hp) 
                      <option class = "option" value = "{{$hp->ID_Department}}">{{$hp->Department_Name}}</option>
                      @endforeach()
                  </select>
               </div>

              <!--so tin chi-->
              <div class = "col-2">
                <select id="select_cd" class = "custom-select">
                  <option value ="">Chọn số tín chỉ</option>
                    @foreach($credits as $hp) 
                    <option class = "option" value = "{{$hp->Credit}}">{{$hp->Credit}}</option>
                    @endforeach()
                </select>
              </div>
            </div>

            <div class = "row" style = "margin-top: 15px;">
              <!--Phan Giang-->
              <div class = "col-2">
                  <select id="select_pg" class = "custom-select">
                      <option value ="">Phân Giảng</option>
                      <option class = "option" value = "DaPG">Đã Phân Giảng</option>
                      <option class = "option" value = "ChuaPG">Chưa Phân Giảng</option>
                  </select>
              </div>

              <!--Giang Vien-->
              <div class = "col-2">
                  <select id="select_gv" class = "custom-select">
                    <option value ="">Giảng viên</option>
                      @foreach($teacher as $tc) 
                      <option class = "option" value = "{{$tc->ID_Teacher}}">{{$tc->Name_Teacher}}</option>
                      @endforeach()
                  </select>
              </div>

              <!--Ki hoc-->
              <div class = "col-2">
                <select id="select_sy" class = "custom-select">
                  <option value ="">Chọn năm học</option>
                    @foreach($school_year as $sy) 
                    <option class = "option" value = "{{$sy->School_Year}}">{{$sy->School_Year}}</option>
                    @endforeach()
                </select>
              </div>

              <!--Ki hoc-->
              <div class = "col-2">
                <select id="select_kind" class = "custom-select">
                  <option value ="">Kiểu học phần</option>
                    <option class = "option" value = "LT">Lý thuyết</option>
                    <option class = "option" value = "BT">Bài tập</option>
                    <option class = "option" value = "TH">Thực hành</option>
                    <option class = "option" value = "TL">Tự luận</option>
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
    <div class="row">
      <div class="col-12 col-sm-12 col-xs-12 col-md-12 col-xl-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Thông tin học phần</h3>
            </div>    
          <div class="card-body">
            @if(session('thongbao')) 
            <div class = "alert alert-success">
                {{session('thongbao')}}
            </div>
             @endif
            
            <table class="table table-bordered table-striped col-xs-6 col-md-12 col-12 col-sm-12"  style = "font-size: 14px;">
         				<thread> 
         					<tr>
         						<th>Mã lớp học phần</th>
         						<th>Tên lớp học phần</th>
         						<th>Số sinh viên</th>
         						<th>Năm học</th>
         						<th>Mã học phần</th>
         						<th>Mã giảng viên</th>
         					</tr>
         				</thread>
            <tbody id = 'tbody'>
            	@foreach($module_class as $md)
            		<tr>
            			<td> {{$md->ID_Module_Class}} </td>
            			<td> {{$md->Module_Class_Name}} </td>
            			<td> {{$md->Number_Reality}} </td>
            			<td> {{$md->School_Year}} </td>
            			<td> {{$md->ID_Module}} </td>
            			<td> {{$md->ID_Teacher}}</td>
            		</tr>
            	@endforeach
            </tbody> 
            </table>
            <nav aria-label = "Page navigation" id="pagination">
         	    {!! $module_class->links() !!}
            </nav> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    $("#Filter").click(function() {
      var md = $("#select_md").val();
      var cd = $("#select_cd").val();
      var dp = $("#select_dp").val();
      var pg = $("#select_pg").val();
      var gv = $("#select_gv").val();
      var sy = $("#select_sy").val();
      var kind = $("#select_kind").val();

      var item = "";
      alert(md+"//"+cd+"//"+dp+"//"+pg+"//"+gv+"//"+sy+"//"+kind);
      $.ajax({
        type: 'get',
        dataType: 'json',
        url: "{{url('/admin/module_class/filter')}}",
        data: 'md='+md+'&dp='+dp+'&cd='+cd+'&pg='+pg+'&gv='+gv+'&sy='+sy+'&kind='+kind,
        //module department credit phangiang teacher
        success:function(response) {
          console.log(response);
          $("#tbody").empty();
          $("#pagination").empty();
          $.each(response, function (index,val) { //looping table detail bahan
              if(val.Number_Reality == null) val.Number_Reality = 0 ;
              if(val.ID_Teacher == null) val.ID_Teacher = '';
              var item = `
                <tr class="" style="font-size:14px">
                  <td>${val.ID_Module_Class}</td>
                  <td>${val.Module_Class_Name}</td>
                  <td>${val.Number_Reality}</td>
                  <td>${val.School_Year}</td>
                  <td>${val.ID_Module}</td>
                  <td>${val.ID_Teacher}</td>
                 `;
              $("#tbody").append(item);
            });
          
        }
      });
    })
  });

  // $(document).ready(function() {
  //     $('#pagination').on('click', function(e){
  //       e.preventDefault();
  //   });
  // });
</script>
@endsection

@stop()