<div class="d-flex align-items-center gap-2 justify-content-end">
    @isset($viewUrl)
        <a class="btn btn-sm btn-secondary" href="{{ $viewUrl }}">View</a>
    @endisset

    @isset($editClass)
        <button class="btn btn-sm btn-primary {{ $editClass }}" data-{{ $attribute }}="{{ $id }}">Edit</button>
    @elseif($editUrl)
        <a class="btn btn-sm btn-primary" href="{{ $editUrl }}">Edit</a>
    @endif

    @isset($archiveClass)
        <button class="btn btn-sm btn-warning {{ $archiveClass }}" data-{{ $attribute }}="{{ $id }}">Archive</button>
    @endisset

    @isset($deleteClass)
        <button class="btn btn-sm btn-danger {{ $deleteClass }}" data-{{ $attribute }}="{{ $id }}">Delete</button>
    @endisset
</div>
