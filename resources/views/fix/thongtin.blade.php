@section('DeMuc', 'Lịch giảng')
@section('title', 'Thay đổi giờ giảng')

@extends('admin.dashboard')
@section('content')
<section class="content">
      <div class="container-fluid">
      	  <div class="row">
          <div class="col-12">
          <!--  <div class="card">
              <div class="card-header">
                <h3 class="card-title">Them bo loc</h3>

                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                  <button type="submit" class="btn btn-primary">Vi du</button>
                  
              </div>
          </div> -->
        </div>
      </div>
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
    	 <!-- Default box -->
        
          <div class="col-12">
            <!-- Default box -->
	          	 <div class="card">
	              <div class="card-header">
	                <h3 class="card-title">Danh sách lớp học phần</h3>
	              </div>
	              <!-- /.card-header -->
                
	              <div class="card-body">
                  <form id="frm-example" action="{{ url('/admin/fix/submit') }}" method="POST">
                    @csrf
                   
                   
                <div>
	                <table id="example1" class="table table-bordered table-striped">
	                  <thead>
	                  <tr>
                      <td>Mã lịch trình</td>
	                    <th>Mã lớp học phần</th>
	                    <th>Phòng học</th>
	                    <th>Ca học</th>
	                    <th>Ngày học</th>
                      <th>Sửa</th>
	                  </tr>
	                  </thead>
	                 <tbody>
                	@foreach($module_classes as $data)
                      <tr>
                      <td> {{$data->ID_Schedules}}</td>
                      <td> {{$data->ID_Module_Class }}</td>
                      <td> {{$data->ID_Room}}</td>
                      <td> {{$data->Shift_Schedules}}</td>
                      <td> {{$data->Day_Schedules}}</td>
                      <td class = " center"><i class="fas fa-eye"></i><a href=""  data-toggle = "modal" data-target="#editModule_Class" data-title = "{{$data->ID_Module_Class}}"
                        data-day = "{{$data->ID_Module_Class}}"
                        onclick = "showPopUP('{{$data->ID_Module_Class}}','{{$data->Day_Schedules}}','{{$data->ID_Schedules}}')" >Sửa</a></td>
                    </tr>
                   
                  @endforeach
                	</tbody> 
	                </table>
                  <nav aria-label = "Page navigation">
                    {!! $module_classes->links() !!}
                   </nav> 
                  </div>
                </form>
	              </div>

	              <!-- /.card-body -->
	            </div>
	            <!-- /.card -->
          </div>
          <!-- Close col-12-->
         </div>
</section>
<div class="modal fade col-md-6" id ="editModule_Class" style = "top: calc(5% ); left: calc(27%); " >
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="modal-header">
              <h4 class="modal-title" id = "tittle">Thay đổi giờ giảng</h3>
             <!--  <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                <span aria-hidden = "true">&times;</i></span>
              </button> -->
            </div>

            <div class="modal-body">
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

              <form action = "submitChange" method = "POST" id = "ChangeForm">
                <input type = "hidden"  name = "_token" value = "{{csrf_token()}}" />

                <div class="form-group">
                  <label for="inputDate">Ngày thay đổi</label>
                  <input type="date" name="inputDate" class="form-control" placeholder="Ngày thay đổi" value = "{{old('inputModule_name')}}" id = "inputDate">
                </div>

                <div class="form-group">
                  <label for="inputShift">Ca thay đổi</label>
                  <input type="number" name="inputShift" class="form-control" placeholder="Ca thay đổi" value = "{{old('inputExercise')}}" id = "inputShift">
                </div>

                <div class="form-group">
                 <!--  <div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="Option_GV" value = "Value_GV1" id = "radioTeacher">
                      <label class="form-check-label">Chọn giảng viên khác</label>
                    </div>
                  </div> -->
                  
                  <div  id = "inputTeacher">
                    <label for="inputTeacher">Giảng viên</label>
                    <select class="form-control custom-select" name = "inputTeacher" >
                      <option selected disabled>Chọn giảng viên</option>
                        @foreach($teacher as $tc)
                          <option value="{{$tc->ID_Teacher}}">{{$tc->Name_Teacher}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputReason">Lý do</label>
                  <input type="text" name="inputReason" class="form-control" placeholder="Lý do" value = "{{old('inputProject')}}" id = "inputReason">
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
    </section>
@section('scripts')
<script>
  function showPopUP($id,$day,$sch) {
    console.log("dayla");
    console.log($id);
    //$("#inputTeacher").remove();
    var sch = $sch;
    console.log(sch);
    var item = `
    <div class="form-group">

      <input type="hidden" name="inputSchedules" class="form-control" placeholder="Mã lớp học phần" value = "${sch}"  >
    </div>
    <div class="row">
              <div class="col-12">
                <a href="{{ url('/admin/fix/thongtin') }}" class="btn btn-secondary">Hủy</a>
                <input type="submit" value="Xác nhận" class="btn btn-success float-right">
              </div>
            </div>
     `;
    $("#ChangeForm").append(item);
    $("#tittle").append(": "+$id+".Ngày: ",$day);
  }
  
  $(document).ready(function() {
    $("#inputTeacher").click(function() {
      console.log(1);
      //$('#editModule_Class').remove();
      $("#inputTeacher").append();
      //$("input:radio").removeAttr("checked");
      
    });
    // $("#ChangeForm").submit(function() {
    //   var date = $("#inputDate").val();
    //   var shift = $("#inputShift").val();
    //   var teacher = $("#inputTeacher").val();
    //   var reason = $("#inputReason").val();
    //   console.log("davao");
    //   console.log(date);
    // })
  });
</script>
@endsection()

@stop()