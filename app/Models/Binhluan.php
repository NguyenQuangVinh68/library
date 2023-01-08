<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Binhluan extends Model
{
    use HasFactory;
    protected $table = 'binhluan';
    protected $fillable = ['ma_user', 'sach_id', 'bl_noidung', 'traloi_id', 'status'];

    public function user()
    {
        return $this->hasOne(User::class, 'ma_user', 'ma_user');
    }

    public function replies()
    {
        return $this->hasMany(Binhluan::class, 'traloi_id', 'id')->where('status', 1)->orderBy('id', 'DESC');
    }

    public function sach()
    {
        return $this->hasOne(Sach::class, 'id', 'sach_id');
    }

    /**
     * scope này chỉ dùng được trong class model này Category
     * khi dùng chỉ cần gọi search, tiền tố scope là cố định
     */
    public function scopeSearch($query)
    {
        if ($key = request()->key) {
            $query = $query->where('ma_user', 'like', '%' . $key . '%');
        }
        return $query;
    }
}
