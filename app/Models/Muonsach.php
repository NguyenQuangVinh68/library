<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muonsach extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'danhsachmuons';
    protected $fillable = ['ma_user', 'ten_user', 'ngaymuon', 'ngaytra'];

    public function ctmuon()
    {
        return $this->hasOne(Ctmuon::class, 'mamuon', 'id')->where('trangthai', 0);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'ma_user', 'ma_user');
    }
}
