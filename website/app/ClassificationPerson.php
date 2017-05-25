<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassificationPerson extends Model
{
    //
    // defining table name
    protected $table = 'classification_person';

    // overriding primary keys and turning off auto increment
    protected $primaryKey = 'name, person_id';
    public $incrementing = false;


    // disableing default timestamp for not inserting created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'name',
        'person_id'
    ];

}
