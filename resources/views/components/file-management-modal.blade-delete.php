<style>
    .file-card.selected {
        border: 2px solid #4f46e5; /* Indigo */
        background-color: #e0e7ff; /* Light Indigo */
    }
</style>

{{--<button id="open-modal-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Manage Files</button>--}}

<!-- Modal for File Management -->
<div id="file-management-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-6 rounded-lg w-2/3 max-w-4xl relative">
        <h2 class="text-xl font-bold mb-4">File Management</h2>
        <!-- Close Button -->
        <button id="close-modal-btn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl font-bold">
            &times;
        </button>
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 rounded-t-lg tab-button active bg-indigo-600 text-white"
                        data-tab="files-tab"
                        type="button"
                        role="tab"
                        aria-controls="files-tab"
                        aria-selected="true"
                    >
                        All Files
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 rounded-t-lg tab-button"
                        data-tab="upload-tab"
                        type="button"
                        role="tab"
                        aria-controls="upload-tab"
                        aria-selected="false"
                    >
                        Upload File
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Contents -->
        <div id="files-tab" class="tab-content">
            <div class="card py-3">
                <div class="card-body bg-white">
                    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-4 p-4" id="file-list">
                        <!-- File cards will be dynamically loaded here -->
                    </div>
                    <div id="pagination" class="mt-4"></div> <!-- Pagination controls -->
                </div>
            </div>
        </div>

        <div id="upload-tab" class="tab-content hidden">
            <form id="file-form" action="{{ route('file-manager.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                @csrf
                <div id="drag-drop-area" class="w-full h-32 flex justify-center items-center text-gray-500">
                    <label for="file-input" class="cursor-pointer p-8 bg-gray-200 rounded-lg">
                        Drag and drop a file here or click to select
                    </label>
                    <input type="file" name="file" id="file-input" class="hidden" required multiple>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4 hidden" id="progress-container">
                    <div class="bg-blue-600 h-2.5 rounded-full" id="progress-bar"></div>
                </div>
                <div id="success-message" class="hidden text-green-500 mt-2"></div>
                <div class="flex justify-end mt-6">
                    <button type="button" id="cancel-upload" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end mt-4">
            <button id="cancel-selection-btn" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
            <button id="select-files-btn" class="bg-indigo-600 text-white px-4 py-2 rounded">Select Files</button>
        </div>
    </div>
</div>

<script>
    let selectedFiles = [];

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('file-management-modal');
        const openModalBtn = document.getElementById('open-modal-btn');
        const openModalBtn2 = document.getElementById('open-modal-btn2');

        const closeModalBtn = document.getElementById('close-modal-btn');
        const tabButtons = document.querySelectorAll('.tab-button');
        const fileListContainer = document.getElementById('file-list');
        const paginationContainer = document.getElementById('pagination');
        const cancelSelectionBtn = document.getElementById('cancel-selection-btn');
        const selectFilesBtn = document.getElementById('select-files-btn');
        const filePreviewContainer = document.querySelector('.file-preview');

        const fileInput = document.getElementById('file-input');
        const progressContainer = document.getElementById('progress-container');
        const progressBar = document.getElementById('progress-bar');
        const successMessage = document.getElementById('success-message');
        const fileForm = document.getElementById('file-form');
        const cancelUploadButton = document.getElementById('cancel-upload');

        // Open Modal
        openModalBtn?.addEventListener('click', () => {
            modal.classList.remove('hidden');
            loadFiles(1); // Load files when the modal opens
        });

        // Open Modal
        openModalBtn2?.addEventListener('click', () => {
            modal.classList.remove('hidden');
            loadFiles(1); // Load files when the modal opens
        });

        // Close Modal
        [closeModalBtn, cancelSelectionBtn].forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });

        // Tab Switching
        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                tabButtons.forEach(btn => btn.classList.remove('active', 'bg-indigo-600', 'text-white'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

                button.classList.add('active', 'bg-indigo-600', 'text-white');
                document.getElementById(button.dataset.tab).classList.remove('hidden');

                if (button.dataset.tab === 'files-tab') {
                    loadFiles(1); // Reload files when switching to "All Files" tab
                }
            });
        });

        // Load Files with AJAX
        function loadFiles(page) {
            $.ajax({
                url: `/file-manager/all-files?page=${page}`, // Adjust route accordingly
                type: 'GET',
                success: function (response) {
                    fileListContainer.innerHTML = response.files || '<p>No files found.</p>'; // Update file list
                    paginationContainer.innerHTML = response.pagination || ''; // Update pagination
                },
                error: function (xhr) {
                    console.error('Error loading files:', xhr);
                    Swal.fire('Error!', 'Could not load files.', 'error');
                }
            });
        }

        document.getElementById('cancel-upload').addEventListener('click', () => {
            modal.classList.add('hidden'); // Close modal
            document.getElementById('file-form').reset(); // Clear the form
        });

        // // Attach click event to dynamically loaded file cards
        // function attachCardClickListeners() {
        //     const fileCards = document.querySelectorAll('.file-card');
        //     fileCards.forEach(card => {
        //         card.addEventListener('click', function () {
        //             toggleSelection(card);
        //         });
        //     });
        // }

        // Toggle card selection
        function toggleSelection(card) {
            const fileId = card.getAttribute('data-id');

            if (card.classList.contains('selected')) {
                // If already selected, unselect
                card.classList.remove('selected');
                selectedFiles = selectedFiles.filter(id => id !== fileId); // Remove ID from array
            } else {
                // If not selected, select
                card.classList.add('selected');
                selectedFiles.push(fileId); // Add ID to array
            }

            // Update hidden input field
            selectedFilesInput.value = selectedFiles.join(',');

            console.log(selectedFiles);
        }

        fileInput.addEventListener('change', function () {
            const files = fileInput.files;
            if (!files.length) return;

            // Show progress container and cancel button
            progressContainer.classList.remove('hidden');
            cancelUploadButton.classList.remove('hidden');

            let completedUploads = 0;

            Array.from(files).forEach((file, index) => {
                const formData = new FormData();
                formData.append('file', file);

                // Create AJAX request for each file
                const xhr = new XMLHttpRequest();
                xhr.open('POST', fileForm.action, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);

                // Update progress bar
                xhr.upload.addEventListener('progress', function (event) {
                    if (event.lengthComputable) {
                        const percentComplete = (event.loaded / event.total) * 100;
                        progressBar.style.width = percentComplete + '%';
                    }
                });

                // Handle upload success
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        completedUploads++;
                        successMessage.textContent = `File ${index + 1} uploaded successfully!`;
                        successMessage.classList.remove('hidden');
                        cancelUploadButton.classList.add('hidden'); // Hide cancel button
                        loadFiles(1);
                    } else {
                        Swal.fire('Error!', `File ${index + 1} upload failed.`, 'error');
                    }
                };

                // Handle upload error
                xhr.onerror = function () {
                    Swal.fire('Error!', `An error occurred during the upload of file ${index + 1}.`, 'error');
                };

                // Send the file
                xhr.send(formData);
            });
        });

        cancelUploadButton.addEventListener('click', () => {
            fileForm.reset(); // Clear the form
            progressContainer.classList.add('hidden'); // Hide progress container
            progressBar.style.width = '0%'; // Reset progress bar
            successMessage.classList.add('hidden'); // Hide success message
            cancelUploadButton.classList.add('hidden'); // Hide cancel button
        });
    });

    // Handle the button click to open the modal
    document.querySelectorAll('[data-toggle="modal"]').forEach(button => {
        button.addEventListener('click', (event) => {
            // Get the target input and preview container from the button's data attributes
            const targetInputId = event.target.dataset.targetInput;
            const previewContainerId = event.target.dataset.previewContainer;

            // Store these values in a global variable or pass them to the modal
            const modal = document.getElementById('file-management-modal');
            modal.dataset.targetInput = targetInputId;
            modal.dataset.previewContainer = previewContainerId;

            // Optionally, clear the file preview container when opening the modal
            document.getElementById(previewContainerId).innerHTML = '';
        });
    });

    function toggleCheckbox(fileId) {
        const checkbox = document.getElementById(`checkbox-${fileId}`);
        const card = document.getElementById(`file-card-${fileId}`);

        // Toggle checkbox state
        checkbox.checked = !checkbox.checked;

        // Highlight card if selected
        if (checkbox.checked) {
            selectedFiles.push(fileId); // Add ID to array
            card.classList.add('bg-indigo-100');
        } else {
            selectedFiles = selectedFiles.filter(id => id !== fileId); // Remove ID from array
            card.classList.remove('bg-indigo-100');
        }
        // Update hidden input field
        // selectedFilesInput.value = selectedFiles.join(',');

        console.log(selectedFiles);
    }

    // Function to update the hidden input with selected file IDs
    function updateSelectedFilesInput(inputId, selectedFiles) {
        const selectedFilesInput = document.getElementById(inputId);
        if (selectedFilesInput) {
            selectedFilesInput.value = selectedFiles.join(',');
        } else {
            console.error(`Input element with ID "${inputId}" not found.`);
        }
    }

    // Function to display the selected file previews
    function displayFilePreviews(containerId, selectedFiles) {
        const filePreviewContainer = document.getElementById(containerId);
        if (!filePreviewContainer) {
            console.error(`Preview container with ID "${containerId}" not found.`);
            return;
        }

        if (selectedFiles.length > 0) {
            filePreviewContainer.innerHTML = selectedFiles.map(id => {
                const card = document.querySelector(`#file-card-${id}`);
                if (!card) return ''; // Skip if the card is not found

                const imgSrc = card.querySelector('img').src;
                const title = card.querySelector('span:first-child').textContent;

                return `
                <div class="flex items-center mb-2">
                    <img src="${imgSrc}" alt="${title}" class="w-12 h-12 rounded mr-2">
                    <span class="text-sm">${title}</span>
                </div>
            `;
            }).join('');
        } else {
            filePreviewContainer.innerHTML = '<p class="text-gray-500 text-sm">No files selected.</p>';
        }
    }

    // Function to handle file selection and modal closing
    function handleFileSelection(modalId, inputId, previewContainerId, selectedFiles) {
        updateSelectedFilesInput(inputId, selectedFiles);
        displayFilePreviews(previewContainerId, selectedFiles);

        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden'); // Close the modal
        } else {
            console.error(`Modal with ID "${modalId}" not found.`);
        }
    }

    // Event Listener for the "Select Files" Button
    document.getElementById('select-files-btn').addEventListener('click', () => {
        handleFileSelection('file-management-modal', 'product-images', 'product-images-file-preview-container', selectedFiles);
    });

    document.getElementById('select-files-btn').addEventListener('click', () => {
        handleFileSelection('file-management-modal', 'product-thumb-images', 'product-thumb-images-file-preview-container', selectedFiles);
    });

</script>


