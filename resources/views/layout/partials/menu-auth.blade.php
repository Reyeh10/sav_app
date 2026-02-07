@guest
<li class="submenu">
    <a href="#">
        <i class="ti ti-login"></i>
        <span>Authentification</span>
        <span class="menu-arrow"></span>
    </a>
    <ul>
        <li><a href="{{ route('login') }}">Connexion</a></li>
        <li><a href="{{ route('register') }}">Créer un compte</a></li>
    </ul>
</li>
@endguest
