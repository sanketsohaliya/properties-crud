<?php
namespace App\Http\Controllers;
use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all()->toArray();
        return array_reverse($properties);      
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'county' => 'required',
            'country' => 'required',
            'town' => 'required',
            'postcode' => 'integer',
            'description' => 'required',
            'address' => 'required',
            'num_bedrooms' => 'required|integer|between:1,12',
            'num_bathrooms' => 'required|integer|between:1,12',
            'price' => 'required|integer',
            'property_type' => ['required', Rule::in(['Flat', 'Detatched', 'Semi-detached', 'Terraced', 'End of Terrace', 'Cottage', 'Bungalow'])],
            'for_sale' => 'required',
            'file' => 'required|image|max:2048',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()[0]]);
        }
        $file_name = time().'_'.$request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
        $property = new Property;
        $property->uuid = Str::uuid();
        $property->county = $request->county;
        $property->country = $request->country;
        $property->town = $request->town;
        $property->postcode = $request->postcode;
        $property->description = $request->description;
        $property->address = $request->address;
        $property->image_full = '/storage/' . $file_path;
        $property->image_thumbnail = '/storage/' . $file_path;
        $property->num_bedrooms = $request->num_bedrooms;
        $property->num_bathrooms = $request->num_bathrooms;
        $property->price = $request->price;
        $property->property_type = $request->property_type;
        $property->for_sale = $request->for_sale;
        $property->save();
        return response()->json(["success" => "Property created!"]);
    }
    public function show($id)
    {
        $property = Property::find($id);
        return response()->json($property);
    }
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'county' => 'required',
            'country' => 'required',
            'town' => 'required',
            'description' => 'required',
            'address' => 'required',
            'num_bedrooms' => 'required|integer|between:1,12',
            'num_bathrooms' => 'required|integer|between:1,12',
            'price' => 'required|integer',
            'property_type' => ['required', Rule::in(['Flat', 'Detatched', 'Semi-detached', 'Terraced', 'End of Terrace', 'Cottage', 'Bungalow'])],
            'for_sale' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()[0]]);
        }
        $property = Property::find($id);
        $property->county = $request->county;
        $property->country = $request->country;
        $property->town = $request->town;
        $property->postcode = $request->postcode;
        $property->description = $request->description;
        $property->address = $request->address;
        if ($request->file()) {
            $file_name = time().'_'.$request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
            $property->image_full = '/storage/' . $file_path;
            $property->image_thumbnail = '/storage/' . $file_path;
        }
        $property->num_bedrooms = $request->num_bedrooms;
        $property->num_bathrooms = $request->num_bathrooms;
        $property->price = $request->price;
        $property->property_type = $request->property_type;
        $property->for_sale = $request->for_sale;
        $property->save();
        return response()->json(["success" => "Property updated!"]);
    }
    public function destroy($id)
    {
        $property = Property::find($id);
        $property->delete();
        return response()->json('Property deleted!');
    }
    public function upsert()
    {
        $properties = [];
        $response = Http::get("https://trial.craig.mtcserver15.com/api/properties?page[number]=122&page[size]=100&api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug");
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
        return "Database Populated!";
    }
}