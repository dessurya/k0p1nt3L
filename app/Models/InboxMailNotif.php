<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InboxMailNotif extends Model
{
    protected $table = 'kti_inbox_mail_notif';

	protected $fillable = [
        'administrator_id'
    ];

    public function getAdministrator()
	{
		return $this->belongsTo('App\Models\Administrator', 'administrator_id');
	}

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
