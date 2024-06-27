<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // proses ambil data
        $medicines = Medicine::orderBy('name', 'ASC')->simplePaginate(5);
        return view ('medicine.index', compact('medicines'));
        // manggil html yang ada di folder resources/views/medicine/index.blade.php
        // compact : mengirim data ke blade
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // request $request untuk mengambil data yang diinput si user
     public function store(Request $request)
    {
        //validasi
        // 'name_input' => 'validasi1/validasi2'
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        // validasi data ke db : 'name_column' => $request
        Medicine::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah data obat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medicine = Medicine::find($id);
        // mengembalikan bentuk json dikirim data yang diambil dengan response status code 200
        //response status code api :
        // 200 -> success/ok
        // 400 an -> error kode/validasi input user
        // 419 -> error token csrf
        // 500 an -> error server hosting
        return response()->json($medicine, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //mengambil data yang akan dimunculkan 
        // find : mencari berdasarkan column id
        // bisa juga : where('id', $id)->first()
        $medicine = Medicine::find($id);

        return view('medicine.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric',
        ]);

        Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);

        return redirect()->route('medicine.data')->with('success', 'Berhasil mengubah data obat!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Medicine::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'berhasil menghapus data!');
    }

    public function stockData()
    {
        $medicines = Medicine::orderBy('stock', 'ASC')->simplePaginate(5);
        return view('medicine.stock', compact('medicines'));
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|numeric',
        ]);

        $medicineBefore = Medicine::where('id', $id)->first();
        if ($request->stock <= $medicineBefore['stock']) {
            return response()->json(['message' => 'stock tidak boleh kurang atau sama dengan stock sebelumnya!'], 400);
        }
        $medicineBefore->update(['stock' => $request->stock]);
        return response()->json('Berhasil', 200);
    }
}
