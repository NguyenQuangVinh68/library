<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuonOnline extends Model
{
    use HasFactory;
    protected $table = 'muon_onlines';
    protected $fillable = ['ma_user', 'ten_user', 'masach', 'nhande'];

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
