<?php

namespace App\Http\Controllers;

use App\Exports\GuestsExport;
use App\Models\GuestBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Guest;
use App\Models\ProblemCategory;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class GuestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $guests = Guest::orderBy('id', 'DESC')->get();
        $guest_books = GuestBook::all();
        return view('dashboard.guests.index', [
            'guests' => $guests,
            'guest_books' => $guest_books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'identity_number' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'guest_category' => 'required',
            'phone' => 'required',
        ], [
            'required' => ':attribute Wajib Diisi!',
        ]);

        $data = Guest::create($validatedData);
        Alert::success('Sukses!', 'Data Tamu berhasil ditambahkan!');
        return redirect('/guests');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Guest $guest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Guest $guest)
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
    public function update(Request $request, Guest $guest)
    {
        $guest_id = $request->guest_id;
        $request->validate([
            'ename' => 'required',
            'eidentity_number' => 'required',
            'egender' => 'required',
            'eemail' => 'required',
            'eguest_category' => 'required',
            'ephone' => 'required',
        ], [
            'required' => ':attribute Wajib Diisi!',
        ]);
        Guest::where('id', $guest_id)
            ->update([
                'name' => $request->ename,
                'identity_number' => $request->eidentity_number,
                'gender' => $request->egender,
                'email' => $request->eemail,
                'guest_category' => $request->eguest_category,
                'phone' => $request->ephone
            ]);
        Alert::success('Sukses!', 'Data Tamu berhasil diubah!');
        return redirect('/guests');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Guest $guest)
    {
        $guest_id = $request->guest_id;
        Guest::destroy($guest_id);
        Alert::success('Sukses!', 'Data Tamu berhasil dihapus!');
        return redirect('/guests');
    }
    public function guestHistory(Request $request){
        if($request->ajax()){
            $output = "";
            $init = 1;
            $histories = GuestBook::where('guest_id', $request->guest_id)->orderBy('created_at', 'desc')->limit(10)->get();
            if($histories)
            {
                $output.="<table class='table table-bordered table-responsive' style='width:100%'>".
                    "<thead>".
                    "<tr>".
                    "<th>No.</th>".
                    "<th>Tanggal</th>".
                    "<th>Waktu</th>".
                    "<th>Instansi</th>".
                    "<th>Kategori Keperluan</th>".
                    "<th>Deskripsi</th>".
                    "</tr>".
                    "</thead>".
                    "<tbody>";
                foreach ($histories as $key => $history) {
                    $output.='<tr>'.
                        '<td>'.$init.'</td>'.
                        '<td>'.\Carbon\Carbon::parse($history->created_at)->format('D, d M Y').'</td>'.
                        '<td>'.\Carbon\Carbon::parse($history->created_at)->format('H:i:s').'</td>'.
                        '<td>'.$history->instansi.'</td>'.
                        '<td>'.$history->problemCategory->name.'</td>'.
                        '<td>'.$history->description.'</td>'.
                        '</tr>';
                    $init+=1;
                }
                $output.="</tbody>".
                "</table>";
                return Response($output);
            }
        }

    }
}
