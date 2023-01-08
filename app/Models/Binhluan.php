<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Binhluan extends Model
{
    use HasFactory;
    protected $table = 'binhluan';
    protected $fillable = ['ma_user', 'sach_id', 'bl_noidung', 'traloi_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'ma_user', 'ma_user');
    }

    public function replies()
    {
        return $this->hasMany(Binhluan::class, 'traloi_id', 'id')->orderBy('id', 'DESC');
    }
}
