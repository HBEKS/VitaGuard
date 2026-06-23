@if($services->count() > 0)
    <ul class="list-unstyled mb-0">
        @foreach($services as $service)
            <li class="mb-1">
                <i class="fas fa-circle text-primary me-2"
                style="font-size: 0.5rem; vertical-align: middle;"></i>
                {{ $service->service_name }}
            </li>
        @endforeach
    </ul>
@else
    <p class="text-muted
    fst-italic mb-0">Tidak ada layanan untuk kategori ini</p>
@endif
