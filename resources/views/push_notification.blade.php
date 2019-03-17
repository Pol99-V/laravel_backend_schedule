@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Push Notification</h1>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">                               
        <div class="box box-primary" style="padding: 50px;">                    
                <div class="box-header with-border">
                    <h3 class="box-title">Send a new Push Message</h3>
                </div>
                 <!-- form start -->
                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter ..." required> 
                        </div>
                         <!-- textarea -->
                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="form-control" name="content" rows="3" placeholder="Enter ..." required></textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Send Push Notification</button>
                    </div>
                </form>       
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
@stop

@section('js')
<script src="js/bootstrap-notify.min.js"></script>
<script>
  $(function () {
      $("form").submit(function(e){
          e.preventDefault();
          e.stopPropagation();
          $.ajax({
              url: "{{ route('pushNotification') }}",
              data: {
                  title: $("[name='title']").val(),
                  content: $("[name='content']").val()
              },
              success: function(response) {
                $.notify({
                    message: "Success - " + response.result.success + "<br>Failuer - " + response.result.failure
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
              }
          })
          return
        })
  })
</script>
@endsection
