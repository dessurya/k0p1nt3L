<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministratorLogs extends Model
{
    protected $table = 'kti_administrator_logs';

    protected $fillable = ['logs', 'administrator_id'];

    public function getAdministrator()
	{
		return $this->belongsTo('App\Models\Administrator', 'administrator_id');
	}

	public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
