<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'tenkhoa',
        'slug'
    ];

    public function nganh()
    {
        return $this->hasOne(Nganh::class, 'id', 'makhoa');
    }

    /**
     * scope này chỉ dùng được trong class model này Category
     * khi dùng chỉ cần gọi search, tiền tố scope là cố định
     */
    public function scopeSearch($query)
    {
        if ($key = request()->key) {
            $query = $query->where('tenkhoa', 'like', '%' . $key . '%');
        }
        return $query;
    }
}
