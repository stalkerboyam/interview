<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripController extends Controller
{

    public function index(Request $request){

        $term = $request->session()->get('search_term');
        $status = $request->session()->get('status');
        $distance = $request->session()->get('distance');
        $time = $request->session()->get('time');
        return view('website.index',['search_term'=>$term,'status'=>$status,'distance'=>$distance,'time'=>$time]);
    }
    public function search(Request $request){


        $term = $request->search_term;
        $status=$request->status;
        $distance=$request->distance;
        $time=$request->time;

        //store values in Session
        $request->session()->put('search_term', $term);
        $request->session()->put('status', $status);
        $request->session()->put('distance', $distance);
        $request->session()->put('time', $time);


        if ($distance==3){//under 3
            $limit_distance_min = 0;
            $limit_distance_max = 3;
            }
        elseif ($distance==8){
            $limit_distance_min = 3;
            $limit_distance_max = 8;
        }
        elseif ($distance==15){
            $limit_distance_min = 8;
            $limit_distance_max = 15;
        }
        elseif ($distance==16){
            $limit_distance_min = 15;
            $limit_distance_max = PHP_INT_MAX;

        }
        else{
            $limit_distance_min = 0;
            $limit_distance_max = PHP_INT_MAX;
        }



        if ($time==5){//under 5
            $limit_time_min = 0;
            $limit_time_max = 5;
        }
        elseif ($distance==10){
            $limit_time_min = 5;
            $limit_time_max = 10;
        }
        elseif ($distance==20){
            $limit_time_min = 10;
            $limit_time_max = 20;
        }
        elseif ($distance==21){
            $limit_time_min = 20;
            $limit_time_max = PHP_INT_MAX;

        }
        else{
            $limit_time_min = 0;
            $limit_time_max = PHP_INT_MAX;
        }


         $url = 'https://hr.hava.bz/trips/recent.json';
        $datos = file_get_contents($url);
        $data = json_decode($datos, true);

        $collection = collect($data['trips']);

        if ($term){
        $filtered = $collection->filter(function ($value) use ($term){

            return  (false !== stristr($value['dropoff_location'], $term) ||
                false !== stristr($value['pickup_location'], $term) ||
                false !== stristr($value['driver_name'], $term) ||
                false !== stristr($value['car_make'], $term) ||
                false !== stristr($value['car_model'], $term) ||
                false !== stristr($value['car_number'], $term) ||
                false !== stristr($value['car_year'], $term)
                 );
        });
        }
        else
            $filtered =$collection;

        if ($status=='on')
            $filtered=$filtered->whereBetween('distance',[$limit_distance_min,$limit_distance_max])
                ->whereBetween('duration',[$limit_time_min,$limit_time_max]);

        else
            $filtered=$filtered->where('status','COMPLETED')
                ->whereBetween('distance',[$limit_distance_min,$limit_distance_max])
                ->whereBetween('duration',[$limit_time_min,$limit_time_max]);

        return view('website.trips_search',['trips'=>$filtered]);
    }

    public function trip_detail($id,Request $request){
        //session values
        $term = $request->session()->get('search_term');
        $status = $request->session()->get('status');
        $distance = $request->session()->get('distance');
        $time = $request->session()->get('time');

        $url = 'https://hr.hava.bz/trips/recent.json';
        $datos = file_get_contents($url);
        $data = json_decode($datos, true);

        $collection = collect($data['trips']);
        $trip = $collection->firstWhere('id',$id);


        return view('website.trip_detail',['trip'=>$trip,'term'=>$term,'status'=>$status,'distance'=>$distance,'time'=>$time]);
    }
}
