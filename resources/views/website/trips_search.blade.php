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
</style>

    <!-- END: Subheader -->
    <div class="m-content" style="
    padding-right: 120px;padding-left: 120px;
">
        <div class="m-portlet">

            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">

                        <h3 class="m-portlet__head-text text-center">
                           <a href="../"> <img width="35" height="35" src="{{asset('img/back.jpg')}}"></a> Trips({{count($trips)}})
                        </h3>
                    </div>
                </div>

            </div>
            <div class="m-portlet__body">
                @if(count($trips)>0)
                @foreach($trips as $trip)
                <div class="kt-infobox">
                    <div class="kt-infobox__header">
                      <div class="row">
                          <div class="col-md-6">  <h5>{{ date('m/d/Y h:i A', strtotime($trip['pickup_date']))}}</h5></div>
                          <div class="col-md-6 text-right"><h5>{{$trip['cost'].'    '.$trip['cost_unit']}}</h5><br>
                              @for($i=0;$i<$trip['driver_rating'];$i++)
                                  <span class="fa fa-star checked"></span>
                              @endfor
                              @for($i=0;$i<5-$trip['driver_rating'];$i++)
                                  <span class="fa fa-star "></span>
                              @endfor

                          </div>
                      </div>
                         <h5 class="kt-infobox__title"> <span class="dot"></span> {{$trip['pickup_location']}}</h5>
                        <h5 class="kt-infobox__title"> <span class="dot2"></span> {{$trip['dropoff_location']}}</h5>
                        <div class="row">
                            <div class="col-md-6"><a  href="{{route('trip-detail',$trip['id'])}}" class="btn btn-primary">Check Trip</a>  </div>
                            <div class="col-md-6 text-right">@if($trip['status']=='COMPLETED') <h2>COMPLETED <img width="75" height="75" src="{{asset('img/check.png')}}"></h2>  @else <h2 style="color: #f4516c">CANCELED <img width="75" height="75" src="{{asset('img/none.png')}}">  </h2>  @endif</div>
                        </div>

                    </div>

                </div>
                    <hr>
                    @endforeach
                    @else
                <h2 class="text-center">No Trips Found.</h2>
                @endif
            </div>
        </div>
    </div>

@stop
