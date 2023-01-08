<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matsach extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'danhsachmats';
    protected $fillable = [ 'ma_user', 'masach', 'nhande', 'ngaybaomat', 'tienphat'];

    public function user()
    {
        return $this->hasOne(User::class, 'ma_user', 'ma_user');
    }
}
