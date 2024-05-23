<style>
    .icon-cell {
        height: 109px; 
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .icon-cell svg {
        width: 30px; 
        height: 30px; 
    }
    .py-12 {
        background-color: #FAFAD2; 
    }

    /* CSS cho các nút */
    .btn {
        display: inline-block;
        font-weight: 400;
        color: #212529;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-warning {
        color: #212529;
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        color: #212529;
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        color: #fff;
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>

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
                                        
                    <input type="text" id="searchInput" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Search...">
                    @if($passwords->isEmpty())
                        <p>You have no accounts. Add a new account.</p>
                    @else
                    <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Icon</th>
                            <th class="px-4 py-2">Service</th>
                            <th class="px-4 py-2">Username</th>
                            <th class="px-4 py-2">Password</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($passwords as $index => $password)
                            <tr>
                                <td class="border px-4 py-2 icon-cell">
                                    @if ($password->icon)
                                        {!! $password->icon !!}
                                    @endif
                                </td>
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

                                    <div class="btn-group">
                                        <a href="{{ route('passwords.edit', $password->id) }}" class="btn btn-warning">Edit</a>
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $password->id }}')">Delete</button>
                                    </div>
                                    <form id="deleteForm{{ $password->id }}" action="{{ route('passwords.destroy', $password->id) }}" method="POST" class="inline" style="display: none;">
                                        @csrf
                                        @method('DELETE')
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

<script>
    function confirmDelete(passwordId) {
        if (confirm("Are you sure you want to delete this account?")) {
            document.getElementById('deleteForm' + passwordId).submit();
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase().trim();

            rows.forEach(row => {
                const service = row.children[1].textContent.toLowerCase();
                const username = row.children[2].textContent.toLowerCase();
                const password = row.children[3].querySelector('input[type="password"]').value.toLowerCase();

                if (service.includes(searchText) || username.includes(searchText) || password.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>


</x-app-layout>
