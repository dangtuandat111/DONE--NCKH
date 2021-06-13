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
                <h3 class="card-title">Bộ lọc</h3>

                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                <div class = "row" style = "margin-bottom: 10px">

                  <!-- Năm học -->
                  <div class = "col-4">
                    <select id="select_sy" class = "custom-select" style = "padding-right: 0px;">
                        <option value ="" size="3" >Chọn năm học</option>
                        @foreach($school as $sch) 
                          <option class = "option" value = "{{$sch->School_Year}}">
                          <?php 
                            $HK = explode( '-', $sch->School_Year)[0];
                            $NH = explode( '-', $sch->School_Year)[1];
                            $NH = "20".$NH;
                            $NH_number = (int) $NH+1;
                            $NH = $NH."-".$NH_number;
                            echo "Kì ".$HK." ".$NH;
                          ?>

                          </option>
                        @endforeach()
                    </select>
                  </div>

                  <!-- Đợt học -->
                  <div class = "col-4" style = "padding-left: 0px;">
                    <select id="select_DotHoc" class = "custom-select" >
                        <option value ="">Chọn đợt học</option>
                        @for ($i = 1; $i <= 5; $i++)
                           <option value="{{ $i }}">Đợt học {{ $i }}</option>
                        @endfor 
                    </select>
                  </div>

                  <!-- Kiểu học phần -->
                  <div class = "col-4" style = "padding-left: 0px;">
                    <select id="kind" class = "custom-select" >
                        <option value = "">Chọn kiểu học phần</option>
                        <option value="LT">Lý thuyết </option>
                        <option value="BT">Bài tập </option>
                        <option value="TH">Thực hành </option>
                        <option value="TL">Tự luận </option>
                        <option value="DA">Đồ án </option>
                    </select>
                  </div>

                </div>

                <div class= "row">
                  <!-- Hoc phan -->
                  <div class = "col-12">
                    <select id="select_md" class = "custom-select" >
                        <option value ="" >Chọn học phần</option>
                          @foreach($module as $hp) 
                            <option class = "option" value = "{{$hp->ID_Module}}">{{$hp->Module_Name}}</option>
                          @endforeach()
                    </select>
                  </div>

                  <!-- Bo mon -->
                  <!-- <div class = "col-6">
                    <select id="select_dp" class = "custom-select">
                        <option value ="" >Chọn bộ môn</option>
                        @foreach($departments as $hp) 
                          <option class = "option" value = "{{$hp->ID_Department}}">{{$hp->Department_Name}}</option>
                        @endforeach()
                    </select>
                  </div> -->

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
                      <input type="submit" value="Phân Giảng" class="btn btn-primary" id="submitPG">
                    </div>
                  </div>

                   <div class="col-sm-6" style = "margin-top: 10px;">
                      <!-- radio -->
                      <div class="form-group">
                        
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="Option_GV" value = "Value_GV1" checked>
                          <label class="form-check-label">Chọn giảng viên bộ môn</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="Option_GV" value = "Value_GV2">
                          <label class="form-check-label">Chọn giảng viên bộ môn khác</label>
                        </div>
                      </div>
                    </div>
                  <div class= "form-group">
                    <div class = "col-6" style = "margin-top: 10px;" id = "gv1">
                      <select id="select_gv" class="form-control custom-select" name ="select_gv">
                          <option value ="">Chọn giảng viên bộ môn</option>
                          @foreach($teacher as $gv) 
                            <option class = "option" value = "{{$gv->ID_Teacher}}">{{$gv->Name_Teacher}}</option>
                          @endforeach()
                      </select>
                    </div>
                    <div  style = "margin-top: 10px;" id = "gv2" class=" col-12">
                      <select class="custom-select col-5" name ="select_bm"  id = "select_bm">
                          <option value ="" >Chọn bộ môn</option>
                          @foreach($departments as $hp) 
                            <option class = "option" value = "{{$hp->ID_Department}}">{{$hp->Department_Name}}</option>
                          @endforeach()
                      </select>

                      <select id="select_gv_2" class="form-control custom-select col-6" name ="select_gv_2" style = "margin-left: 10px;">
                          <option value ="">Chọn giảng viên</option>
                          @foreach($teacher_All as $gv) 
                            <option class = "option" value = "{{$gv->ID_Teacher}}">{{$gv->Name_Teacher}}</option>
                          @endforeach()
                      </select>
                     
                      
                    </div>
                    
                  </div>

                  <table class="table table-bordered table-striped" id = "table_data">
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
                              <th>
                                  <input type ="checkbox"  name = 
                                      <?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?> value = 
                                      <?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?>>
                                  </th>
                                  <td>{{$sch->ID_Module_Class}}</td>
                                  <td>{{$sch->Module_Class_Name}}</td>
                                  <td>{{$sch->Number_Reality}}</td>
                                  <td>{{$sch->School_Year}}</td>
                              </tr>
                          @endforeach
                        
                          </tbody>
                      </table>
                  </form>
                  <nav aria-label = "Page navigation example" id="pagination">
                      {{ $schedules->links() }}
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
    $("#gv2").hide();
    $("#gv1").show();

    $("#select_bm").change(function() {
      var dp = $(this).val();
      console.log(dp);
      $.get("getTeacher/"+dp,function(data){
        $("#select_gv_2").html(data);
      });
    });

    $("#Filter").click(function() {
      var md = $("#select_md").val();
      var sy = $("#select_sy").val();
      //var dp = $("#select_dp").val();
      var dh = $("#select_DotHoc").val();
      var kind = $("#kind").val();
      var item = "";
      //alert(md+"//"+sy+"//"+dp+"//"+dh+"//"+kind);
      //alert(md+"//"+sy+"//"+dp+"//"+dh+"//"+kind);
      $.ajax({
        type: 'get',
        dataType: 'json',
        url: "{{url('/admin/assign/filter')}}",
        data: 'md='+md+'&sy='+sy+'&dh='+dh+'&kind='+kind,
        
        success:function(response) {
          //console.log(response);
          $("#tbody").empty();
          $("#pagination").empty();

          $.each(response, function (index,val) { 
              //console.log(val);
              if(val.Number_Reality == null ) val.Number_Reality = 0;
              var tempt = (val.ID_Module_Class).split(" ");
              var name = tempt[0]+'/'+tempt[1];
              console.log(name);
              var item = `
                <tr class="" >
                  <th><input type ="checkbox"  name = ${name} value = ${name} ></th>
                  <td>${val.ID_Module_Class}</td>
                  <td>${val.Module_Class_Name}</td>
                  <td>${val.Number_Reality}</td>
                  <td>${val.School_Year}</td>
                </tr>
                 `;
              $("#tbody").append(item);
              //$("#pagination").append(item);
          });
        }
      //end ajax
      });

      // $('#pagination a').on('click', function(e){
      //   e.preventDefault();
      //   // var page = $(this).attr('href').split('page=')[1];
      //   // getData(page,md,sy,dp,dh,kind);
      // });

    });

    $('input[type="radio"]').click(function() {
      var inputValue = $(this).attr("value");
      console.log(inputValue); 
      //Value_GV1 la giang vien thuoc bo mon 
      //Value_GV2 la toan bo giang vien
      if(inputValue == "Value_GV1") {
        $("#gv1").show(); 
        $("#gv2").hide(); 
      }
      if(inputValue == "Value_GV2") {
        $("#gv2").show(); 
        $("#gv1").hide(); 
      }
              
    });
  });  

  function getData(page,md,sy,dp,dh,kind)
       {
            $.ajax({
              
              type: "GET",
              url: '/admin/assign/filter?page='+page,
              data: 'md='+md+'&dp='+dp+'&sy='+sy+'&dh='+dh+'&kind='+kind,
            })
            .success(function(data) {
                 $('body').html(data);
            });
       }
</script>
<script src=
"https://code.jquery.com/jquery-1.12.4.min.js"></script>

@endsection
@stop()