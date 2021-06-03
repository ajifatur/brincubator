
        <nav class="navbar-custom">

                    <ul class="list-inline float-right mb-0">

                        <li class="list-inline-item dropdown notif">
                            <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('templates/pike-admin/assets/images/avatars/admin.png') }}" alt="Profile image" class="avatar-rounded">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Hello, {{ Auth::user()->username }}</small> </h5>
                                </div>

                                <!-- item-->
                                <a href="#" class="dropdown-item notify-item" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                                    <i class="fa fa-power-off"></i> <span>Logout</span>
                                </a>
                                <form id="logout" method="post" action="/logout" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left">
								<i class="fa fa-fw fa-bars"></i>
                            </button>
                        </li>                        
                    </ul>

        </nav>