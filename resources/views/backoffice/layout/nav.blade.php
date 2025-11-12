<nav class="sb-topnav navbar navbar-expand navbar-light" style="background-color: rgb(39, 133, 76);">
    <h6 class="navbar-brand text-white  ps-3 h1 d-flex align-items-center"><img src="{{ asset(config('public_path.public_path').'utiles/logo.png') }}" class="rounded-circle" width="30px" height="30px">&nbsp;ISPM</h6>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <ul class="navbar-nav d-flex ms-auto me-0 me-md-3 my-2 my-md-0 flex-row">
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarlangueDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-globe fa-fw"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarlangueDropdown">
                <li>
                    <a class="dropdown-item lang-change {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="javascript:void(0);" data-lang="en">
                        <img src="{{ asset(config('public_path.public_path') .'img/icon_en.png') }}" width="22px"/>&nbsp;{{ __('lang.english') }}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item lang-change {{ app()->getLocale() === 'fr' ? 'active' : '' }}" href="javascript:void(0);" data-lang="fr">
                        <img src="{{ asset(config('public_path.public_path') .'img/icon_fr.png') }}" width="22px"/>&nbsp;{{ __('lang.french') }}
                    </a>
                </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li class="d-flex justify-content-center align-items-center">
                   <div class="text-center">
                    <img
                        src="{{ asset(config('public_path.public_path') . 'images/' . (Auth::user()->avatar ? 'users/' . Auth::user()->avatar : 'img.png')) }}"
                        class="rounded-circle"
                        alt="Photo de profil"
                        height="80px"
                        width="80px">
                    <p class="fw-bold pt-2" style="font-size: 13px;">{{ Auth::user()->pseudo }}</p>
                   </div>
                </li>
                <hr class="mt-0">
                <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user text-gray-400 fa-fw mr-2 text-warning"></i>&nbsp;{{ __('default.profile') }}</a></li>
                <li><a class="dropdown-item" href="javascript:void(0)" id="logout-link"><i class="fas fa-sign-out-alt text-gray-400 fa-fw mr-2 text-warning"></i>&nbsp;{{ __('default.logout') }}</a></li>
            </ul>
          </li>
    </ul>
  </nav>
