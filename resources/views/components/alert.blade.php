<div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
    {{ Session::get('alert-' . $msg) }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
