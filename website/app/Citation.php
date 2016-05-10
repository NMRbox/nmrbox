<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citation extends NmrModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'citations';

    protected $fillable = [
        'citation_type_id',
        'title',
        'year',
        'journal',
        'volume',
        'issue',
        'publisher',
        'note',
        'pages',
        'source_key'
    ];
    
    public function authors()
    {
        return $this->belongsToMany('App\Author', 'author_citation', 'citation_id', 'author_id');
    }

    public function software() {
        return $this->belongsToMany('App\Software');
    }
}
