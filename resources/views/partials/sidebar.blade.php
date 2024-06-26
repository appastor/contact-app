<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('home*') ? 'active' : '' }}" href="{{ route('home') }}">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('contacts*') ? 'active' : '' }}" href="{{ route('contacts.index') }}">
                    Contacts
                </a>
            </li>
        </ul>
    </div>
</nav>