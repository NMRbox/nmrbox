<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    // defining table name
    protected $table = 'workshops';

    // overriding primary keys and turning off auto increment
    protected $primaryKey = 'name';

    // disableing default timestamp for not inserting created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'name',
        'url',
        'title',
        'start_date',
        'end_date',
        'location',
    ];


}
