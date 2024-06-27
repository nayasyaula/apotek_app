@extends('layouts.template')

@section('content')
    <div class="mt-5">
        <div class="justify-content-start d-flex">
            <form action="{{ route('order.search')}}" method="GET" >
            <input type="date" name="search" id="search" value="{{ old('search')}}">
           <button type="submit" class="btn btn-primary">Cari Data</button>
           <a href="{{ route('order.index')}}" class="btn btn-primary">Reset</a>
            </form>
        </div>
    <div class="justify-content-end d-flex">
        <a href="{{ route('order.create') }}" class="btn btn-primary">Tambah Pengguna</a>
    </div>
    <table class="table-striped w-100 table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Pesanan</th>
                <th>Total Bayar</th>
                <th>kasir</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($orders as $order) 
            <tr>
        {{-- current page : ambil posisi ada di page ke berapa - 1 ( misal uda klik next lagi ada dipage 2 berarti jadi 2-1 = 1),
            perpage : mengambil jumlah data yang ditampilkan per page nya berapa ( ada di controller bagian paginate/simplePaginate, misal 5, 
            loop->index : mengambil index dari array (mulai dari 0)+1 --}}
            {{-- jadi : (2-1) x 5 + 1 = 6 (dimulai dari angka 6 du page ke 2 nya) --}}
            <td>{{ ($orders->currentpage()-1) * $orders->perpage() + $loop->index + 1}}</td>
            <td>{{ $order['name_customer'] }}</td>
            {{-- nested loop : looping didalam looping --}}
            {{-- karna column medicines pada table orders tipe datanya json, jadi untuk akses nya perlu looping --}}

            <td> 
                <ol>
            @foreach ($order['medicines']  as $medicine )
            {{-- tampilan yang ingin ditampilkan --}}
            {{-- 1. nama obat Rp.1000  --}}
                <li>{{ $medicine['name_medicine'] }} <small>Rp. {{ number_format($medicine['price'], 0, ',', '.') }} 
                    <b>(qty : {{ $medicine['qty'] }}) </b></small> 
                    = Rp. {{ number_format($medicine['price_after_qty'], 0, ',', '.') }} </li>
            @endforeach
                </ol>
            </td>
            @php 
            $ppn = $order['total_price'] * 0.1;
            @endphp
            <td>Rp. {{ number_format(($order['total_price']+$ppn), 0, ',', '.') }}</td>
            {{-- mengambil column dari relasi, $variable ['namaFunctionModel']['namaColumnDiDBRelasi'] --}}
            <td>{{ $order['user']['name']}} <a href="mailto:{{ $order['user']['email']}}">({{ $order['user']['email']}})</a></td>
            @php 
            // set lokasi waktu berdasarkan penamaan dan jam wib indonesia
            setLocale(LC_ALL, 'IND');
            @endphp
            {{-- carbon : package bawaan laravel untuk memanipulasi format tanggal / waktu --}}
            <td>{{ Carbon\Carbon::parse($order['created_at'])->formatLocalized('%d %B %Y')}}</td>
            <td>
                <a href="{{ route('order.download-pdf', $order['id']) }}" class="btn btn-success">Download Struk</a>
            </td>
            </tr>
            @endforeach
        </tbody>
</table>
<div class="d-flex justify-content-end">
    @if ($orders->count())
        {{$orders->links()}}
        @endif
</div>
</div>
        @endsection

