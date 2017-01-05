<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'company_id', 'pub_date', 'title', 'details', 'featured_image'];

    /**
     * Database table used by Model
     *
     * @var array
     */
    protected $table='post';
}
