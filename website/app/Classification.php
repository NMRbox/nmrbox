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
    ];


    public function person() {
        return $this->belongsToMany('App\Person', 'classification_person',
      'person_id', 'name');
    }

}
