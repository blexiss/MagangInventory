<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditLogsController extends Controller
{
    public function index()
    {
        return view('audit-logs', ['currentPage' => 'audit-logs']);
    }
}
