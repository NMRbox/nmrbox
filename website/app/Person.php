<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends EloquentUser
//class Person extends NmrModel
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
        'email_institution',
        'pi',
        'nmrbox_acct',
        'institution',
        'institution_id',
        'department',
        'position',
        'job_title',
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
        'PI' => 'PI',
        'Undergraduate Student' => 'Undergraduate Student',
        'Graduate Student' => 'Graduate Student',
        'Postdoc' => 'Postdoc',
        'Faculty' => 'Faculty',
        'Staff' => 'Staff',
        'Other' => 'Other'
    ];

    public $timestamps = false;

    /**
     * pivot relation with user table
     */
    /*
     * replacing user -> person
     * public function user() {
        return $this->hasOne('App\User');
    }
    */

    /**
     * pivot relation with institution table
     */
    public function institution() {
        return $this->belongsTo('App\Institution');
    }

    /**
     * pivot relation with classifications_person table
     */
    public function classification() {
        return $this->belongsToMany('App\Classification', 'classification_person',
      'person_id', 'name');
    }

    /**
     * pivot relation with faq_ratings table
     */
    public function ratings() {
        return $this->belongsToMany('App\FAQ', 'faq_rating',
      'person_id', 'faq_id');
    }

}
