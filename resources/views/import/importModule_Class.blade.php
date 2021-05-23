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

                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                 <a class="btn btn-primary" data-toggle="modal" href='#modal-add'>Nhập tệp tin</a><br><br>
                 <div class="modal fade" id="modal-add">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">

                            <form action="{{ url('/admin/import/lophocphan') }}" method="POST" role="form" enctype="multipart/form-data">
                                <legend>FILE</legend>
                                @csrf
                                <div class="form-group">
                                    <input type="file" class="form-control" name="lophocphan" id="lophocphan" placeholder="Input field">
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi</button>
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

@stop()