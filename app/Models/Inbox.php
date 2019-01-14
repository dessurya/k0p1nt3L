<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
	protected $table = 'kti_inbox';

	protected $fillable = [
        'name', 'handphone', 'email', 'subject', 'message', 'flag'
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
