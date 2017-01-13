<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    // defining table name
    protected $table = 'emails';

    // overriding primary keys and turning off auto increment
    protected $primaryKey = 'name';
    public $incrementing = false;

    // disableing default timestamp for not insertig created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'name',
        'subject',
        'content',
    ];
}
