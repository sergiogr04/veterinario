<?php

namespace App\Http\Controllers\Trabajador;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardTrabajadorController extends Controller
{
    public function index()
    {
        return view('dashboards.trabajador');
    }
}
