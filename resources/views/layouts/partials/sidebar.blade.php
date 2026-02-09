<header class="main-nav">
    <div class="sidebar-user text-center">
        <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img
            class="img-90 rounded-circle" src="{{ asset('assets/images/dashboard/1.png') }}" alt="" />
        <div class="badge-bottom">
            <span class="badge badge-primary">{{ strtoupper(Auth::user()->role) }}</span>
        </div>
        <a href="user-profile">
            <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->name }}</h6>
        </a>
    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>

                    <!-- Dashboard -->
                    <li>
                        <a class="nav-link menu-title link-nav {{ routeActive('dashboard') }}"
                            href="{{ route('dashboard') }}"><i data-feather="home"></i><span>Dashboard</span></a>
                    </li>

                    <!-- Users -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('users') }}" href="javascript:void(0)"><i
                                data-feather="users"></i><span>Users</span></a>
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('users') }};">
                            <li><a href="{{ route('users.index') }}" class="{{ routeActive('users.index') }}">Data
                                    User
                                </a></li>
                            <li><a href="{{ route('users.create') }}" class="{{ routeActive('users.create') }}">Create
                                    User</a></li>
                        </ul>
                    </li>

                    <!-- Informations -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('informations') }}" href="javascript:void(0)"><i
                                data-feather="edit"></i><span>Informations</span></a>
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('informations') }};">
                            <li><a href="{{ route('informations.index') }}"
                                    class="{{ routeActive('informations.index') }}">Data Information</a></li>
                            <li><a href="{{ route('informations.create') }}"
                                    class="{{ routeActive('informations.create') }}">Create Information</a></li>
                        </ul>
                    </li>

                    <!-- Learnings -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('learnings') }}" href="javascript:void(0)"><i
                                data-feather="layers"></i><span>Learnings</span></a>
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('learnings') }};">
                            <li><a href="{{ route('learnings.index') }}"
                                    class="{{ routeActive('learnings.index') }}">Data Learning</a></li>
                            <li><a href="{{ route('learnings.create') }}"
                                    class="{{ routeActive('learnings.create') }}">Create Learning</a></li>
                        </ul>
                    </li>

                    <!-- Financials -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('financials') }}" href="javascript:void(0)"><i
                                data-feather="dollar-sign"></i><span>Financials</span></a>
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('financials') }};">
                            <li><a href="{{ route('financials.index') }}"
                                    class="{{ routeActive('financials.index') }}">Data Financial</a></li>
                            <li><a href="{{ route('financials.create') }}"
                                    class="{{ routeActive('financials.create') }}">Create Financial</a></li>
                        </ul>
                    </li>

                    <!-- Organizations -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('organizations') }}" href="javascript:void(0)"><i
                                data-feather="globe"></i><span>Organizations</span></a>
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('organizations') }};">
                            <li><a href="{{ route('organizations.index') }}"
                                    class="{{ routeActive('organizations.index') }}">Data Organization</a></li>
                            <li><a href="{{ route('organizations.create') }}"
                                    class="{{ routeActive('organizations.create') }}">Create Organization</a></li>
                        </ul>
                    </li>

                    <!-- Socials -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('socials') }}" href="javascript:void(0)"><i
                                data-feather="share-2"></i><span>Socials</span></a>
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('socials') }};">
                            <li><a href="{{ route('socials.index') }}" class="{{ routeActive('socials.index') }}">Data
                                    Social</a></li>
                            <li><a href="{{ route('socials.create') }}"
                                    class="{{ routeActive('socials.create') }}">Create Social</a></li>
                        </ul>
                    </li>

                    <!-- Votes -->
                    <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('votes') }}" href="javascript:void(0)"><i
                                data-feather="check-square"></i><span>Votes</span></a>
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('votes') }};">
                            <li><a href="{{ route('votes.index') }}" class="{{ routeActive('votes.index') }}">Data
                                    Vote</a></li>
                            <li><a href="{{ route('votes.create') }}" class="{{ routeActive('votes.create') }}">Create
                                    Vote</a></li>
                        </ul>
                    </li>

                    <!-- Broadcasts -->
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('broadcasts') }}" href="javascript:void(0)"><i
                                data-feather="tv"></i><span>Broadcasts</span></a>
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('broadcasts') }};">
                            <li><a href="{{ route('broadcasts.index') }}" class="{{ routeActive('broadcasts.index') }}">Data
                                    Broadcast</a></li>
                            <li><a href="{{ route('broadcasts.create') }}" class="{{ routeActive('broadcasts.create') }}">Create
                                    Broadcast</a></li>
                        </ul>
                    </li> --}}

                    <!-- Vision -->
                    <li>
                        <a class="nav-link menu-title link-nav {{ routeActive('vision.edit') }}"
                            href="{{ route('vision.edit') }}"><i data-feather="target"></i><span>Vision
                                Mission</span></a>
                    </li>

                    <!-- Profile -->
                    <li>
                        <a class="nav-link menu-title link-nav {{ routeActive('profile.index') }}"
                            href="{{ route('profile.index') }}"><i data-feather="user"></i><span>Profile</span></a>
                    </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
