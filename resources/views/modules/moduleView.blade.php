
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

<script >
    $(document).ready(function() {
        $('#pagination a').on('click', function(e) {
            var md = $("#select_md").val();
      		var cd = $("#select_cd").val();

            e.preventDefault();
            // var url = $(this).attr('href');
            // $.post(url, $('#search').serialize(), function(data){
            //     $('#posts').html(data);
            // });
            var url = $(this).attr('href');
            console.log(url);
            var page = url.split('page=')[1];
            console.log(page);
            $.get('filter?md='+md+'&cd='+cd+'&page=' + page, function(response) {
                //console.log("a");
                $("#row").html(response); // 
            }, 'html');

        });


    }); 
</script>