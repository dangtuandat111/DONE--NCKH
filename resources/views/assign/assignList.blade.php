@section('DeMuc', 'Lịch phân giảng')
@section('title', 'Lịch phân giảng')

@extends('admin.dashboard')
@section('content')
<section class="content">
  <div class="container-fluid">
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
        <div class="col-12">
           <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thêm bộ lọc</h3>

                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                <div class= "row">
                  <!-- Hoc phan -->
                  <div class = "col-6">
                    <select id="select_md" class = "custom-select">
                        <option value ="">Chọn học phần</option>
                          @foreach($module as $hp) 
                            <option class = "option" value = "{{$hp->ID_Module}}">{{$hp->Module_Name}}</option>
                          @endforeach()
                    </select>
                  </div>

                  <!-- Bo mon -->
                  <div class = "col-4">
                    <select id="select_dp" class = "custom-select">
                        <option value ="">Chọn bộ môn</option>
                        @foreach($departments as $hp) 
                          <option class = "option" value = "{{$hp->ID_Department}}">{{$hp->Department_Name}}</option>
                        @endforeach()
                    </select>
                  </div>

                  <!-- Ki hoc -->
                  <div class = "col-2">
                    <select id="select_sy" class = "custom-select">
                        <option value ="">Chọn kì học</option>
                        @foreach($school as $sch) 
                          <option class = "option" value = "{{$sch->School_Year}}">{{$sch->School_Year}}</option>
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
      
      <div class="row">
    	 <!-- Default box -->
          <div class="col-12">
            <!-- Default box -->
	          	<div class="card">
	              <div class="card-header">
                  <h3 class="card-title">Danh sách lớp học phần đã phân giảng</h3> 
                </div>
	              <!-- /.card-header -->
                
	              <div class="card-body">
                  <form action="{{ url('/admin/assign/submit') }} " method="POST" >
                    <!-- {{ url('/admin/assign/submit') }} method="POST"-->
                    @csrf
                  <!--begin form-->
                  <input type = "hidden"  name = "_token" value = "{{csrf_token()}}" />
                  <div class="row">
                    
                  </div>

                  <table class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Mã lớp học phần</th>
                        <th>Tên lớp học phần</th>
                        <th>Số sinh viên</th>
                        <th>Kì học</th>
                        <th>Sửa</th>
                      </tr>
                      </thead>
                      <tbody id = "tbody">
                        @foreach($schedules as $sch)
                          <tr>
                            <td>{{$sch->ID_Module_Class}}</td>
                            <td>{{$sch->Module_Class_Name}}</td>
                            <td>{{$sch->Number_Reality}}</td>
                            <td>{{$sch->School_Year}}</td>
                			<td class = " center"><i class="fas fa-eye"></i><a href = "../assign/xoa/{{$sch->ID_Module_Class}}" onclick="return confirm('Xác nhận xóa phân giảng này?');">Xóa</a></td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    
                    <nav aria-label = "Page navigation" id="pagination">
                      {!! $schedules->links() !!}
                    </nav> 

                </form>
                <!--end form-->
	             </div>
              
	              <!-- /.card-body -->
	            </div>
	            <!-- /.card -->
          </div>
          <!-- Close col-12-->
         </div>
</section>
@section('scripts')

<script>
$(document).ready(function() {
    $("#select_dp").change(function() {
      var dp = $(this).val();
      
    });

    $("#Filter").click(function() {
      var md = $("#select_md").val();
      var sy = $("#select_sy").val();
      var dp = $("#select_dp").val();
      var item = "";
      alert(md+"//"+sy+"//"+dp);
      $.ajax({
        type: 'get',
        dataType: 'json',
        url: "{{url('/admin/assign/filterList')}}",
        data: 'md='+md+'&dp='+dp+'&sy='+sy,
        //module department credit
        success:function(response) {
          console.log(response);
          $("#tbody").empty();
          $("#pagination").empty();
          
          $.each(response, function (index,val) { //looping table detail bahan
              var item = `
                <tr class="" style="font-size:14px">
                  	<td>${val.ID_Module_Class}</td>
                  <td>${val.Module_Class_Name}</td>
                  <td>${val.Number_Reality}</td>
                  <td>${val.School_Year}</td>
                  	<td class = " center"><i class="fas fa-eye"></i><a href = "../assign/xoa/${val.School_Year}" onclick="return confirm('Xác nhận xóa phân giảng này?');">Xóa</a></td>
                </tr>
                 `;
              $("#tbody").append(item);
             
          });
        }
      //end ajax
      });
    });

  });
    
</script>

@endsection
@stop()