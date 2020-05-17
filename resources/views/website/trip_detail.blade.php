@extends('layout.template')
@section('content')


    <style>
        .dot {
            height: 10px;
            width: 10px;
            background-color: #12af78;
            border-radius: 50%;
            display: inline-block;
        }
        .dot2 {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border-style: solid;
            border-width: 2px;
            border-color: #f4516c;
            background-color: rgba(0, 0, 0, 0);

        }
        .checked {
            color: orange;
        }
        /* Always set the map height explicitly to define the size of the div
            * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>

    <!-- END: Subheader -->
    <div class="m-content" style="
    padding-right: 120px;padding-left: 120px;
">
        <div class="m-portlet">

            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <form action="{{route('search')}}" method="post" >
                                @csrf
                            <input type="hidden" name="search_term" value="{{$term}}">
                            <input type="hidden" name="status" value="{{$status}}">
                            <input type="hidden" name="distance" value="{{$distance}}">
                            <input type="hidden" name="time" value="{{$time}}">
                        <h3 class="m-portlet__head-text text-center">

                            <button  type="submit" style="border: none;background: transparent;cursor: pointer"> <img src="{{asset('img/back.jpg')}}"  width="35" height="35">  </button> Trip Detail
                        </h3>
                        </form>
                    </div>
                </div>

            </div>
            <div class="m-portlet__body">

                    <div class="kt-infobox">
                        <div class="kt-infobox__header">

                            @if(!is_null($trip))
                            <div class="row">
                                <div class="col-md-6">  {{ date('m/d/Y h:i A', strtotime($trip['pickup_date']))}}</div>
                                <div class="col-md-6 text-right"> <span class="fa fa-money-bill-wave"></span> {{$trip['cost'].'    '.$trip['cost_unit']}}<br>

                                </div>

                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-6">     <h5 class="kt-infobox__title"> <span class="dot"></span> {{$trip['pickup_location']}}</h5></div>
                                <div class="col-md-6 text-right">   {{ date('h:i A', strtotime($trip['pickup_date']))}}<br>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">     <h5 class="kt-infobox__title"> <span class="dot2"></span> {{$trip['dropoff_location']}}</h5></div>
                                <div class="col-md-6 text-right">   {{ date('h:i A', strtotime($trip['dropoff_date']))}}<br>

                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="{{$trip['car_pic']}}"><br>
                                    <h3>{{$trip['car_make']}}  {{$trip['car_model']}}</h3>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h4>Distance : {{$trip['distance']}}  {{$trip['distance_unit']}}</h4>
                                    <h4>Duration : {{$trip['duration']}}  {{$trip['duration_unit']}}</h4>
                                    <h4>Sub total : {{$trip['cost']}}  {{$trip['cost_unit']}}</h4>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h3>{{$trip['driver_name']}}  </h3>
                                    <img src="{{$trip['driver_pic']}}"><br><br>
                                    @for($i=0;$i<$trip['driver_rating'];$i++)
                                        <span class="fa fa-star checked"></span>
                                    @endfor
                                    @for($i=0;$i<5-$trip['driver_rating'];$i++)
                                        <span class="fa fa-star "></span>
                                    @endfor

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center" style="height: 500px">

                                    <div id="map_canvas" style="float:left;width:100%;height:60%"></div>



                                </div>
                            </div>
                                @else
                            <h2>Trip not found</h2>
                                @endif

                        </div>

                    </div>

            </div>
        </div>
    </div>


    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry&key=AIzaSyCWOFj2mlY9gDGh2pK8539VFZRgBaed6Sc"></script>

    <script>
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay;
        var arrLatLon = [];
        var homeLatlng;
        var destinationID;

        function initialize() {

            homeLatlng = new google.maps.LatLng({{($trip['pickup_lat']+$trip['dropoff_lat'])/2}},{{($trip['pickup_lng']+$trip['dropoff_lng'])/2}});

            var myOptions = {
                zoom :12,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);



            directionsDisplay = new google.maps.DirectionsRenderer({
                draggable: false,
                map: map,


            });

            arrLatLon[1] = new google.maps.LatLng( {{$trip['pickup_lat']}} , {{$trip['pickup_lng']}} );
            arrLatLon[2] =  new google.maps.LatLng( {{$trip['dropoff_lat']}} , {{$trip['dropoff_lng']}} );




            calcRoute(1);
        }



        function calcRoute(id) {
            var selectedMode = 'DRIVING';
            var selectedUnits = 'METRIC';

            if(typeof(id) != "undefined"){
                destinationID = id;
            }

            var request = {
                origin:homeLatlng,
                destination:arrLatLon[destinationID],
                travelMode: google.maps.DirectionsTravelMode[selectedMode],
                unitSystem: google.maps.UnitSystem[selectedUnits]
            };

            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                }
            });
        }



        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@stop
