<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    // defining table name
    protected $table = 'classifications';

    // overriding primary keys and turning off auto increment
    protected $primaryKey = 'name';
    public $incrementing = false;

    // disableing default timestamp for not insertig created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'name',
        'definition',
        'web_role'
    ];


    public function person() {
        return $this->belongsToMany('App\Person', 'classification_person', 'name', 'person_id')
            ->withPivot('name', 'person_id');
    }

}
