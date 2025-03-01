<x-app-layout>
    <div class="container mx-auto mt-5">
        <h1 class="text-xl font-semibold mb-4">Manage Permissions for Role: {{ $role->name }}</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">{{ session('success') }}</strong>
            </div>
        @endif

        <form action="{{ route('roles.permissions.store', $role) }}" method="POST">
            @csrf
            <div class="mb-4">
                @foreach($permissions as $permission)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                        <label for="permission_{{ $permission->id }}" class="ml-2 text-gray-700">{{ $permission->name }}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Assign Permissions</button>
        </form>

        <h2 class="text-lg font-semibold mt-6">Assigned Permissions</h2>
        <table class="min-w-full bg-white border mt-4">
            <thead>
            <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($role->permissions as $permission)
                <tr>
                    <td class="border px-4 py-2">{{ $permission->id }}</td>
                    <td class="border px-4 py-2">{{ $permission->name }}</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('roles.permissions.destroy', [$role, $permission]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500" onclick="return confirm('Are you sure?')">Revoke</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
