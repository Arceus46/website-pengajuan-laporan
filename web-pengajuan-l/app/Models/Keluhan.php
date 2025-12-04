<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    protected $table = 'tb_keluhan';
    protected $primaryKey = 'id_keluhan';
    public $incrementing = false; // Karena kita generate manual
    protected $keyType = 'string'; // Karena ID berupa string
    
    protected $fillable = [
        'id_keluhan', // TAMBAHKAN
        'nik', 
        'judul_keluhan', 
        'isi_keluhan', 
        'tanggal_keluhan'
    ];
    
    public $timestamps = false;
}