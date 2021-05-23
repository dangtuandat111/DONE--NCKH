@section('title', 'Trang chủ')



@extends('admin.dashboard')
@section('content')

   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thông báo</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               <table class="table" id="datatable">
              
                  
                 
                  
               
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@stop()