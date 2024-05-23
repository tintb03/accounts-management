<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Password;
use Illuminate\Support\Facades\Storage;

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
            'icon' => 'nullable|string', // Thay đổi kiểu dữ liệu của trường icon thành string
        ]);

        // Lưu trữ icon
        $iconPath = $request->icon; // Lấy giá trị của trường icon từ request

        auth()->user()->passwords()->create([
            'service_name' => $request->service_name,
            'username' => $request->username,
            'password' => $request->password,
            'icon' => $iconPath,
        ]);

        return redirect()->route('dashboard');
    }

    public function edit($id) {
        // Lấy mật khẩu của người dùng theo ID
        $password = auth()->user()->passwords()->findOrFail($id);
        return view('passwords.edit', compact('password'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'service_name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'icon' => 'nullable|string', // Thay đổi kiểu dữ liệu của trường icon thành string
        ]);

        $password = auth()->user()->passwords()->findOrFail($id);

        $password->update([
            'service_name' => $request->service_name,
            'username' => $request->username,
            'password' => $request->password,
            'icon' => $request->icon, // Lấy giá trị của trường icon từ request
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy($id) {
        try {
            // Xóa mật khẩu của người dùng theo ID
            $password = auth()->user()->passwords()->findOrFail($id);
            $password->delete();
    
            return redirect()->route('dashboard')->with('success', 'Password deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Error deleting password: ' . $e->getMessage());
        }
    }
    
}

