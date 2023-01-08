<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctmuon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'chitietmuons';
    protected $fillable = ['mamuon', 'ma_user', 'masach', 'nhande'];

    public function danhsachmuon()
    {
        return $this->belongsTo(Muonsach::class, 'mamuon', 'id');
    }
}
