<?php

namespace App\Http\Controllers;

use App\Models\ProblemCategory;
use Illuminate\Http\Request;
use Alert;

class CategoryDescriptionController extends Controller
{
    public function index() {
        return view('dashboard.problems.index', [
            'categories' => ProblemCategory::orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
        ], [
            'required' => ':attribute Wajib Diisi!'
        ]);
        ProblemCategory::create($request->all());
        Alert::success('Sukses!', 'Data Kategori berhasil ditambahkan!');
        return redirect('/problems');
    }

    public function update(Request $request) {
        $category_id = $request->category_id;
        $request->validate([
            'ename' => 'required',
        ], [
            'required' => ':attribute Wajib Diisi!'
        ]);
        ProblemCategory::where('id', $category_id)
            ->update([
                'name' => $request->ename
            ]);
        Alert::success('Sukses!', 'Data Kategori berhasil diubah!');
        return redirect('/problems');
    }

    public function destroy(Request $request)
    {
        $category_id = $request->category_id;

        ProblemCategory::destroy($category_id);
        Alert::success('Sukses!', 'Data Kategori berhasil dihapus!');
        return redirect('/problems');
    }
}
