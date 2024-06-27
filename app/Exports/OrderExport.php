<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
// untuk menggunakan func headings
use Maatwebsite\Excel\Concerns\WithHeadings;
// untuk menggunakan func map 
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{


    // proses pengambilan data yang akan di export excel
    public function collection()
    {
        return Order::with('user')->get();
    }

    // menentukan nama-nama column di excelnya 
     public function headings() : array 
     {
        return [
            "Nama Pembeli", "Pesanan", "Total Harga (+ppn)", "Kasir", "Tanggal" 
        ];
     }

     // data dari collection ( pengambilan dari db) yang akan dimunculkan ke excel
     // untuk memanipulasi data dari databasenya (mengubah isi dari data nya sebelum ditampilkan di excelnya)
     public function map($item) : array 
     {
        
            $pesanan = "";
            foreach ($item['medicines'] as $medicine) {
                $pesanan .= "( " . $medicine['name_medicine'] . " : qty " . $medicine['qty'] . "" . ": " . "Rp ". number_format ($medicine['qty'], 0, ',', '.') 
                . " " . number_format($medicine['price_after_qty'], 0, ',', '.') . " ),";    
            }
            $totalAfterPPN = $item['total_price'] * ($item['total_price'] * 0.1);

            return [
       
                $item['name_customer'],
                $pesanan,
                "Rp " . number_format($totalAfterPPN, 0, ',', '.'),
                $item ['user']['name']. "(" . $item['user']['email'] . ")",
                Carbon::parse($item['created_at'])->format("d-m-y H-i-s") 
            ];
     }
}
