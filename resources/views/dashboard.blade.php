<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Your Accounts</h3>
                    <a href="{{ route('passwords.create') }}" class="btn btn-primary mb-4">Add New Account</a>
                    @if($passwords->isEmpty())
                        <p>You have no accounts. Add a new account.</p>
                    @else
                    <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Service</th>
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Password</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($passwords as $index => $password)
                            <tr>
                                <td class="border px-4 py-2">{{ $password->service_name }}</td>
                                <td class="border px-4 py-2">{{ $password->username }}</td>
                                <td class="border px-4 py-2 relative">
                                    <div class="password-container">
                                        <input type="checkbox" id="togglePassword{{ $index }}" class="password-toggle-checkbox">
                                        <label for="togglePassword{{ $index }}" class="password-toggle-label absolute right-0 top-1/2 transform -translate-y-1/2 cursor-pointer">
                                            <i class="password-toggle-icon fas fa-eye"></i>
                                            <span class="password-toggle-text" style="margin-left: 8px;"> Click để hiện mật khẩu</span>
                                        </label>
                                    </div>
                                    <input type="password" name="password" id="password{{ $index }}" class="form-input rounded-md shadow-sm mt-1 block w-full pr-10" value="{{ $password->password }}" readonly />
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('passwords.edit', $password->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('passwords.destroy', $password->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordToggleCheckboxes = document.querySelectorAll('.password-toggle-checkbox');

        passwordToggleCheckboxes.forEach(function(checkbox, index) {
            const passwordField = document.getElementById(`password${index}`);
            const toggleText = checkbox.nextElementSibling.querySelector('.password-toggle-text');
            const toggleIcon = checkbox.nextElementSibling.querySelector('.password-toggle-icon');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    passwordField.type = 'text';
                    toggleText.textContent = ' Click để ẩn mật khẩu';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    toggleText.textContent = ' Click để hiện mật khẩu';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
</x-app-layout>
