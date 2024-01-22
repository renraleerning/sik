<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function index(): View
    {
        $Transaksis = Transaksi::with('barang')->get();
        return view('home', compact('Transaksis'));
    }
    public function Barang() : View
    {
        $Barangs = Barang::latest()->paginate(10);
        return view('barang', compact('Barangs'));
    }
}
