<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
	protected $table = 'kti_career';

	protected $fillable = [
        'name_id', 'name_en', 'picture', 'flag', 'publish_at', 'administrator_id'
    ];

    public function getAdministrator(){
		return $this->belongsTo('App\Models\Administrator', 'administrator_id');
	}

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
