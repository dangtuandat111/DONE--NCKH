
   <!-- Default box -->
   <div class="col-12">
     <!-- Default box -->
     <div class="card">
       <div class="card-header">
         <h3 class="card-title">Danh sách lớp học phần</h3>
       </div>
       <!-- /.card-header -->
       <div class="card-body">
         <form action="{{ url('/admin/assign/submit') }} " method="POST">
           <!-- {{ url('/admin/assign/submit') }} method="POST"--> @csrf
           <!--begin form-->
           <input type="hidden" name="_token" value="{{csrf_token()}}" />
           <div class="row">
             <div class="col-12">
               <input type="submit" value="Phân Giảng" class="btn btn-primary" id="submitPG">
             </div>
           </div>
           <div class="col-sm-6" style="margin-top: 10px;">
             <!-- radio -->
             <div class="form-group">
               <div class="form-check">
                 <input class="form-check-input" type="radio" name="Option_GV" value="Value_GV1" checked>
                 <label class="form-check-label">Chọn giảng viên bộ môn</label>
               </div>
               <div class="form-check">
                 <input class="form-check-input" type="radio" name="Option_GV" value="Value_GV2">
                 <label class="form-check-label">Chọn giảng viên bộ môn khác</label>
               </div>
             </div>
           </div>
           <div class="form-group">
             <div class="col-6" style="margin-top: 10px;" id="gv1">
               <select id="select_gv" class="form-control custom-select" name="select_gv">
                 <option value="">Chọn giảng viên bộ môn</option> 
                 @foreach($teacher as $gv) <option class="option" value="{{$gv->ID_Teacher}}">{{$gv->Name_Teacher}}</option> @endforeach()
               </select>
             </div>
             <div style="margin-top: 10px;" id="gv2" class=" col-12">
               <select class="custom-select col-5" name="select_bm" id="select_bm">
                 <option value="">Chọn bộ môn</option> 
                 @foreach($departments as $hp) <option class="option" value="{{$hp->ID_Department}}">{{$hp->Department_Name}}</option> @endforeach()
               </select>
               <select id="select_gv_2" class="form-control custom-select col-6" name="select_gv_2" style="margin-left: 10px;">
                 <option value="">Chọn giảng viên</option> 
                 @foreach($teacher_All as $gv) <option class="option" value="{{$gv->ID_Teacher}}">{{$gv->Name_Teacher}}</option> @endforeach()
               </select>
             </div>
           </div>
           <table class="table table-bordered table-striped" id="table_data">
             <thead>
               <tr>
                 <th></th>
                 <th>Mã lớp học phần</th>
                 <th>Tên lớp học phần</th>
                 <th>Số sinh viên</th>
                 <th>Kì học</th>
               </tr>
             </thead>
             <tbody id="tbody"> 
             	@foreach($schedules as $sch) 
             	<tr>
                	<th>
                   		<input type="checkbox" name=<?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?> value=<?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?>>
                 	</th>
		                <td>{{$sch->ID_Module_Class}}</td>
		                <td>{{$sch->Module_Class_Name}}</td>
		                <td>{{$sch->Number_Reality}}</td>
		                <td>{{$sch->School_Year}}</td>
                </tr> 
           		@endforeach </tbody>
           </table>
           <nav aria-label="Page navigation example" id="pagination">
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

    $('#pagination a').on('click', function(e){
      var md = $("#select_md").val();
      var sy = $("#select_sy").val();
      //var dp = $("#select_dp").val();
      var dh = $("#select_DotHoc").val();
      var kind = $("#kind").val();
      
      e.preventDefault();
      // var url = $(this).attr('href');
      // $.post(url, $('#search').serialize(), function(data){
      //     $('#posts').html(data);
      // });
      var url = $(this).attr('href');
      console.log(url);
      var page = url.split('page=')[1];
      console.log(page);
      $.get('filter?md='+md+'&sy='+sy+'&dh='+dh+'&kind='+kind+'&page='+page,function(response) {
        //console.log("a");
          $("#row").html(response); // 
      },'html');
      
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
</script>

