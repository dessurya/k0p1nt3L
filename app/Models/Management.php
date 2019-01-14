<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
	protected $table = 'kti_management';

	protected $fillable = [
        'name', 'position_id', 'position_en', 'picture', 'flag', 'publish_at', 'administrator_id'
    ];

    public function setPositionIdAttribute($value)
    {
        $this->attributes['position_id'] = title_case($value);
    }
    public function setPositionEnAttribute($value)
    {
        $this->attributes['position_en'] = title_case($value);
    }

    public function getAdministrator(){
		return $this->belongsTo('App\Models\Administrator', 'administrator_id');
	}

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
