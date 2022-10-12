<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //Fillable: indicates to the model the fields to be registered;
    protected $fillable = [
        'name','price','stock','cover','description', 'slug'
    ];
}
