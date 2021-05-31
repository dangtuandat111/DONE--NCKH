@section('DeMuc', 'Học Phần')
@section('title', 'Học Phần')

@extends('admin.dashboard')
@section('content')

<section class="content">
    <div class="row">
        <div class="col-md-12">
          	<div class="card card-primary">
            	<div class="card card-primary">
            		<div class="card-header">
            			<h3 class="card-title">Sửa học phần</h3>
            		</div>
            	</div>
             </div>

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
            	
				@foreach($modules as $bm)
              		<form action = "{{$bm->ID_Module}}" method = "POST">
	              		<input type = "hidden"  name = "_token" value = "{{csrf_token()}}" />

		            	<div class="form-group">
		            		<label for="inputID_module">Mã học phần</label>
		                	<input type="text" name="inputID_module" class="form-control" placeholder="{{$modules->get('ID_Module') }}" value="{{$bm->ID_Module}}">
		           		 </div> 

		           		<div class="form-group">
			                <label for="inputName">Kỳ học</label>
			                <input type="number" name="inputSemester" class="form-control" placeholder="Kỳ học" value = "{{$bm->Semester}}">
		            	</div>

			            <div class="form-group">
			                <label for="inputName">Số tín chỉ</label>
			                <input type="number" name="inputCredits" class="form-control" placeholder="Số tín chỉ" value = "{{$bm->Credit}}">
			            </div>

			            <div class="form-group">
			                <label for="inputName">Tên học phần</label>
			                <input type="text" name="inputModule_name" class="form-control" placeholder="Tên học phần" value = "{{$bm->Module_Name}}">
			            </div>

			            <div class="form-group">
			                <label for="inputName">Số tiết lý thuyết</label>
			                <input type="number" name="inputTheory" class="form-control" placeholder="Lý thuyết" value = "{{$bm->Theory}}">
			            </div>

			            <div class="form-group">
			                <label for="inputName">Số tiết bài tập</label>
			                <input type="number" name="inputExercise" class="form-control" placeholder="Bài tập" value = "{{$bm->Exercise}}">
			            </div>

			            <div class="form-group">
			                <label for="inputName">Số tiết thực hành</label>
			                <input type="number" name="inputPractice" class="form-control" placeholder="Thực hành" value = "{{$bm->Practice}}">
			            </div>

			            <div class="form-group">
			                <label for="inputName">Số tiết bài tập lớn</label>
			                <input type="number" name="inputProject" class="form-control" placeholder="Bài tập lớn" value = "{{$bm->Project}}">
			            </div>

			            <div class="form-group">
			                <label for="inputID_department">Bộ môn</label>
			                <select class="form-control custom-select" name = "inputID_department" >
			                  	<option selected disabled >Chọn bộ môn</option>
				                	@foreach($department as $dp)
				                		<option value="{{$dp->ID_Department}}" >{{$dp->Department_Name}}</option>
				                	@endforeach
			                </select>
			            </div>
			            @endforeach
			            <div class="row">
					        <div class="col-12">
					          <a href="{{ url('/admin/hocphan/thongtin') }}" class="btn btn-secondary">Hủy</a>
					          <input type="submit" value="Sửa" class="btn btn-success float-right">
					        </div>
					    </div>
             		</form>
             	
            </div>
        </div>
    </div>
</section>
@stop()