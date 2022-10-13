<?php
namespace App\Http\Controllers;
use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            'postcode' => 'required',
            'description' => 'required',
            'address' => 'required',
            'num_bedrooms' => 'required',
            'num_bathrooms' => 'required',
            'price' => 'required',
            'property_type' => 'required',
            'for_sale' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
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
        $property->latitude = 333;
        $property->longitude = 777;
        $property->image_full = '/storage/' . $file_path;
        $property->image_thumbnail = 'temp';
        $property->num_bedrooms = $request->num_bedrooms;
        $property->num_bathrooms = $request->num_bathrooms;
        $property->price = $request->price;
        $property->property_type = $request->property_type;
        $property->for_sale = $request->for_sale;
        $property->save();
        return response()->json("Property created!");
    }
    public function show($id)
    {
        $property = Property::find($id);
        return response()->json($property);
    }
    public function update($id, Request $request)
    {
        $property = Property::find($id);
        $property->county = $request->county;
        $property->country = $request->country;
        $property->town = $request->town;
        $property->postcode = $request->postcode;
        $property->description = $request->description;
        $property->address = $request->address;
        $property->latitude = 333;
        $property->longitude = 777;
        $property->image_full = $request->image_full;
        $property->image_thumbnail = $request->image_full;
        $property->num_bedrooms = $request->num_bedrooms;
        $property->num_bathrooms = $request->num_bathrooms;
        $property->price = $request->price;
        $property->property_type = $request->property_type;
        $property->for_sale = $request->for_sale;
        $property->save();
        return response()->json('Property updated!');
    }
    public function destroy($id)
    {
        $property = Property::find($id);
        $property->delete();
        return response()->json('Property deleted!');
    }
}