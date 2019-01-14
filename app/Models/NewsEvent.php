<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsEvent extends Model
{
	protected $table = 'kti_news_event';

	protected $fillable = [
        'name_id', 'name_en', 'content_id', 'content_en', 'picture', 'slug', 'flag', 'publish_at', 'administrator_id'
    ];

    public function setNameIdAttribute($value)
    {
        $this->attributes['name_id'] = title_case($value);
    }
    public function setNameEnAttribute($value)
    {
        $this->attributes['name_en'] = title_case($value);
    }
    public function setSlugAttribute()
    {
        $this->attributes['slug'] = str_slug($this->name_id);
    }

    public function getAdministrator(){
		return $this->belongsTo('App\Models\Administrator', 'administrator_id');
	}

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
