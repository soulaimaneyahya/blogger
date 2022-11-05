<div class="d-flex align-items-center justify-content-between mb-2">
    <form action="#result" method="GET">
        <select class="form-control" name="per_page" id="per_page" onchange="this.form.submit()">
            <option value="5" @if(request('per_page') == 5) selected @endif>5</option>
            <option value="10" @if(request('per_page') == 10) selected @endif>10</option>
            <option value="15" @if(request('per_page') == 15) selected @endif>15</option>
            <option value="20" @if(request('per_page') == 20) selected @endif>20</option>
        </select>
    </form>
    <div>
        {{ $commentList->links() }}
    </div>
</div>

@foreach ($commentList as $comment)
<li class="list-group-item d-flex align-items-center" id="result">
    <img src="{{ $comment->user->profile->image ? $comment->user->profile->image->url() : asset('storage/laravolt/avatar-'. $comment->user->id.'.png') }}" class="rounded-circle" width="40" />
    <div class="mx-3">
        <p class="m-0 p-0">{{ $comment->content }} - {{ $comment->id }}</p>
        @updated(['date'=> $comment->created_at, 'name'=> $comment->user->username, 'user' => $comment->user])
        @endupdated
    </div>
</li>
@endforeach
