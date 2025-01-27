<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{
    public function showUploadForm(){
        return view('upload');
    }

    public function upload(Request $request){
        // validate if the request is a file 
        $request->validate([
            'file' => 'required|file'
        ]);

        // get the file from the request
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        // upload the file to s3
        $file->storeAs('uploads', $fileName, 's3');

        // return a success message
        return redirect()->route('files.index')->with('success', 'File uploaded successfully');
    }

    public function index()
    {
        $files = collect(Storage::disk('s3')->files('uploads'))->map(function($file) {
            return (object)[
                'name' => basename($file),
                'size' => $this->formatBytes(Storage::disk('s3')->size($file)),
                'created_at' => \Carbon\Carbon::createFromTimestamp(Storage::disk('s3')->lastModified($file))
            ];
        });

        return view('files.index', compact('files'));
    }

    public function download($filename)
    {
        $path = 'uploads/' . $filename;
        
        if (Storage::disk('s3')->exists($path)) {
            return Storage::disk('s3')->download($path);
        }
        
        return redirect()->route('files.index')->with('error', 'File not found');
    }

    public function destroy($filename)
    {
        $path = 'uploads/' . $filename;
        
        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
            return redirect()->route('files.index')->with('success', 'File deleted successfully');
        }
        
        return redirect()->route('files.index')->with('error', 'File not found');
    }

    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
