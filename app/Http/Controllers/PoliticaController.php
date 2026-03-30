<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliticaController extends Controller
{
    /**
     * Show privacy policy page.
     */
    public function privacidad()
    {
        return view('politicas.privacidad');
    }

    /**
     * Show terms and conditions page.
     */
    public function terminos()
    {
        return view('politicas.terminos');
    }
}
