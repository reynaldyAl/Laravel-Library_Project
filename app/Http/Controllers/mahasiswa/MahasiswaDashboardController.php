<?php
// app/Http/Controllers/mahasiswa/MahasiswaDashboardController.php
namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        return view('mahasiswa.dashboard.index');
    }
}