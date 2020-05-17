@extends('layout.template')
@section('content')



    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet">

            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text text-center">
                            Trip Search
                        </h3>
                    </div>
                </div>

            </div>
            <div class="m-portlet__body">

                <!--begin::Section-->
                <div class="m-section">

                    <div class="m-section__content">
                        <form class="kt-form" method="post" action="{{route('search')}}">
                            @csrf
                        <div class="form-group">
                            <label>Keyword</label>
                            <input type="text" name="search_term" class="form-control" value="{{ $search_term }}  " >
                        </div>
                        <div class="form-group ">
                            <div class="col-9">
                                <div class="kt-checkbox-inline">
                                    <label class="kt-checkbox" >
                                        <input type="checkbox" name="status" @if($status=='on') checked @endif > Include canceled trips
                                        <span></span>
                                    </label>

                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">   <label><h4>Distance</h4></label>
                                <div class="kt-radio-list">
                                    <label class="kt-radio">
                                        <input type="radio" name="distance" value="0" checked> Any
                                        <span></span>
                                    </label><br>

                                    <label class="kt-radio">
                                        <input type="radio" name="distance" value="3" @if($distance==3) checked @endif > Under 3 km
                                        <span></span>
                                    </label><br>

                                    <label class="kt-radio">
                                        <input type="radio" name="distance" value="8" @if($distance==8) checked @endif> 3 to 8 km
                                        <span></span>
                                    </label><br>
                                    <label class="kt-radio">
                                        <input type="radio" name="distance" value="15" @if($distance==15) checked @endif> 8 to 15 km
                                        <span></span>
                                    </label><br>
                                    <label class="kt-radio">
                                        <input type="radio" name="distance" value="16" @if($distance==16) checked @endif> More than 15 km
                                        <span></span>
                                    </label>
                                </div></div>
                            <div class="col-md-6"> <label><h4>Time</h4></label>
                                <div class="kt-radio-list">
                                    <label class="kt-radio">
                                        <input type="radio" name="time" checked> Any
                                        <span></span>
                                    </label><br>

                                    <label class="kt-radio">
                                        <input type="radio" name="time" value="5" @if($time==5) checked @endif> Under 5 min
                                        <span></span>
                                    </label><br>

                                    <label class="kt-radio">
                                        <input type="radio" name="time" value="10" @if($time==10) checked @endif> 5 to 10 min
                                        <span></span>
                                    </label><br>
                                    <label class="kt-radio">
                                        <input type="radio" name="time" value="20" @if($time==20) checked @endif> 10 to 20 min
                                        <span></span>
                                    </label><br>
                                    <label class="kt-radio">
                                        <input type="radio" name="time" value="21" @if($time==21) checked @endif> More than 20 min
                                        <span></span>
                                    </label>
                                </div></div>



                        </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions text-center">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!--end::Section-->


            </div>
        </div>
    </div>

@stop
