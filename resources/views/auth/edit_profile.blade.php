@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Edit Profile</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">                               
            <div class="box" style="padding: 50px;">                    
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-1">
                            @if (session('error'))
                                <div class="alert alert-danger col-md-offset-4 col-md-6">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success col-md-offset-4 col-md-6">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form class="form-horizontal" method="POST" action="{{ route('editProfile') }}">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Name</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" required>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="email" class="col-md-4 control-label">Email</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>                       
                </div>  
            </div>
        </div>
    </div>
@endsection