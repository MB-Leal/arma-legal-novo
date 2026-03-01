<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcessoLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $logs = AcessoLog::when($search, function ($query, $search) {
                return $query->where('cpf', 'like', "%{$search}%")
                             ->orWhere('nome', 'like', "%{$search}%")
                             ->orWhere('ip_address', 'like', "%{$search}%");
            })
            ->orderBy('data_acesso', 'desc')
            ->paginate(20);

        return view('admin.logs.index', compact('logs', 'search'));
    }
}
