<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'pi',
        'nmrbox_acct',
        'institution',
        'department',
        'position',
        'address1',
        'address2',
        'address3',
        'city',
        'state_province',
        'zip_code',
        'country',
        'time_zone_id'
    ];

    const positions = [
        'PI',
        'Undergraduate Student',
        'Graduate Student',
        'Postdoc',
        'Faculty',
        'Staff',
        'Other'
    ];

    public function user() {
        return $this->hasOne('App\User');
    }

    public function institution() {
        return $this->belongsTo('App\Institution');
    }
}
