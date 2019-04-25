<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    // defining table name
    protected $table = 'reminders';

    protected $fillable = [
        'user_id',
        'code',
    ];

    const CREATED_AT = 'created_at';
    const COMPLETED_AT = 'completed_at';
    const UPDATED_AT = 'updated_at';
}
