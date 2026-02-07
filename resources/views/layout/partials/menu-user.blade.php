@if(Auth::user()->role === 'admin')
    <li>
        <a href="{{ url('/admin/users') }}">
            <i class="ti ti-settings"></i>
            <span>Administration</span>
        </a>
    </li>
@endif

@if(Auth::user()->role === 'reception')
    <li>
        <a href="{{ url('/appointments') }}">
            <i class="ti ti-calendar"></i>
            <span>Rendez-vous</span>
        </a>
    </li>
@endif

@if(Auth::user()->role === 'mecanicien')
    <li>
        <a href="{{ url('/repairs') }}">
            <i class="ti ti-tools"></i>
            <span>Réparations</span>
        </a>
    </li>
@endif
