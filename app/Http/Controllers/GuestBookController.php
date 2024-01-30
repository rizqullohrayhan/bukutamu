<?php

namespace App\Http\Controllers;
use App\Models\GuestBook;
use App\Models\Guest;
use App\Models\Tahun;
use App\Models\ProblemCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\GuestExportNew;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class GuestBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->cekTahun();
        $tahun = $request->tahun ?? date('Y');
        $tahuns = Tahun::all();
        $guest_books = GuestBook::whereYear('created_at', $tahun)->orderBy('id', 'DESC')->get();
        $guests = Guest::orderBy('identity_number', 'ASC')->get();
        $problems = ProblemCategory::orderBy('name', 'ASC')->get();
        return view('dashboard.guestbook.index', [
            'guest_books' => $guest_books,
            'guests' => $guests,
            'problems' => $problems,
            'tahuns' => $tahuns,
            'tahun' => $tahun,
        ]);
    }

    private function cekTahun()
    {
        $tahun = Tahun::where('tahun', date('Y'))->first();
        if (!$tahun) {
            return Tahun::create(['tahun' => date('Y')]);
        }
        return 0;
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
        if($request->chosen_btn == 'new-data' && $request->submit_state == true){
            $validatedData = $request->validate([
                'name' => 'required',
                'identity_number' => 'required',
                'gender' => 'required',
                'email' => 'required',
                'instansi' => 'required',
                'phone' => 'required',
            ], [
                'required' => ':attribute Wajib Diisi!',
                'numeric' => ':attribute Wajib Diisi!',
            ]);
            $data = Guest::create($validatedData);
            GuestBook::create([
                'guest_id' => $data->id,
                'instansi' => $request->instansi,
                'problem_category_id' => $request->problem_category_id,
                'description' => $request->description
            ]);
            Alert::success('Sukses!', 'Riwayat tamu berhasil ditambahkan!');
            return redirect('/guestbook');
        }elseif ($request->chosen_btn == 'db-data' && $request->submit_state == true){
            $request->validate([
                'guest_id' => ['required', 'numeric'],
                'instansi' => ['required'],
                'problem_category_id' => ['required', 'numeric'],
                'description' => 'required',
            ], [
                'required' => ':attribute Wajib Diisi!',
                'numeric' => ':attribute Wajib Diisi!',
            ]);
            GuestBook::create([
                'guest_id' => $request->guest_id,
                'instansi' => $request->instansi,
                'problem_category_id' => $request->problem_category_id,
                'description' => $request->description
            ]);
            Alert::success('Sukses!', 'Riwayat tamu berhasil ditambahkan!');
            return redirect('/guestbook');
        }
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
            'guest_id' => ['required', 'numeric'],
            'instansi' => ['required'],
            'problem_category_id' => ['required', 'numeric'],
            'description' => 'required',
        ], [
            'required' => ':attribute Wajib Diisi!',
            'numeric' => ':attribute Wajib Diisi!',
        ]);
        // dd("validasi sukses");
        GuestBook::where('id', $id)
            ->update([
                'guest_id' => $request->guest_id,
                'instansi' => $request->instansi,
                'problem_category_id' => $request->problem_category_id,
                'description' => $request->description,
            ]);
        Alert::success('Sukses!', 'Data Riwayat Kunjungan berhasil diubah!');
        return redirect('/guestbook');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $guestbook_id = $request->guestbook_id;
        GuestBook::destroy($guestbook_id);
        Alert::success('Sukses!', 'Data Riwayat Tamu berhasil dihapus!');
        return redirect('/guestbook');
    }

    public function exportData(Request $request){
        // dd($request->tanggal); "06-Nov-2023 to 13-Nov-2023"
        $tanggal = explode(" to ", $request->tanggal);
        $tanggal_awal = Carbon::parse($tanggal[0])->format('Y-m-d');
        $tanggal_akhir = Carbon::parse($tanggal[1])->format('Y-m-d');

        $nama = 'DAFTAR TAMU UPT SPMB UNS PER ' . Carbon::parse($tanggal_awal)->format('d M') . ' - ' . Carbon::parse($tanggal_akhir)->format('d M Y');
        // dd(GuestBook::with('guest')->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])->get());
        return Excel::download(new GuestExportNew($nama, $tanggal_awal, $tanggal_akhir), $nama . ".xlsx");
    }
}
