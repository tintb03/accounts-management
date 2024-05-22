<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Password;

class PasswordController extends Controller
{
    public function index() {
        // Lấy danh sách mật khẩu của người dùng
        $passwords = auth()->user()->passwords;
        
        return view('dashboard', compact('passwords'));
    }
    

    public function create() {
        return view('passwords.create');
    }

    public function store(Request $request) {
        $request->validate([
            'service_name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        // Không cần mã hóa mật khẩu khi lưu vào cơ sở dữ liệu

        auth()->user()->passwords()->create([
            'service_name' => $request->service_name,
            'username' => $request->username,
            'password' => $request->password, // Lưu mật khẩu không mã hóa
        ]);

        return redirect()->route('dashboard');
    }

    public function edit($id) {
        // Lấy mật khẩu của người dùng theo ID, không cần giải mã
        $password = auth()->user()->passwords()->findOrFail($id);
        return view('passwords.edit', compact('password'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'service_name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cập nhật mật khẩu, không cần mã hóa lại
        $password = auth()->user()->passwords()->findOrFail($id);
        $password->update([
            'service_name' => $request->service_name,
            'username' => $request->username,
            'password' => $request->password, // Giữ nguyên mật khẩu nhận được từ request
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy($id) {
        // Xóa mật khẩu của người dùng theo ID
        $password = auth()->user()->passwords()->findOrFail($id);
        $password->delete();

        return redirect()->route('dashboard');
    }
}
