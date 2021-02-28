<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="/assets/icons/sprites/free.svg#cil-menu"></use>
        </svg>
    </button><a class="c-header-brand d-lg-none" href="#">
        <svg width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="/assets/brand/coreui.svg#full"></use>
        </svg></a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="/assets/icons/sprites/free.svg#cil-menu"></use>
        </svg>
    </button>
    <ul class="c-header-nav ml-auto mr-4">
    	@guest
    	<li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>         
        @else
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            	<a class="dropdown-item" href="{{ route('logout') }}"
                	onclick="event.preventDefault();
            	    document.getElementById('logout-form').submit();">
                	{{ __('Logout') }}
            	</a>
            	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            	@csrf
                </form>
                @if (Auth::user()->hasPermissionTo('Administer roles & permissions'))
                <a class="dropdown-item" href="{{ route('users.index') }}">
                    {{ __('Accounts') }}
                </a>
                @endif
        	</div>
        </li>
        @endguest
    </ul>
    <!--div class="c-subheader px-3">
        <!-- Breadcrumb-->
        <!--ol class="breadcrumb border-0 m-0">
            <!--li class="breadcrumb-item active">Dashboard</li-->
            <!-- Breadcrumb Menu-->
        </ol-->
    </div-->
</header>
