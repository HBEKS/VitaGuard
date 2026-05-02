@if($services->count() > 0)
    <ul class="mb-0" style="list-style-type: disc; padding-left: 20px;">
        @foreach($services as $service)
            <li class="mb-1">{{ $service->service_name }}</li>
        @endforeach
    </ul>
@else
    <p class="text-muted fst-italic mb-0">Tidak ada layanan untuk kategori ini</p>
@endif
