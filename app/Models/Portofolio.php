<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
	protected $table = 'kti_portofolio';

	protected $fillable = [
        'name_id', 'name_en', 'content_id', 'content_en', 'project_id', 'project_en', 'picture_first', 'picture_second', 'slug', 'flag', 'publish_at', 'administrator_id'
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

	public function getPortofolioGaleri(){
		return $this->hasMany('App\Models\PortofolioGaleri', 'portofolio_id', 'id');
	}

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
