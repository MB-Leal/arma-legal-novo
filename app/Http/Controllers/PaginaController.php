<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginaController extends Controller
{
    public function termos() {
        return view('pages.termos');
    }

    public function politica() {
        return view('pages.politica');
    }

    public function suporte() {
        return view('pages.suporte');
    }
    public function dalInfo() {
    return view('pages.dal_info');
}
}
