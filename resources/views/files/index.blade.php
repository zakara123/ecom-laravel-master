<x-app-layout>
    <div class="container mx-auto p-4">
        <!-- Files Listing Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Files</h1>
            <button id="upload-file-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Upload File</button>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-2 my-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="card py-3">
            <div class="card-header flex justify-between items-center">
                <h5 class="card-title">All Files</h5>

                <div class="flex items-center">
                    <!-- Delete Selected Button -->
                    <button id="delete-selected" class="bg-red-500 text-white px-4 py-2 rounded mx-2">Delete Selected</button>

                    <!-- Search Input -->
                    <input type="text" class="form-control mr-2" placeholder="Search..." aria-label="Search files" id="search-input">
                </div>
            </div>
            <div class="card-body bg-white">
                <!-- Files Cards -->
                <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-4 p-4">
                    @foreach($files as $file)
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-2 relative">
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Uploading File -->
    <div id="file-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg w-2/3 h-1/2 flex flex-col justify-center items-center border-dashed border-4 border-gray-300"
             ondrop="handleDrop(event)" ondragover="event.preventDefault()">
            <h2 id="modal-title" class="text-xl font-bold mb-4">Upload File</h2>
            <form id="file-form" action="{{ route('file-manager.store') }}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col items-center">
                @csrf
                <!-- Drag and Drop Box -->
                <div id="drag-drop-area" class="w-full h-32 flex justify-center items-center text-gray-500">
                    <label for="file-input" class="cursor-pointer p-8 bg-gray-200 rounded-lg">
                        Drag and drop a file here or click to select
                    </label>
                    <input type="file" name="file" id="file-input" class="hidden" required>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4 hidden" id="progress-container">
                    <div class="bg-blue-600 h-2.5 rounded-full" id="progress-bar"></div>
                </div>
                <div id="success-message" class="hidden text-green-500 mt-2"></div>

                <div class="flex justify-end mt-6">
                    <button type="button" id="close-modal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script for Modal and File Upload -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('file-modal');
            const form = document.getElementById('file-form');
            const fileInput = document.getElementById('file-input');
            const progressBar = document.getElementById('progress-bar');
            const progressContainer = document.getElementById('progress-container');
            const successMessage = document.getElementById('success-message'); // Add a success message element

            // Open modal on upload button click
            document.getElementById('upload-file-btn').addEventListener('click', function () {
                form.reset();
                progressContainer.classList.add('hidden');
                modal.classList.remove('hidden');
            });

            // Close modal
            document.getElementById('close-modal').addEventListener('click', function () {
                modal.classList.add('hidden');
                form.reset();
            });

            // Drag-and-drop support
            function handleDrop(event) {
                event.preventDefault();
                if (event.dataTransfer.items) {
                    const file = event.dataTransfer.items[0].getAsFile();
                    fileInput.files = event.dataTransfer.files;
                    uploadFile();
                }
            }

            // Direct upload when file is selected or dropped
            fileInput.addEventListener('change', uploadFile);

            function uploadFile() {
                const formData = new FormData();
                formData.append('file', fileInput.files[0]);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');  // Add CSRF token header

                // Update progress bar
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        progressBar.style.width = percentComplete + '%';
                        progressContainer.classList.remove('hidden');
                    }
                });

                // On success, show 100% progress and success message
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Set progress to 100%
                        progressBar.style.width = '100%';
                        // Show success message
                        successMessage.classList.remove('hidden');
                        successMessage.textContent = 'File uploaded successfully!'; // Adjust message as needed
                        progressContainer.classList.remove('hidden');
                    } else {
                        // Handle other status codes
                        Swal.fire('Error!', 'There was a problem with your request.', 'error');
                    }
                };

                xhr.send(formData);
            }
        });

        document.getElementById('delete-selected').addEventListener('click', function() {
            const selectedFiles = [];
            // Get all checkboxes and filter for checked ones
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                selectedFiles.push(checkbox.closest('.bg-white').id); // Assuming the parent div has an id of the file ID
            });

            if (selectedFiles.length > 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Call the delete function for selected files
                        deleteSelectedFiles(selectedFiles);
                    }
                });
            } else {
                Swal.fire('No files selected', 'Please select files to delete.', 'info');
            }
        });

        function deleteSelectedFiles(fileIds) {
            $.ajax({
                url: '/file-manager/bulk-delete', // Adjust the route accordingly
                type: 'POST',
                data: { file_ids: fileIds, _token: '{{ csrf_token() }}' }, // Include CSRF token
                success: function(response) {
                    Swal.fire('Deleted!', 'Selected files have been deleted.', 'success').then(() => {
                        location.reload(); // Reload the page to refresh the file list
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'There was a problem deleting the files.', 'error');
                }
            });
        }

        // image box functionality
        // Toggle the visibility of the dropdown menu
        function toggleMenu(event, fileId) {
            event.stopPropagation(); // Prevent the click event from bubbling up
            const menu = document.getElementById(`dropdown-menu-${fileId}`);
            menu.classList.toggle('hidden'); // Toggle visibility
        }

        // Confirm delete with SweetAlert
        function confirmDelete(fileId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteFile(fileId);
                }
            });
        }

        // AJAX call to delete the file
        function deleteFile(fileId) {
            $.ajax({
                url: `/file-manager/${fileId}`, // Adjust the URL according to your route
                type: 'DELETE',
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload(); // Optionally reload to refresh the file list
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'There was a problem deleting the file.',
                        'error'
                    );
                }
            });
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            const dropdowns = document.querySelectorAll('.absolute.right-0.mt-2');
            dropdowns.forEach(dropdown => {
                if (!event.target.closest('.relative')) {
                    dropdown.classList.add('hidden');
                }
            });
        }

    </script>
</x-app-layout>
