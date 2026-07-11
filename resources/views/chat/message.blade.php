@forelse($messages as $message)
<div class="mb-3">
    <strong>{{ $message->sender->name }}</strong>
    <br>
    <div class="border rounded p-2 bg-white">
        {{ $message->message }}
    </div>
    <small class="text-muted">
        {{ $message->created_at->format('d M Y H:i') }}
    </small>
</div>
@empty
<div class="text-center text-muted">
    Belum ada percakapan.
</div>
@endforelse