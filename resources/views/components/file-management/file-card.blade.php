<div class="bg-white border border-gray-200 rounded-lg shadow p-2 relative" id="file-card-{{ $file->id }}">
    <input type="checkbox" class="absolute top-2 left-2 rounded">
    <button class="text-gray-600 hover:text-gray-800 focus:outline-none absolute top-2 right-2" id="menu-{{ $file->id }}" onclick="toggleMenu(event, {{ $file->id }})">
        <svg width="20px" height="20px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 12C9.10457 12 10 12.8954 10 14C10 15.1046 9.10457 16 8 16C6.89543 16 6 15.1046 6 14C6 12.8954 6.89543 12 8 12Z" fill="#000000"/>
            <path d="M8 6C9.10457 6 10 6.89543 10 8C10 9.10457 9.10457 10 8 10C6.89543 10 6 9.10457 6 8C6 6.89543 6.89543 6 8 6Z" fill="#000000"/>
            <path d="M10 2C10 0.89543 9.10457 -4.82823e-08 8 0C6.89543 4.82823e-08 6 0.895431 6 2C6 3.10457 6.89543 4 8 4C9.10457 4 10 3.10457 10 2Z" fill="#000000"/>
        </svg>
    </button>
    <div class="relative">
        <!-- Dropdown menu -->
        <div class="absolute right-0 top-5 bg-white border border-gray-200 shadow-lg z-10 hidden" id="dropdown-menu-{{ $file->id }}">
            <button class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-100" onclick="confirmDelete('{{ $file->id }}')">Delete</button>
        </div>
    </div>

    <img src="{{ $file->url }}" alt="{{ $file->title }}" class="w-full h-auto rounded">
    <div class="flex justify-between items-center mt-1">
        <span>{{ $file->title }}</span>
        <span>{{ round($file->fileSize / 1024, 2) }} KB</span> <!-- Adjust size to KB -->
    </div>
</div>
