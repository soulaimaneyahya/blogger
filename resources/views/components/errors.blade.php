@if($errors->any())
  <div class="my-2">
    @foreach($errors->all() as $error)
      <div class="alert alert-danger py-1 px-2 my-2" role="alert">
        {{ $error }}
      </div>
    @endforeach
  </div>
@endif