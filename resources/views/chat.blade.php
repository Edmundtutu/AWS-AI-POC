@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card chat-container">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-robot"></i> Chat Bot</h5>
            </div>
            <div class="chat-messages" id="chatMessages">
                <div class="message message-bot">
                    Hello! How can I help you today?
                </div>
                <div class="typing-indicator message-bot" id="typingIndicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="chat-input">
                <form id="chatForm" class="d-flex gap-2">
                    @csrf
                    <input type="text" id="messageInput" class="form-control" placeholder="Type your message..." required>
                    <button type="submit" class="btn btn-info text-white">
                        <i class="fas fa-paper-plane"></i> Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/chat.js') }}"></script>
@endpush 