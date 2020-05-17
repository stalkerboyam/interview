<?php

namespace Tests\Unit;

use Tests\TestCase;

class AppTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    function it_displays_the_index_page(){

        $response = $this->get('/');

        $response->assertStatus(200);
    }




    public function test_search_with_keyword()
    {
        //search in application
        $keyword_search = array('March','George','Richard','Nissan','Koinange','Nextgen');
        $distance_search = array(0,3,8,15,16);
        $time_search = array(0,5,10,20,21);
        $status_search = array('on','');
        $term =$keyword_search[array_rand($keyword_search)];
        $distance = $distance_search[array_rand($distance_search)];
        $time=$time_search[array_rand($time_search)];
        $status=$status_search[array_rand($status_search)];
        $response = $this->post('/search',[
            'search_term'=>$term,
            'status'=>$status,
            'time'=>$time,
            'distance'=>$distance
        ]);
       $data = $response->getOriginalContent()->getData();

       //search in api

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
        $data2 = json_decode($datos, true);

        $collection = collect($data2['trips']);

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


        $this->assertCount($filtered->count(),$data['trips']);

        //go and view trip page
        $single_trip=$filtered->random();

        $trip_page = $this->get('trips/'.$single_trip['id']);
        $single_trip_content=  $trip_page->getOriginalContent()->getData()['trip'] ;
        $trip_page->assertOk();
        //compare data between page and api

        if ($single_trip['status']==$single_trip_content['status']&&
            $single_trip['request_date']==$single_trip_content['request_date']&&
            $single_trip['pickup_lat']==$single_trip_content['pickup_lat']&&
            $single_trip['pickup_lng']==$single_trip_content['pickup_lng']&&
            $single_trip['pickup_location']==$single_trip_content['pickup_location']&&
            $single_trip['dropoff_lat']==$single_trip_content['dropoff_lat']&&
            $single_trip['dropoff_lng']==$single_trip_content['dropoff_lng']&&
            $single_trip['pickup_location']==$single_trip_content['pickup_location']&&
            $single_trip['dropoff_location']==$single_trip_content['dropoff_location']&&
            $single_trip['pickup_date']==$single_trip_content['pickup_date']&&
            $single_trip['dropoff_date']==$single_trip_content['dropoff_date']&&
            $single_trip['type']==$single_trip_content['type']&&
            $single_trip['driver_id']==$single_trip_content['driver_id']&&
            $single_trip['driver_name']==$single_trip_content['driver_name']&&
            $single_trip['driver_rating']==$single_trip_content['driver_rating']&&
            $single_trip['driver_pic']==$single_trip_content['driver_pic']&&
            $single_trip['car_make']==$single_trip_content['car_make']&&
            $single_trip['car_model']==$single_trip_content['car_model']&&
            $single_trip['car_number']==$single_trip_content['car_number']&&
            $single_trip['car_year']==$single_trip_content['car_year']&&
            $single_trip['car_pic']==$single_trip_content['car_pic']&&
            $single_trip['duration']==$single_trip_content['duration']&&
            $single_trip['duration_unit']==$single_trip_content['duration_unit']&&
            $single_trip['distance']==$single_trip_content['distance']&&
            $single_trip['distance_unit']==$single_trip_content['distance_unit']&&
            $single_trip['cost']==$single_trip_content['cost']&&
            $single_trip['cost_unit']==$single_trip_content['cost_unit']

        ){
            $this->assertTrue(true);
        }
        else
            $this->assertTrue(false);




    }


}
