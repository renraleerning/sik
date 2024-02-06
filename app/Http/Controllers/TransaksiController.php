<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TransaksiController extends Controller
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
    public function index()
    {
        $Transaksis = Transaksi::with('barang')->get();
        return view('dashboard', compact('Transaksis'));
    }
    public function create(): View
    {
        $Barangs = Barang::latest()->get();    
        return view('insertformtransaksi', compact('Barangs'));
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
    
    public function edit(string $id): View
    {
        $barang = Barang::where('id_barang', $id)->firstOrFail();
        return view('updateformbarang', compact('barang'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama_produk' => 'required|min:2',
            'merk' => 'required|min:3',
            'harga' => 'required|min:3'
        ]);

        $barang = Barang::where('id_barang', $id)->firstOrFail();
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image->storeAs('public/product', $image->hashName());

            Storage::delete('public/product/'.$barang->image);

            $barang->where('id_barang',$id)->update([
                'image'     => $image->hashName(),
                'nama_produk'=> $request->nama_produk,
                'merk'   => $request->merk,
                'harga'   => $request->harga
            ]);

        } else {
            $barang->update([
                'nama_produk'=> $request->nama_produk,
                'merk'   => $request->merk,
                'harga'   => $request->harga
            ]);
        }

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $barang = Barang::where('id_barang', $id)->firstOrFail();
        Storage::delete('public/product/'. $barang->image);
        $barang->where('id_barang',$id)->delete();
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
