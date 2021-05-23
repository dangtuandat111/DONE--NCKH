@section('DeMuc', 'Lịch giảng dạy')

@section('title', 'Lịch')

@extends('admin.dashboard')
@section('content')
<section class="content">
	@if(session('thongbao')) 
	<div class = "alert alert-success">
			{{session('thongbao')}}
	</div>
	@endif
	<div class = "container-fluid">
    <!--  <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Them bo loc</h3>
                <div class="card-tools">
                </div>
              </div>
              <div class="card-body">
                <form action="{{ url('/fullcalendar1') }}" method="GET" id="filter"> -->
                  <!--{{ url('/fullCalendar/filter') }}
                  <button type="submit" class="btn btn-primary">Search</button>
                </form> 
              </div>
        </div>
      </div>
    </div> -->
    	<div class="response"></div>
    	<div id='calendar'></div> 
  </div> 
 
</section>

@section('link')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" />
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
<script>
  $(document).ready(function () {
        var SITEURL = "{{url('/')}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: SITEURL + "/calendar",
            displayEventTime: true,
            
            editable: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: false,
            selectHelper: false
        });
    });
</script>
@endsection


@stop()
