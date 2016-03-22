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
        'institution',
        'pi',
        'nmrbox_acct'
    ];
}
