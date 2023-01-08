<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trasach extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'danhsachtras';
    protected $fillable = ['mamuon', 'ma_user', 'masach', 'nhande', 'ngaytra'];

    public function user()
    {
        return $this->hasOne(User::class, 'ma_user', 'ma_user');
    }
}
