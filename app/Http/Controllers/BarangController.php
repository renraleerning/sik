<?php

namespace App\Http\Controllers;

//import Model Barang
use App\Models\Barang;

use Illuminate\Http\Request;

//return type View
use Illuminate\View\View;

//return type redirectResponse
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

    
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            
            'nama_produk' => 'required|min:2',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'merk' => 'required|min:3',
            'harga' => 'required|min:3',
        ]);

        Barang::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        return redirect()->route('barang')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
   
    public function show(string $id): View
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

   
    public function edit(string $id): View
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }
        
   
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'     => 'required|min:5',
            'content'   => 'required|min:10'
        ]);
        $barang = Barang::findOrFail($id);
        $post->update([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        return redirect()->route('barang')->with(['success' => 'Data Berhasil Diubah!']);
    }

    
    public function destroy($id): RedirectResponse
    {
        $barang = Barang::findOrFail($id);
        $barang->Barang();
        return redirect()->route('barang')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}