@foreach($notifications as $notification)
    {{-- <a  onclick="window.location='{{ route('admin.sale.show', $notification->id) }}';" class="text-muted">Посмотреть</a> --}}
    <a href="{{ route('admin.sale.show', $notification->id) }}" class="btn btn-primary">Посмотреть</a>
@endforeach