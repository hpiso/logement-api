<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'address',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'owner_email',
        'owner_name',
    ];

    protected $table = 'places';
    public $timestamps = true;
}