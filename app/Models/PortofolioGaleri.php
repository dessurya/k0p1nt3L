<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortofolioGaleri extends Model
{
	protected $table = 'kti_portofolio_galeri';

	protected $fillable = [
        'picture', 'flag', 'administrator_id', 'portofolio_id'
    ];

    
    public function getAdministrator(){
		return $this->belongsTo('App\Models\Administrator', 'administrator_id');
	}

	public function getPortofolio(){
		return $this->belongsTo('App\Models\Portofolio', 'portofolio_id');
	}

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
