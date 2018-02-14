@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel-heading-controls pull-right">
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" id="APIRegisterBtn" data-target="#modal-APILogin">API Register</button>
        </div>
        <div class="panel-heading-controls pull-right">
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" id="APILoginBtn" data-target="#modal-APILogin">API Login</button>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" >
                        <form action="{{ route('manipulator') }}" id="form">
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <label>Hotel Name:</label>
                                <input name="HotelName" class="form-control filter" />
                            </div>
                            <div class="col-md-3">
                                <label>Rating</label>
                                <select name="HotelRating" class="form-control filter">
                                    <option value="">select</option>
                                    @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}">{{ $i }} star</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Is Ready:</label>
                                <input type="checkbox" name="IsReady" class="form-control filter" value="true" />
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="panel-heading">
                        <div class="col-md-1"><b>ID</b></div>
                        <div class="col-md-4"><b>Hotel Name</b></div>
                        <div class="col-md-2"><b>Location</b></div>
                        <div class="col-md-1"><b>Rating</b></div>
                        <div class="col-md-1"><b>Ready</b></div>
                        <div class="col-md-1"><b>Price</b></div>
                        <div class="col-md-1"><b>Currency</b></div>
                        <div class="col-md-1"><b>Recommended</b></div>
                    </div>
                </div>
                <div class="panel panel-default" id="hotels">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade pull-right" id="modal-APILogin" tabindex="-1" style="display: inline-table;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title" id="myModalLabel">API</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="APILoginForm" method="POST" action="{{ route('APILogin') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" method="POST" id="APIRegisterForm" action="{{ route('APIRegister') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email1" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email1" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password1" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password1" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                </form>

                <button class="btn btn-primary pull-right" id="APIRegister">
                    Regiter
                </button>
                <button class="btn btn-primary pull-right" id="APILogin">
                    Login
                </button>
                <textarea class="form-control" id="token"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        getData();
    });
    $('.filter').change(function () {
        getData();
    });

    $('#APIRegisterBtn').click(function () {
//        $('#APILoginForm').hide();
        $("#APILoginForm").css("display","none");
        $("#APILogin").css("display","none");
        $('#APIRegisterForm').show();
        $('#APIRegister').show();
    });
    $('#APILoginBtn').click(function () {
        $('#APILoginForm').show();
        $('#APILogin').show();
//        $('#APIRegister').hide();
        $("#APIRegisterForm").css("display","none");
        $("#APIRegister").css("display","none");

    });

    function getData() {
        var data = $('#form').serializeArray();
        $.ajax({
            url: '{{ route("manipulator") }}',
            type: 'POST',
            data: data,
            dataType: 'xml',
        }).done(function(data) {
            console.log(data);
            $("#hotels").empty();
            var html = '';
            $(data).find('hotels hotel').each(function(){
                var hotelID = $(this).attr('id');

                    html += '<div class="panel-heading">';
                        html += '<h4 class="panel-title">';
                            html += '<div class="col-md-1"><a data-toggle="collapse" href="#hotel'+hotelID+'"><i class="glyphicon glyphicon-plus"></i></a>' + $(this).attr('id') + '</div>';
                            html += '<div class="col-md-4">' + $(this).attr('HotelName') + '</div>';
                            html += '<div class="col-md-2">' + $(this).attr('location') + '</div>';
                            html += '<div class="col-md-1">' + $(this).attr('HotelRating') + '</div>';
                            html += '<div class="col-md-1">' + $(this).attr('IsReady') + '</div>';
                            html += '<div class="col-md-1">' + $(this).attr('price') + '</div>';
                            html += '<div class="col-md-1">' + $(this).attr('currency') + '</div>';
                            if ($(this).attr('isRecommended') == null){
                                $(this).attr('isRecommended','0');
                            }
                            html += '<div class="col-md-1">' + $(this).attr('isRecommended') +'</div>';
                        html += '</h4>';
                        html += '<br/>';
                    html += '</div>';
                    html += '<div id="hotel'+hotelID+'" class="panel-collapse collapse">';
                        html += '<div class="panel-heading">';
                            html += '<div class="col-md-3"><b>Room ID</b></div>';
                            html += '<div class="col-md-3"><b>Room Name</b></div>';
                            html += '<div class="col-md-3"><b>Occupancy</b></div>';
                            html += '<div class="col-md-3"><b>Status</b></div>';
                        html += '</div><hr>';
                        $(this).find("rooms room").each(function () {
                            html += '<div class="panel-body">';
                                html += '<div class="col-md-3">' + $(this).find('id').text() + '</div>';
                                html += '<div class="col-md-3">' + $(this).find('name').text() + '</div>';
                                html += '<div class="col-md-3">' + $(this).find('occupancy').text() + '</div>';
                                html += '<div class="col-md-3">' + $(this).find('status').text() + '</div>';
                            html += '</div>';
                        });
                    html += '</div>';
            });
            $("#hotels").append(html);

        });

    }
    
    
    $('#APILogin').click(function () {
        var data = $('#APILoginForm').serializeArray();
        $.ajax({
            url: '{{ route("APILogin") }}',
            type: 'POST',
            data: data,
            dataType: 'json',
        }).done(function(data) {
            $('#token').text(data.token);
        });
    });

    $('#APIRegister').click(function () {
        var data = $('#APIRegisterForm').serializeArray();
        $.ajax({
            url: '{{ route("APIRegister") }}',
            type: 'POST',
            data: data,
            dataType: 'json',
        }).done(function(data) {
            $('#token').text(data.token);
        });
    });

</script>
@endsection