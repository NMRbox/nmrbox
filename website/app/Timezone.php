<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Timezone extends NmrModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timezones';

    protected $fillable = [ ];

}
