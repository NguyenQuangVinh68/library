<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yeuthich extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "yeuthichs";
    protected $fillable = ['ma_user', 'masach'];

    public function sach()
    {
        return $this->hasOne(Sach::class, 'id', 'masach');
    }
}
