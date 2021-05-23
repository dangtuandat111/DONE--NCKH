@section('DeMuc', 'Học Phần')
@section('title', 'Học Phần')

@extends('admin.dashboard')
@section('content')

<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
            	<h3 class="card-title">Thêm học phần</h3>
              <div class="card-tools">
                
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

              <form action = "them" method = "POST">
              	<input type = "hidden"  name = "_token" value = "{{csrf_token()}}" />
	              <div class="form-group">
	                <label for="inputID_module">Mã học phần</label>
	                <input type="text" name="inputID_module" class="form-control" placeholder="Nhập vào mã học phần" value = "{{old('inputID_module')}}" >
	              </div>

	              <div class="form-group">
	                <label for="inputName">Kỳ học</label>
	                <input type="number" name="inputSemester" class="form-control" placeholder="Kỳ học" value = "{{old('inputSemester')}}">
	              </div>

	              <div class="form-group">
	                <label for="inputName">Số tín chỉ</label>
	                <input type="number" name="inputCredits" class="form-control" placeholder="Số tín chỉ" value = "{{old('inputCredits')}}">
	              </div>

	              <div class="form-group">
	                <label for="inputName">Tên học phần</label>
	                <input type="text" name="inputModule_name" class="form-control" placeholder="Tên học phần" value = "{{old('inputModule_name')}}">
	              </div>

	              <div class="form-group">
	                <label for="inputName">Số tiết lý thuyết</label>
	                <input type="number" name="inputTheory" class="form-control" placeholder="Lý thuyết" value = "{{old('inputTheory')}}">
	              </div>

	              <div class="form-group">
	                <label for="inputName">Số tiết bài tập</label>
	                <input type="number" name="inputExercise" class="form-control" placeholder="Bài tập" value = "{{old('inputExercise')}}">
	              </div>

	              <div class="form-group">
	                <label for="inputName">Số tiết thực hành</label>
	                <input type="number" name="inputPractice" class="form-control" placeholder="Thực hành" value = "{{old('inputPractice')}}">
	              </div>

	              <div class="form-group">
	                <label for="inputName">Số tiết bài tập lớn</label>
	                <input type="number" name="inputProject" class="form-control" placeholder="Bài tập lớn" value = "{{old('inputProject')}}">
	              </div>

	              <div class="form-group">
	                <label for="inputID_department">Bộ môn</label>
	                <select class="form-control custom-select" name = "inputID_department">
	                  <option selected disabled>Chọn bộ môn</option>
		                	@foreach($department as $bm)
		                	
                				<option value="{{$bm->ID_Department}}">{{$bm->Department_Name}}</option>

		                	@endforeach
	                </select>
	              </div>

	              <div class="row">
			        <div class="col-12">
			          <a href="{{ url('/admin/hocphan/thongtin') }}" class="btn btn-secondary">Hủy</a>
			          <input type="submit" value="Thêm mới" class="btn btn-success float-right">
			        </div>
			      </div>
             	</form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
    </section>
    <!-- /.content -->
@stop()