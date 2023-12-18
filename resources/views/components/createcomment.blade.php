<form method="POST" action="{{ url('/createcomment') }}">
    @csrf
    <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">Comment:</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="content">
    </div>
    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
    <button type="submit" class="btn btn-primary">Submit</button>    
</form>