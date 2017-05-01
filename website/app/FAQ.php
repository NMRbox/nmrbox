<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $table = 'faqs';

    // overriding primary keys and turning off auto increment
    protected $primaryKey = 'id';

    // disableing default timestamp for not inserting created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'id',
        'answer',
        'question'
    ];

    /**
     * pivot relation with keyword_category table
     */
    public function softwares() {
        return $this->belongsToMany('App\Software', 'faq_software', 'faq_id', 'software_id');
    }

    /**
     * pivot relation with search_keywords table
     */
    public function search_keywords() {
        return $this->belongsToMany('App\SearchKeyword', 'faq_search_keyword', 'faq_id', 'search_keyword_id');
    }
}
