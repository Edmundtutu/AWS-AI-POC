@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0"><i class="fas fa-cloud-upload-alt"></i> Upload File to S3</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('upload.store') }}" class="dropzone" id="my-dropzone">
                    @csrf
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted mb-3">Maximum file size: 10MB</p>
                    <button type="button" id="submit-dropzone" class="btn btn-info">
                        <i class="fas fa-cloud-upload-alt"></i> Upload Files
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection