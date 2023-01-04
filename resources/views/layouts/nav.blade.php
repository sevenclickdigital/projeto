<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-2">
    <div class="container">
        
        <a class="navbar-brand text-primary font-weight-bold text-uppercase" href="{{ url('/') }}">
            rating_project_public
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Apps <span class="caret"></span>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @can('view-any', App\Models\Billing::class)
                            <a class="dropdown-item" href="{{ route('billings.index') }}">Billings</a>
                            @endcan
                            @can('view-any', App\Models\Birthday::class)
                            <a class="dropdown-item" href="{{ route('birthdays.index') }}">Birthdays</a>
                            @endcan
                            @can('view-any', App\Models\Branch::class)
                            <a class="dropdown-item" href="{{ route('branches.index') }}">Branches</a>
                            @endcan
                            @can('view-any', App\Models\BranchHour::class)
                            <a class="dropdown-item" href="{{ route('branch-hours.index') }}">Branch Hours</a>
                            @endcan
                            @can('view-any', App\Models\CategoryProduct::class)
                            <a class="dropdown-item" href="{{ route('category-products.index') }}">Category Products</a>
                            @endcan
                            @can('view-any', App\Models\Coupon::class)
                            <a class="dropdown-item" href="{{ route('coupons.index') }}">Coupons</a>
                            @endcan
                            @can('view-any', App\Models\HolidayDescription::class)
                            <a class="dropdown-item" href="{{ route('holiday-descriptions.index') }}">Holiday Descriptions</a>
                            @endcan
                            @can('view-any', App\Models\Holiday::class)
                            <a class="dropdown-item" href="{{ route('holidays.index') }}">Holidays</a>
                            @endcan
                            @can('view-any', App\Models\Lead::class)
                            <a class="dropdown-item" href="{{ route('leads.index') }}">Leads</a>
                            @endcan
                            @can('view-any', App\Models\Message::class)
                            <a class="dropdown-item" href="{{ route('messages.index') }}">Messages</a>
                            @endcan
                            @can('view-any', App\Models\Newsletter::class)
                            <a class="dropdown-item" href="{{ route('newsletters.index') }}">Newsletters</a>
                            @endcan
                            @can('view-any', App\Models\Product::class)
                            <a class="dropdown-item" href="{{ route('products.index') }}">Products</a>
                            @endcan
                            @can('view-any', App\Models\Qrbilder::class)
                            <a class="dropdown-item" href="{{ route('qrbilders.index') }}">Qrbilders</a>
                            @endcan
                            @can('view-any', App\Models\Rating::class)
                            <a class="dropdown-item" href="{{ route('ratings.index') }}">Ratings</a>
                            @endcan
                            @can('view-any', App\Models\User::class)
                            <a class="dropdown-item" href="{{ route('users.index') }}">Users</a>
                            @endcan
                            @can('view-any', App\Models\Tenant::class)
                            <a class="dropdown-item" href="{{ route('tenants.index') }}">Tenants</a>
                            @endcan
                            @can('view-any', App\Models\ScratchCardPlayer::class)
                            <a class="dropdown-item" href="{{ route('scratch-card-players.index') }}">Scratch Card Players</a>
                            @endcan
                            @can('view-any', App\Models\ScratchCardAnswer::class)
                            <a class="dropdown-item" href="{{ route('scratch-card-answers.index') }}">Scratch Card Answers</a>
                            @endcan
                            @can('view-any', App\Models\SocialLead::class)
                            <a class="dropdown-item" href="{{ route('social-leads.index') }}">Social Leads</a>
                            @endcan
                            @can('view-any', App\Models\ScratchCardConfig::class)
                            <a class="dropdown-item" href="{{ route('scratch-card-configs.index') }}">Scratch Card Configs</a>
                            @endcan
                            @can('view-any', App\Models\ScratchCard::class)
                            <a class="dropdown-item" href="{{ route('scratch-cards.index') }}">Scratch Cards</a>
                            @endcan
                            @can('view-any', App\Models\RatingGoogleBusiness::class)
                            <a class="dropdown-item" href="{{ route('rating-google-businesses.index') }}">Rating Google Businesses</a>
                            @endcan
                        </div>

                    </li>
                    @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) || 
                        Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Access Management <span class="caret"></span>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @can('view-any', Spatie\Permission\Models\Role::class)
                            <a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
                            @endcan
                    
                            @can('view-any', Spatie\Permission\Models\Permission::class)
                            <a class="dropdown-item" href="{{ route('permissions.index') }}">Permissions</a>
                            @endcan
                        </div>
                    </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>