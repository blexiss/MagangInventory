<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = "audit_logs";

    protected $fillable = ['user', 'action', 'model', 'old_data', 'new_data'];
}
