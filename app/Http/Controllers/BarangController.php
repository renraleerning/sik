<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{   
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                return $next($request);
            } else {
                return redirect('/');
            }
        });
       
    }
    public function index(): View
    {
        $Barangs = Barang::latest()->paginate(5);
        return view('barang', compact('Barangs'));
    }

    public function create(): View
    {
        return view('insertformbarang');
    }
    
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama_produk' => 'required|min:2',
            'merk' => 'required|min:3',
            'harga' => 'required|min:3'
        ]);
            $image = $request->file('image');
            $image->storeAs('public/product', $image->hashName());
        Barang::create([
            'image'     => $image->hashName(),
            'nama_produk'=> $request->nama_produk,
            'merk'   => $request->merk,
            'harga'   => $request->harga
        ]);

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
}