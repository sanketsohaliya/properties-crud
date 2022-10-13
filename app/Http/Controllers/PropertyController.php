<?php
namespace App\Http\Controllers;
use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
}