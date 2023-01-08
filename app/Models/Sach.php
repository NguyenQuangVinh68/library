<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sach extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'nhande',
        'tacgia',
        'danhmuc',
        'khoa',
        'nganh',
        'anhbia',
        'thongtinxb',
        'vitri',
        'soluong',
        'gia',
        'file_pdf'
    ];

    public function binhluan()
    {
        return $this->hasMany(Binhluan::class, 'sach_id', 'id')
            ->where('status', 1)
            ->where('traloi_id', 0)
            ->orderBy('id', 'DESC');
    }
    public function count_binhluan()
    {
        return $this->hasMany(Binhluan::class, 'sach_id', 'id')->where('status', 1);
    }

    /**
     * scope này chỉ dùng được trong class model này Category
     * khi dùng chỉ cần gọi search, tiền tố scope là cố định
     */
    public function scopeSearch($query)
    {
        $column = request()->select_search;
        $key = request()->key;

        if ($column) {
            $query = $query->where("{$column}", 'like', '%' . $key . '%');
        } else {
            $query = $query->where('nhande', 'like', '%' . $key . '%');
        }
        return $query;
    }
}
