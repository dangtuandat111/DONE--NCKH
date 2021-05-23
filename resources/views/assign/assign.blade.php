@section('DeMuc', 'Phân Giảng')
@section('title', 'Phân Giảng')

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
                <h3 class="card-title">Them bo loc</h3>

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
                  <h3 class="card-title">Danh sách lớp học phần</h3> 
                </div>
	              <!-- /.card-header -->
                
	              <div class="card-body">
                  <form action="{{ url('/admin/assign/submit') }} " method="POST" >
                    <!-- {{ url('/admin/assign/submit') }} method="POST"-->
                    @csrf
                  <!--begin form-->
                  <input type = "hidden"  name = "_token" value = "{{csrf_token()}}" />
                  <div class="row">
                    <div class="col-12">
                      <input type="submit" value="Phan Giang" class="btn btn-primary" id="submitPG">
                    </div>
                  </div>

                  <div class= "form-group">
                    <div class = "col-6" style = "margin-top: 10px;">
                      <select id="select_gv" class="form-control custom-select" name ="select_gv">
                          <option value ="">Chọn giảng viên</option>
                          @foreach($teacher as $gv) 
                            <option class = "option" value = "{{$gv->ID_Teacher}}">{{$gv->Name_Teacher}}</option>
                          @endforeach()
                      </select>
                    </div>
                  </div>
                  <table class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th></th>
                        <th>Mã lớp học phần</th>
                        <th>Tên lớp học phần</th>
                        <th>Số sinh viên</th>
                        <th>Kì học</th>
                      </tr>
                      </thead>
                      <tbody id = "tbody">
                        @foreach($schedules as $sch)
                          <tr>
                            <th><input type ="checkbox"  name = <?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?> value = <?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?>></th>
                            <td>{{$sch->ID_Module_Class}}</td>
                            <td>{{$sch->Module_Class_Name}}</td>
                            <td>{{$sch->Number_Reality}}</td>
                            <td>{{$sch->School_Year}}</td>
                            
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
      $.get("getTeacher/"+dp,function(data){
        $("#select_gv").html(data);
      });
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
        url: "{{url('/admin/assign/filter')}}",
        data: 'md='+md+'&dp='+dp+'&sy='+sy,
        //module department credit
        success:function(response) {
          console.log(response);
          $("#tbody").empty();
          //$("#pagination").empty();
          var data = response.data;
          //var pag = "";
          // var link = response.links;
          // console.log(link);
           $("#pagination").append(response.links);
          $.each(data, function (index,val) { //looping table detail bahan
              var item = `
                <tr class="" style="font-size:14px">
                  <th><input type ="checkbox"  name = <?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?> value = <?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?> ></th>
                  <td>${val.ID_Module_Class}</td>
                  <td>${val.Module_Class_Name}</td>
                  <td>${val.Number_Reality}</td>
                  <td>${val.School_Year}</td>
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