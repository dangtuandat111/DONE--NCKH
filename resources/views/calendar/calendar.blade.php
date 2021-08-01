@section('DeMuc', 'Lịch giảng dạy')

@section('title', 'Lịch')

@extends('admin.dashboard')
@section('content')
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="sticky-top mb-3">
              <pre id="whereToPrint"></pre>
              
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@section('link')
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar/main.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar-daygrid/main.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar-timegrid/main.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar-bootstrap/main.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('AdminLTE-3.0.5/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.0.5/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar/main.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar-interaction/main.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.0.5/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>

<!-- Page specific script -->
<script>
var events = new Array();
$(document).ready(function() {
  function ajaxSchedules() {
    return new Promise(function(resolve) {
      $.ajax({
          type: 'get',
          dataType: 'json',
          url: "{{url('/calendar/')}}",
          success: function(response) {
              console.log(response);
              newEvents = new Array();
              var h = 10, m = 10;
              for (i = 0; i < response.length; i++) {
                  var the_event = {
                      title: (response[i].title),
                      start: new Date(response[i].start),
                      end: new Date(response[i].end),
                      allDay: false,
                      backgroundColor: response[i].backgroundColor,
                      borderColor: "#000000",
                  }
                  events.push(the_event);
              }
            resolve(events)
          }
      });
    });
  }
  
  ajaxSchedules().then(function(events) {
    var event = events;

    function ini_events(ele) {
        ele.each(function() {
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            }
            $(this).data('eventObject', eventObject)
            $(this).draggable({
                zIndex: 1070,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 //  original position after the drag
            })

        })
    }
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
       
        locale: 'vi', // the initial locale. of not specified, uses the first on
        plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridDay'
        },
         buttonText: {
          today: 'Hôm nay',
          month: 'Tháng'
        },
        events : event,
        editable: false,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function(info) {
            // is the "remove after drop" checkbox checked?
            if (checkbox.checked) {
                // if so, remove the element from the "Draggable Events" list
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
        }
    });

    calendar.render();
    })
});
</script>
@endsection


@stop()
