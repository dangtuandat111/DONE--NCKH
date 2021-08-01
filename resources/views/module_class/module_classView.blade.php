
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


<script>
  $(document).ready(function() {

    $('#pagination a').on('click', function(e){
      var md = $("#select_md").val();
      var cd = $("#select_cd").val();
      var dp = $("#select_dp").val();
      var pg = $("#select_pg").val();
      var gv = $("#select_gv").val();
      var sy = $("#select_sy").val();
      var kind = $("#select_kind").val();
      
      e.preventDefault();
      // var url = $(this).attr('href');
      // $.post(url, $('#search').serialize(), function(data){
      //     $('#posts').html(data);
      // });
      var url = $(this).attr('href');
      console.log(url);
      var page = url.split('page=')[1];
      console.log(page);
      $.get('filter?md='+md+'&dp='+dp+'&cd='+cd+'&pg='+pg+'&gv='+gv+'&sy='+sy+'&kind='+kind+'&page='+page,function(response) {
        //console.log("a");
          $("#row").html(response); // 
      },'html');
      
    });
}); 
</script>