<x-app-layout>
    <div class="container mx-auto p-4">
        <!-- Roles Listing -->
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold">Roles</h1>
            <button id="create-role-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Create Role</button>
        </div>

        @php $protected_roles = ['patient','customer','doctor']; @endphp

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 my-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($roles as $role)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $role->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $role->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if (!in_array($role->name, $protected_roles))
                                <button class="text-blue-500 hover:text-blue-700 edit-role-btn"
                                    data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}">
                                    Edit
                                </button>
                            @endif

                            <a href="{{ route('roles.permissions.index', $role->id) }}"
                                class="text-green-500 hover:text-blue-700 mx-2">Manage Permissions</a>
                            @if (!in_array($role->name, $protected_roles))
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Modal for Create/Edit Role -->
    <div id="role-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 id="modal-title" class="text-xl font-bold mb-4">Create Role</h2>

            <form id="role-form" action="{{ route('roles.store') }}" method="POST">
                @csrf
                <input type="hidden" id="role-id" name="role_id">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-bold">Role Name</label>
                    <input type="text" name="name" id="role-name"
                        class="mt-1 block w-full border border-gray-300 rounded p-2" required>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="close-modal"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('role-modal');
            const form = document.getElementById('role-form');
            const title = document.getElementById('modal-title');
            const roleIdInput = document.getElementById('role-id');
            const roleNameInput = document.getElementById('role-name');
            const createRoleBtn = document.getElementById('create-role-btn');
            const closeModalBtn = document.getElementById('close-modal');

            // Check if elements exist before attaching listeners
            if (createRoleBtn) {
                createRoleBtn.addEventListener('click', function() {
                    form.action = '{{ route('roles.store') }}';
                    form.removeAttribute('data-method');
                    title.textContent = 'Create Role';
                    roleIdInput.value = '';
                    roleNameInput.value = '';
                    modal.classList.remove('hidden');
                });
            }

            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    form.reset();
                });
            }

            document.querySelectorAll('.edit-role-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-role-id');
                    const roleName = this.getAttribute('data-role-name');

                    if (form) {
                        form.action = `/roles/${roleId}`;
                        form.setAttribute('data-method', 'PUT');

                        if (!form.querySelector('input[name="_method"]')) {
                            form.insertAdjacentHTML('beforeend',
                                '<input type="hidden" name="_method" value="PUT">');
                        }

                        title.textContent = 'Edit Role';
                        roleIdInput.value = roleId;
                        roleNameInput.value = roleName;
                        modal.classList.remove('hidden');
                    }
                });
            });
        });
    </script>
</x-app-layout>
