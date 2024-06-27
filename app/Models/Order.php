<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicines',
        'name_customer',
        'total_price',
    ];

    protected $casts = [
        'medicines' => 'array',
    ];

    
    public function user() 
    {
        //menggabungkan ke primary key nya
        //() merupakan model penyimpanan dari pk nya si fk ke model ini
        return $this->belongsTo
        (user::class);
    }
}
