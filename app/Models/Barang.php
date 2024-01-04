<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = ['nama_barang', 'jenis_barang_id', 'harga', 'cover'];

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($barang) {
            $lastBarang = static::latest()->first(); // Ambil barang terakhir
    
            if ($lastBarang && preg_match('/\d+$/', $lastBarang->kode_barang, $matches)) {
                $lastNumber = intval($matches[0]);
                $nextNumber = $lastNumber + 1;
                $barang->kode_barang = 'BRG-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            } else {
                $barang->kode_barang = 'BRG-0001';
            }
        });
    }

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }
}
