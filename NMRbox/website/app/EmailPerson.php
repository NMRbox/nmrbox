<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailPerson extends Model
{
    // defining table name
    protected $table = 'email_person';

    /* primary keys */
    protected $primaryKey = 'id';

    // disableing default timestamp for not inserting created_at & updated_at
    public $timestamps = false;

    /* fallible fields */
    protected $fillable = [
        'person_id',
        'email_id',
        'email',
        'sent',
    ];
}
