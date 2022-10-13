<?php

use App\Models\Property;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/upsert', function () {
    $properties = [];
    $response = Http::get("https://trial.craig.mtcserver15.com/api/properties?page[number]=120&page[size]=100&api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug");
    while(!empty($response['next_page_url'])) {
        $properties = [...$properties, ...$response->json()['data']];
        $response = Http::get($response['next_page_url']);
    }
    foreach($properties as $property) {
        $property['postcode'] = array_reverse(explode(' ', $property['address']))[0];
        $property['postcode'] = is_numeric($property['postcode']) ? $property['postcode'] : NULL;
        $property['property_type'] = $property['property_type']['title'];
        $property['for_sale'] =  ($property['type'] === 'sale') ? 1 : 0;
        $db_property = Property::where('uuid', '=', $property['uuid'])->first();
        if (!empty($db_property)) {
            if ($db_property->updated_at->timestamp < strtotime($property['updated_at'])) 
            {
                $property = Arr::only($property, ["uuid","county","country","town","postcode","description","image_full","image_thumbnail","address","latitude","longitude",'num_bedrooms','num_bathrooms',"price","property_type","for_sale","for_rent"]);
                $db_property->update($property);
            }
        } else {
            $property['created_at'] =  now();
            $property['updated_at'] =  now();
            $property = Arr::only($property, ["uuid","county","country","town","postcode","description","image_full","image_thumbnail","address","latitude","longitude",'num_bedrooms','num_bathrooms',"price","property_type","for_sale","for_rent","created_at","updated_at"]);
            DB::table('properties')->insert($property);
        }
    }
    dd('done');
    return $properties;
    // return $response;
    // return view('app');
});

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
