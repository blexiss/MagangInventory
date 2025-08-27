<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;

class AuditLogsController extends Controller
{
    public function index()
    {
        // Ambil semua audit log terbaru, bisa ditambahkan pagination jika mau
        $logs = AuditLog::latest()->get();

        return view('audit-logs', [
            'logs' => $logs,
            'currentPage' => 'audit-logs'
        ]);
    }
}
