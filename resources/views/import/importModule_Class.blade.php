@section('DeMuc', 'Import')
@section('title', 'Lớp Học Phần')

@extends('admin.dashboard')
@section('content')



<section class="content">

      @if(session('thongbao')) 
          <div class = "alert alert-success">
             {{session('thongbao')}}
          </div>
      @endif

      @if(count($errors) > 0) 
          <div class = "alert alert-danger">
              @foreach($errors->all() as $err)
                {{$err}}<br>
              @endforeach
          </div>
      @endif

  <div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Thêm lớp học phần</h3>
          <div class="card-tools"></div>
        </div>
        <div class="card-body">
          <!-- <div class="row" style = "margin-bottom: 10px;"><div class = "col-6"><select id="select_NamHoc" class = "custom-select"><option value ="">Chọn năm học</option><option value = "1-20">1-20</option><option value = "2-20">2-20</option><option value = "1-21">1-21</option><option value = "2-21">2-21</option><option value = "1-22">1-22</option><option value = "2-22">2-22</option><option value = "1-23">1-23</option><option value = "2-23">2-23</option></select></div><div class = "col-3"><select id="select_DotHoc" class = "custom-select"><option value ="">Chọn đợt học</option>
                        @for ($i = 1; $i <= 5; $i++)
                           <option value="{{ $i }}">{{ $i }}</option>
                        @endfor 
                    </select></div></div> -->
          <!-- <a class="btn btn-primary" id = 'CheckButton' style = "color: white;">Kiểm tra lịch trình</a><br><br> -->
          <a class="btn btn-primary" data-toggle="modal" href='#modal-add'>Nhập tệp tin</a>
          <br>
          <br>
          <div class="modal fade" id="modal-add">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                  <form action="{{ url('/admin/import/lophocphan') }}" method="POST" role="form" enctype="multipart/form-data">
                    <legend>FILE</legend> @csrf <div class="form-group">
                      <input type="file" class="form-control" name="lophocphan" id="lophocphan" placeholder="Input field">
                    </div>
                    <button type="submit" class="btn btn-primary" id="ButtonSubmit">Gửi</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>

</section>

@section('scripts')
<script>
   $(document).ready(function() {
      $( "#ButtonSubmit" ).on( "click", function( event ) {
        console.log('1');
      });
   });

</script>
@endsection
@stop()