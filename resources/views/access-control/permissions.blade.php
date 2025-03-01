<x-app-layout>
    <div class="container mx-auto">
        <h2 class="text-lg font-semibold mb-6">Manage Permissions</h2>

        <div class="flex justify-end mb-4">
            <button id="create-permission-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Create Permission</button>
        </div>

        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-b border-gray-300 text-left text-sm font-medium text-gray-600">#</th>
                <th class="px-4 py-2 border-b border-gray-300 text-left text-sm font-medium text-gray-600">Name</th>
                <th class="px-4 py-2 border-b border-gray-300 text-left text-sm font-medium text-gray-600">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $permission)
                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                    <td class="border-b border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $permission->id }}</td>
                    <td class="border-b border-gray-300 px-4 py-2 text-sm text-gray-700">{{ $permission->name }}</td>
                    <td class="border-b border-gray-300 px-4 py-2 text-sm text-gray-700">
                        <button class="text-blue-500 hover:text-blue-700 transition duration-150 ease-in-out edit-permission-btn" data-permission-id="{{ $permission->id }}" data-permission-name="{{ $permission->name }}">Edit</button>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Modal for creating/editing permission -->
        <div id="permission-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold mb-4" id="modal-title">Create Permission</h3>
                <form id="permission-form" action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Permission Name</label>
                        <input type="text" name="name" id="permission-name" class="border px-4 py-2 w-full">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" id="close-modal">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('create-permission-btn').addEventListener('click', function () {
            document.getElementById('permission-modal').classList.remove('hidden');
            document.getElementById('modal-title').textContent = 'Create Permission';
            document.getElementById('permission-form').action = "{{ route('permissions.store') }}";
            document.getElementById('form-method').value = 'POST';
            document.getElementById('permission-name').value = '';
        });

        document.querySelectorAll('.edit-permission-btn').forEach(button => {
            button.addEventListener('click', function () {
                const permissionId = this.getAttribute('data-permission-id');
                const permissionName = this.getAttribute('data-permission-name');
                document.getElementById('permission-modal').classList.remove('hidden');
                document.getElementById('modal-title').textContent = 'Edit Permission';
                document.getElementById('permission-form').action = `/permissions/${permissionId}`;
                document.getElementById('form-method').value = 'PUT';
                document.getElementById('permission-name').value = permissionName;
            });
        });

        document.getElementById('close-modal').addEventListener('click', function () {
            document.getElementById('permission-modal').classList.add('hidden');
        });
    </script>
</x-app-layout>
