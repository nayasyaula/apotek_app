@extends('layouts.template')

@section('content')
    <form action="{{ route('medicine.store') }}" method="post" class="card p-5 mt-5 bg-light">
        {{-- sebagai token akses database (fungsi : mengenali dan mengizinkan )--}}
        @csrf
        {{-- jika terjadi error validasi, akan ditampilkan bagian error nya --}}
        @if ($errors->any())
            <ul class="alert alert-danger p-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif 
            {{-- jika berhasil munculkan notifnya --}}
            @if (Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Obat :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Type Obat : </label>
            <div class="col-sm-10">
                <select class="form-select" id="type" name="type">
                    <option selected disbaled hidden>Pilih</option>
                    <option value="tablet">tablet</option>
                    <option value="sirup">sirup</option>
                    <option value="kapsul">kapsul</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga Obat :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-from-label">Stok Awal :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
</form>
@endsection