<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Property;
class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all()->toArray();
        return array_reverse($properties);      
    }
    public function store(Request $request)
    {
        $property = new Property([
            'name' => $request->input('name'),
            'detail' => $request->input('detail')
        ]);
        $property->save();
        return response()->json('Property created!');
    }
    public function show($id)
    {
        $property = Property::find($id);
        return response()->json($property);
    }
    public function update($id, Request $request)
    {
        $property = Property::find($id);
        $property->update($request->all());
        return response()->json('Property updated!');
    }
    public function destroy($id)
    {
        $property = Property::find($id);
        $property->delete();
        return response()->json('Property deleted!');
    }
}