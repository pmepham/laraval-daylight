<ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
        <a href="/dashboard" class="text-gray-500 text-hover-primary" data-bs-toggle="tooltip" title="Dashboard">
            <i class="ki-solid ki-home fs-3 text-gray-500 me-n1"></i>
        </a>
    </li>
   
    @foreach ($items as $item)
        <li class="breadcrumb-item"><i class="ki-solid ki-right fs-4 text-gray-700 mx-n1"></i></li>
        @if(!empty($item['link']))
        <li class="breadcrumb-item text-gray-700 fw-bold lh-1"><a href="{{ $item['link'] }}" class="text-gray-500 text-hover-primary">{{ $item['name'] }}</a></li>
        @else
        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">{{ $item['name'] }}</li>
        @endif
    @endforeach
</ul>