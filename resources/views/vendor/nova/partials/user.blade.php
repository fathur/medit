<dropdown-trigger class="h-9 flex items-center">
    @isset($user->email)
        <img
            src="https://secure.gravatar.com/avatar/{{ md5(\Illuminate\Support\Str::lower($user->email)) }}?size=512"
            class="rounded-full w-8 h-8 mr-3"
        />
    @endisset

    <span class="text-90">
        {{ $user->name ?? $user->email ?? __('Nova User') }}
    </span>
</dropdown-trigger>

<dropdown-menu slot="menu" width="200" direction="rtl">
    <ul class="list-reset">
        <li>
            <a href="{{ url("resources/users/" . \Illuminate\Support\Facades\Auth::user()->id) }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('My Profile') }}
            </a>
        </li>
    </ul>

    @if(\Illuminate\Support\Facades\Auth::user()->companies()->count() == 1)
    <ul class="list-reset">
        <li>
            <a href="{{ url("resources/companies/" . \Illuminate\Support\Facades\Auth::user()->companies()->first()->id) }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('My Company') }}
            </a>
        </li>
    </ul>
    @endif

    <ul class="list-reset">
        <li>
            <a href="{{ route('nova.logout') }}" class="block no-underline text-90 hover:bg-30 p-3">
                {{ __('Logout') }}
            </a>
        </li>
    </ul>
</dropdown-menu>
