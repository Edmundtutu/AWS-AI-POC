@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-file-alt"></i> Uploaded Files</h3>
                <a href="{{ route('upload.show') }}" class="btn btn-light">
                    <i class="fas fa-upload text-muted"></i> Upload New File
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Uploaded At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($files as $file)
                            <tr>
                                <td>
                                    <i class="fas fa-file me-2"></i>
                                    {{ $file->name }}
                                </td>
                                <td>{{ $file->size }}</td>
                                <td>{{ $file->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('download', $file->name) }}" class="btn btn-sm btn-success rounded-circle">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('files.destroy', $file->name) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-circle" onclick="return confirm('Are you sure you want to delete this file?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">No files uploaded yet</p>
                                    <a href="{{ route('upload.show') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-upload"></i> Upload Your First File
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 