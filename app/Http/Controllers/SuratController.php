<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use Alert;
use Carbon\Carbon;
use App\Exports\SuratMasukExport;
use Maatwebsite\Excel\Facades\Excel;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surats = SuratMasuk::OrderBy('id', 'desc')->get();
        return view('dashboard.surat.index', ['surats' => $surats]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $request->validate([
            'tanggal' => ['required'],
            'no_surat' => ['required'],
            'perihal' => ['required'],
        ], [
            'required' => ':attribute Wajib Diisi!',
        ]);

        $data = $request->input();
        $data['tanggal'] = Carbon::parse($request->tanggal)->format('Y-m-d');
        SuratMasuk::create($data);
        Alert::success('Sukses!', 'Data surat berhasil ditambahkan!');
        return redirect('/surat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => ['required'],
            'no_surat' => ['required'],
            'perihal' => ['required'],
        ], [
            'required' => ':attribute Wajib Diisi!',
        ]);

        $data = $request->input();
        $data['tanggal'] = Carbon::parse($request->tanggal)->format('Y-m-d');
        SuratMasuk::find($id)->update($data);
        Alert::success('Sukses!', 'Data surat berhasil diedit!');
        return redirect('/surat');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SuratMasuk::destroy($id);
        Alert::success('Sukses!', 'Data Riwayat Tamu berhasil dihapus!');
        return redirect('/surat');
    }

    public function exportData(Request $request){
        // dd($request->tanggal); "06-Nov-2023 to 13-Nov-2023"
        $tanggal = explode(" to ", $request->tanggal);
        $tanggal_awal = Carbon::parse($tanggal[0])->format('Y-m-d');
        $tanggal_akhir = Carbon::parse($tanggal[1])->format('Y-m-d');
        
        $nama = 'DAFTAR Surat Masuk UPT SPMB UNS PER ' . Carbon::parse($tanggal_awal)->format('d M') . ' - ' . Carbon::parse($tanggal_akhir)->format('d M Y');
        // dd($nama);
        return Excel::download(new SuratMasukExport($nama, $tanggal_awal, $tanggal_akhir), $nama . ".xlsx");
    }
}
