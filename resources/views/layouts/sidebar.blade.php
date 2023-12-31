<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="{{ asset('assets') }}/img/profile_small.jpg" />
                    <div class="dropdown-toggle">
                        <span class="block m-t-xs font-bold text-white">Hai, {{ explode(" ", auth()->user()->name)[0] }}..</span>
                        <span class="text-muted text-xs block">{{ ucfirst(auth()->user()->role->name) }}</span>
                    </div>
                </div>
                <div class="logo-element">
                    SC
                </div>
            </li>

            @php $role = auth()->user()->role->name @endphp

            @if (
            $role == 'Admin' ||
            $role == 'Pimpinan'
            )
            <li class="{{( request()->routeIs('dashboard')) ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            @endif

            @if ($role == 'Admin')
            <li class="{{ request()->routeIs('class.index') ? 'active' : '' }}">
                <a href="{{ route('class.index') }}"><i class="fa fa-university"></i> <span class="nav-label">Kelas</span></a>
            </li>

            <li class="{{ request()->routeIs('matkul.index') ? 'active' : '' }}">
                <a href="{{ route('matkul.index') }}"><i class="fa fa-book"></i> <span class="nav-label">Matkul</span></a>
            </li>
            @endif

            <li class="{{ (
                    request()->routeIs('schedule.index') OR
                    request()->routeIs('schedule.show') OR
                    request()->routeIs('schedule-detail.create')
                ) ? 'active' : '' }}">
                <a href="{{ route('schedule.index') }}"><i class="fa fa-calendar"></i> <span class="nav-label">Jadwal</span></a>
            </li>

            @if ($role == 'Admin')
            <li class="{{ request()->routeIs('user.index') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}"><i class="fa fa-user"></i> <span class="nav-label">User</span></a>
            </li>
            @endif

            <li class="special_link">
                <a href="javascript:void(0)" id="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Keluar</span></a>
            </li>
        </ul>

    </div>
</nav>