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
        'attendance_max'
    ];

    /**
     * pivot relation with classifications_person table
     */
    public function person() {
        return $this->belongsToMany('App\Person', 'classification_person', 'name', 'person_id')
            ->withPivot('name', 'person_id');
    }

    /**
     * pivot relation with classifications_person table
     */
    public function scopeattendances() {
        return $this->belongsToMany('App\Person', 'classification_person', 'name', 'person_id')->whereNotNull('name');
            //->withPivot('name', 'person_id');
    }
}
