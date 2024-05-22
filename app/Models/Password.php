<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name', 'username', 'password',
    ];

    // Không cần sử dụng mutator setPasswordAttribute() để mã hóa mật khẩu khi lưu vào cơ sở dữ liệu

    public function user() {
        return $this->belongsTo(User::class);
    }
}
