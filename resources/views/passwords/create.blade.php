<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Password') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('passwords.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="service_name" class="block text-sm font-medium text-gray-700">Service</label>
                            <input type="text" name="service_name" id="service_name" placeholder="Vui lòng nhập tên ứng dụng mà bạn cần ghi nhớ tài khoản" class="form-input rounded-md shadow-sm mt-1 block w-full" required />
                        </div>
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" id="username" placeholder="Vui lòng nhập Username/Sđt/Gmail" class="form-input rounded-md shadow-sm mt-1 block w-full" required />
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" placeholder="Vui lòng nhập mật khẩu bạn cần ghi nhớ " class="form-input rounded-md shadow-sm mt-1 block w-full" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
