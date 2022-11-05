<form action="{{ $route }}" method="POST">
    @csrf
    <div class="form-floating">
        <textarea class="form-control comment-textarea" placeholder="Leave a comment here" name="content" id="content"></textarea>
        <label for="content">{{ $placeholder ?? 'Join the discussion and leave a comment' }}</label>
    </div>
    <div><input type="submit" value="Add Comment" class="btn btn-dark btn-sm my-2"></div>
</form>
