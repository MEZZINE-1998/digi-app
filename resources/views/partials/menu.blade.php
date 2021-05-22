
        <nav  class="navbar navbar-expand-lg navbar-light" style="height: 50px;background-color: #f5f3f1">                
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <a style="margin-left: 20px" class="navbar-brand" href="{{ url('/cvs') }}">
                        <img height="40px" src="{{url('Digiwise _ couleur-noir.png')}}">
                    </a>
                </ul>

                

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</b></a>
                        </li>
                    @else
        
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/cvs') }}">{{ __('Engineers') }}</b></a>
                            </li>
                            @if(Auth::user()->post == "Ingenieur")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('cvs/'.Auth::user()->id) }}">{{ __('Profile') }}</b></a>
                            </li>
                            @endif
                            @if(Auth::user()->post == "Entreprise")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('user/'.Auth::user()->id) }}">{{ __('Profile') }}</b></a>
                            </li>
                            @endif
                            @if(Auth::user()->post == "admin")
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('partners/') }}">{{ __('Partners') }}</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/'.Auth::user()->id) }}">{{ __('Profile') }}</b></a>
                            </li>
                            @endif
                            <li  class="nav-item">
                            
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <span>Logout</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{csrf_field()}}
                                </form>
                            </li>
                    @endguest
                </ul>
            </div>
        </nav>


        <style type="text/css">
            .notification {
              position: relative;
            }

            .notification .badge {
              position: absolute;
              top: 5px;
              right: 5px;
              padding: 5px 5px;
              border-radius: 50%;
              background: red;
              font-size: 10px;
              color: white;
            }
        </style>