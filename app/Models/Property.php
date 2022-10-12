<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    // protected $fillable = ['county','country','town','postcode','full_details_url','description','image_url','thumbnail_url','address','latitude','longitude','number_of_bedrooms','number_of_bathrooms','price','property_type','for_sale','for_rent', 'created_at', 'updated_at'];
    protected $fillable = [
        'name', 
        'detail'
    ];
}
