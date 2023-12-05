<?php

namespace App\Http\Controllers;

use App\Models\Pegawai; // Assuming you have a Pegawai model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::latest()->paginate(10);
        return view('pegawai.index', compact('pegawai')); // Assuming you have a 'pegawai' folder in your views directory
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pegawai.tambah'); // Assuming you have a 'tambah.blade.php' file in the 'pegawai' folder
    }

    public function show(Pegawai $pegawai)
    {
        //
    }
    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        return view('pegawai.update', compact('pegawai'));
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $foto = $request->file('foto');
        $foto->storeAs('public/pegawai', $foto->hashName());
        $pegawai = Pegawai::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'foto' => $foto->hashName(),
            'pekerjaan' => $request->pekerjaan,
        ]);
        if ($pegawai) {
            return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('pegawai.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        Storage::disk('local')->delete('public/pegawai/' . $pegawai->gambar);
        $pegawai->delete();
        if ($pegawai) {
            return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect()->route('pegawai.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        if ($request->file('foto') == "") {
            $pegawai->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'pekerjaan' => $request->pekerjaan,
            ]);
        } else {
            Storage::disk('local')->delete('public/pegawai/' . $pegawai->foto);
            $foto = $request->file('foto');
            $foto->storeAs('public/pegawai', $foto->hashName());
            $pegawai->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'foto' => $foto->hashName(),
                'pekerjaan' => $request->pekerjaan,
            ]);
            if ($pegawai) {
                return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                return redirect()->route('pegawai.index')->with(['error' => 'Data Gagal Diubah!']);
            }
        }
    }
}
