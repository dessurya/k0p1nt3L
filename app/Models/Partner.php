<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'kti_partner';

	protected $fillable = [
        'name', 'web', 'picture', 'flag', 'publish_at', 'administrator_id'
    ];

    public function getAdministrator(){
		return $this->belongsTo('App\Models\Administrator', 'administrator_id');
	}

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
