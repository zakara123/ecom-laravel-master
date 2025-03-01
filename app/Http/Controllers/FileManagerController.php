<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FileManagerController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('files.index', compact('files'));
    }

    public function create()
    {
        return view('files.create');
    }

    public function store(Request $request)
    {
        // Validate file input
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,webp|max:2048', // Adjust the mime types as needed
        ]);

        try {
            if ($request->hasFile('file')) {
                $uploadedFile = $request->file('file');
                $path = $uploadedFile->store('uploads', 'public'); // Use 'public' disk

                // Use the file name as the title
                $fileName = $uploadedFile->getClientOriginalName();

                // $path = 'uploads/' . $fileName;

                // if (!Storage::disk('public')->exists($path)) {
                //     $uploadedFile->storeAs('uploads', $fileName, 'public');
                // } else {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'File with the same name already exists.',
                //     ], 400);
                // }

                // Create file record
                $file = File::create([
                    'title' => $fileName,  // Save the uploaded file name as the title
                    'description' => $request->description ?? '', // Use input description if available
                    'mimeType' => $uploadedFile->getClientMimeType(), // Get the actual MIME type
                    'fileSize' => $uploadedFile->getSize(),
                    'bucketName' => config('filesystems.default'),
                    'key' => $path,
                    'url' => Storage::url($path),
                ]);

                // Return success response
                if ($request->ajax()) {
                    return response()->json(['success' => true, 'message' => 'File uploaded successfully', 'data' => $file], 200);
                }

                return redirect()->route('file-manager.index')->with('success', 'File uploaded successfully');
            }

            // Return error response if no file was uploaded
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'No file was uploaded.'], 400);
            }

            return redirect()->route('file-manager.index')->with('error', 'No file was uploaded.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('File upload error: ' . $e->getMessage());

            // Return error response
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'There was an error uploading the file.'], 500);
            }

            return redirect()->route('file-manager.index')->with('error', 'There was an error uploading the file.');
        }
    }

    public function storeMultiple(Request $request)
    {
        // Validate file input for multiple uploads
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,webp|max:2048', // Adjust the mime types as needed
        ]);

        try {
            if ($request->hasFile('files')) {
                $uploadedFiles = $request->file('files');
                $fileRecords = [];

                foreach ($uploadedFiles as $uploadedFile) {
                    $path = $uploadedFile->store('uploads', 'public'); // Use 'public' disk

                    // Use the file name as the title
                    $fileName = $uploadedFile->getClientOriginalName();

                    // Create file record
                    $file = File::create([
                        'title' => $fileName,  // Save the uploaded file name as the title
                        'description' => $request->description ?? '', // Use input description if available
                        'mimeType' => $uploadedFile->getClientMimeType(), // Get the actual MIME type
                        'fileSize' => $uploadedFile->getSize(),
                        'bucketName' => config('filesystems.default'),
                        'key' => $path,
                        'url' => Storage::url($path),
                    ]);

                    $fileRecords[] = $file;
                }

                // Return success response
                if ($request->ajax()) {
                    return response()->json(['success' => true, 'message' => 'Files uploaded successfully', 'data' => $fileRecords], 200);
                }

                return redirect()->route('file-manager.index')->with('success', 'Files uploaded successfully');
            }

            // Return error response if no files were uploaded
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'No files were uploaded.'], 400);
            }

            return redirect()->route('file-manager.index')->with('error', 'No files were uploaded.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('File upload error: ' . $e->getMessage());

            // Return error response
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'There was an error uploading the files.'], 500);
            }

            return redirect()->route('file-manager.index')->with('error', 'There was an error uploading the files.');
        }
    }

    public function show($id)
    {
        try {
            $file = File::findOrFail($id);
            return view('files.show', compact('file'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('file-manager.index')->with('error', 'File not found.');
        }
    }

    public function destroy($id)
    {
        try {
            $file = File::findOrFail($id);
            Storage::delete($file->key);
            $file->delete();

            return redirect()->route('file-manager.index')->with('success', 'File deleted successfully');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('file-manager.index')->with('error', 'File not found.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('File deletion error: ' . $e->getMessage());
            return redirect()->route('file-manager.index')->with('error', 'There was an error deleting the file.');
        }
    }

    public function getFiles(Request $request)
    {
        // Get the search query, default to an empty string if not present
        $searchQuery = $request->get('search', '');

        // If a search query is provided, filter the files by name
        if ($searchQuery) {
            $files = File::where('title', 'like', '%' . $searchQuery . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // If no search query, get all files
            $files = File::orderBy('created_at', 'desc')->get();
        }

        // Render the view with files (either all or filtered)
        $view = view('components.file-management.all-files', compact('files'))->render();

        // Return the view with the files
        return response()->json(['files' => $view]);
    }
}
