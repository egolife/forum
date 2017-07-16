@impersonating
    <li>
        <a href="{{ route('impersonate.leave') }}">Leave impersonation</a>
    </li>
@else
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            Impersonate <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            @foreach($users as $user)
                <li>
                    <a href="{{ route('impersonate', $user->id) }}">{{ $user->name }}</a>
                </li>
            @endforeach
        </ul>
    </li>
@endImpersonating