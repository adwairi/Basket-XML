@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row" >
                        <form action="{{ route('manipulator') }}" id="form">
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <label>Hotel Name:</label>
                                <input name="HotelName" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label>Rating</label>
                                <select name="HotelRating" class="form-control">
                                    <option value="">select</option>
                                    @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}">{{ $i }} star</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Is Ready:</label>
                                <input type="checkbox" name="IsReady" class="form-control" value="true" />
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
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        getData();
    });

//    $(document).on('change', 'form-control', function () {
//        getData();
//    })
    $('.form-control').change(function () {
        getData();
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

</script>
@endsection