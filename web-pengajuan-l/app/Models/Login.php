<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable
{
    protected $table = 'tb_warga';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'nik', 
        'nama', // <- INI YANG BENAR: 'nama' bukan 'name'
        'alamat', 
        'no_hp', 
        'email', 
        'password'
    ];
    
    protected $hidden = [
        'password'
    ];
    
    public $timestamps = false;
}