<p class="p-0 m-0 text-muted">
    {{ empty(trim($slot)) ? 'Added ' : $slot }} {{ $date->diffForHumans() }}
    @if (isset($name))        
        @if (isset($user))
         by <a href="{{ route('users.show', $user) }}">{{ $name }}</a>
        @else
         by {{ $name }}   
        @endif
    @endif
</p>
