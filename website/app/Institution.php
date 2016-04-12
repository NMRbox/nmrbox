<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institutions';

    protected $fillable = [
        'name',
        'institution_type'
    ];
    
    const institution_types = [
        'Academic',
        'Non-profit',
        'Government',
        'Other'
    ];

    public function persons()
    {
        return $this->belongsToMany('App\Person');
    }
}
