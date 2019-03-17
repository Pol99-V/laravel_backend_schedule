@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Schedule Management</h1>
@stop

@section('content')            
    <div class="row">           
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Draggable Events</h4>
                </div>
                <div class="box-body">
                    <!-- the events -->
                    <div id="external-events">
                        @foreach ($events as $event)
                        <div class="external-event" data-id="{{ $event->id }}" style="background-color: {{ $event->color }}">{{ $event->title }}</div>
                        @endforeach
                        <div class="checkbox">
                            <label for="drop-remove">
                            <input type="checkbox" id="drop-remove">
                            remove after drop
                            </label>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Event</h3>
                </div>
                <div class="box-body">
                    <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                    <ul class="fc-color-picker" id="color-chooser">
                        <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                    </ul>
                    </div>
                    <!-- /btn-group -->
                    <div class="input-group">
                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                    <div class="input-group-btn">
                        <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
                    </div>
                    <!-- /btn-group -->
                    </div>
                    <!-- /input-group -->
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-8">
            <div class="box box-primary">
            <div class="box-body">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->           
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.print.css" media="print">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
    
    <style>
        .removebtn {
            color: white;
            position: absolute;
            top: 0;
            right: 2px;            
            text-align:center;
            font-size: 10px;
            cursor: pointer;
            z-index: 99;            
        }
        .fc-saveButton-button {
            background-color: #17a2b8;
            background-image: none;
            color: white;
        }
        .fc-saveButton-button:hover {
            background-color: #148c9f;
        }
       
    </style>
@stop

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
<script src="js/bootstrap-notify.min.js"></script>
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })
        $(this).append( "<span class='removebtn'>X</span>" );
        $('.removebtn', $(this)).click(function() {
          var parent =  $(this).closest('.external-event');
          parent.remove();
          $.ajax({
              url: "{{ route('deleteScheduleEvent') }}",
              data: {
                  id: parent.attr("data-id")
              },
              success: function(response) {
                console.log(response);
              }  
          });          
        });
      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/

    function getDateFromWeek(dayOfWeek, _time) {
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear(),
            c_dw   = date.getDay(), // current day
            deltaDay_fromCurrent = c_dw ? 6 - c_dw : -1, // end of week
            lastDay = +date + deltaDay_fromCurrent * 3600000 * 24,

            delta = dayOfWeek ? 6 - dayOfWeek : -1,
            dateValue = lastDay - delta * 3600000 * 24,
            date1 = new Date(dateValue),
            d1    = date1.getDate(),
            m1    = date1.getMonth(),
            y1    = date1.getFullYear(),
            hm    = _time.split(":")

        return new Date(y1,m1,d1,+hm[0],+hm[1])
    } 
    //Date for the calendar events (dummy data)    
    
    $('#calendar').fullCalendar({
      customButtons: {
        saveButton: {
            text: 'Save',
            click: function() {
                var events = $('#calendar').fullCalendar('clientEvents')
               
                var promises = []
                events.forEach(function(item) {
                    var start = item.start._i.length ? item.start._i[3]+":"+item.start._i[4] : moment(item.start._d).format("HH:mm")
                    var end
                    if (item.end) {
                        end = item.end._i.length ? item.end._i[3]+":"+item.end._i[4] : moment(item.end._d).format("HH:mm")
                    }  
                    promises.push( 
                        $.ajax({
                            url: "{{ route('updateSchedule') }}",
                            data: {
                                id: item._id,
                                start: start,
                                end: end ? end : start,
                                dayOfWeek: item.start._d.getDay()
                            }
                        })
                   )                   
                })
                $.when(promises).done(function(results) {
                    $.notify({
                        message: "Success Update"
                    },{
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        offset: 10,
                        spacing: 0,
                        delay: 2000,
	                    timer: 1000,
                    })                
                })
              
            }
        }
      },
      header    : {
        left  : '',
        center: '',
        right : 'saveButton'
      },
      defaultView: 'agendaWeek',
      columnHeaderFormat : 'ddd',
      allDaySlot: false,
      firstDay: 1 ,
      scrollTime: "00:00:00",
      //Random default events
      events    : [      
        @foreach ($schedules as $schedule)
        {
            _id             : "{{ $schedule->id }}"  ,
            title           : "{{ $schedule->title }}" ,
            start           : getDateFromWeek(+"{{ $schedule->dayOfWeek }}", "{{ $schedule->start }}" ) ,
            end             : getDateFromWeek(+"{{ $schedule->dayOfWeek }}", "{{ $schedule->end }}" ) ,
            backgroundColor : "{{ $schedule->color }}", 
            borderColor     : "{{ $schedule->color }}" 
        },        
        @endforeach
      ],
      eventRender: function(event, element) {
        element.append( "<span class='removebtn'>X</span>" );
        $('.removebtn', element).click(function() {
          $('#calendar').fullCalendar('removeEvents',event._id);
          $.ajax({
                url: "{{ route('deleteSchedule') }}",
                data: {
                    'id' : event._id
                },
                success: function(response) {
                    console.log(response)               
                }
            })
        });
      },      
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped
       // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

        var events = $('#calendar').fullCalendar('clientEvents');
        $.ajax({
            url: "{{ route('createSchedule') }}",
            data: {
                'id' : events[events.length - 1]._id,
                'schedule_event_id' : $(this).attr("data-id"),
                'start' : date.format("HH:mm"),
                'end' : date.add(2,"hours").format("HH:mm"),
                'dayOfWeek' : date.day()
            },
            success: function(response) {
                console.log(response)               
            }
        })
        
      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')      

      $.ajax({
        url: "{{ route('createScheduleEvent') }}",
        data: {
            'title': val,
            'color': currColor
        },
        success: function(data, status, xhr) {
            event.css({
                'background-color': currColor,
                'border-color'    : currColor,
                'color'           : '#fff'
            }).addClass('external-event')
            event.attr("data-id", data.result.id);
            event.html(val)
            $('#external-events').prepend(event)

            //Add draggable funtionality
            init_events(event)

            //Remove event from text input
            $('#new-event').val('')
        }  
      });
    })
  })
</script>
@stop
