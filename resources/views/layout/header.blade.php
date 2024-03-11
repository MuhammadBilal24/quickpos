<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
</head>

<body>
    {{-- This query is get data from customize table to hide or show option --}}
    <?php $customizing = DB::table('customize')->get(); ?>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" href="index.html"><img
                            src="{{ asset('assets/images/logo.png') }}" style="width:200px" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img
                            src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" /></a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav mr-lg-4 w-100">
                    <li class="nav-item nav-search d-none d-lg-block w-100">
                        <div class="input-group">
                            <input id="SearchNow" type="text" class="form-control" placeholder="Search now"
                                autocomplete="off">
                            <button onclick="searchonGoogle()" class="btn btn-danger btn-sm text-light"
                                style="width:80px; margin-right:-11px"><i class="mdi mdi-google"></i></button>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link" href="" data-bs-toggle="dropdown" id="profileDropdown">
                            <?php $data = DB::table('users')->where('id', session('loggedInUser'))->get(); ?>
                            @if ($data[0]->picture)
                                <img src="{{ asset('storage/imgs/' . $data[0]->picture . '') }}" alt="" />
                            @else
                                <img src="{{ asset('storage/imgs/1709199356.png') }}" alt="" />
                            @endif
                            <span class="nav-profile-name"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="mdi mdi-account-card-details text-primary"></i>
                                Profile
                            </a>
                            {{-- <a class="dropdown-item" href="/customize">
                                    <i class="mdi mdi-settings text-primary"></i>
                                    Customization
                                </a> --}}
                            <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php $User_type = DB::table('users')->where('id', session('loggedInUser'))->get(); ?>
            {{-- {{ var_dump($User_type[0]->user_type) }} --}}
            {{-- Mater Admin Menu --}}
            @if ($User_type[0]->user_type == 1)
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">
                                <i class="mdi mdi-home menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                                aria-controls="ui-basic">
                                <i class="mdi mdi-menu menu-icon"></i>
                                <span class="menu-title">Resgistrations</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="/account">Account</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="/account-type">Account Type</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="/city">City</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="/category">Category</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="/products">Product</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/expense">
                                <i class="mdi mdi-coin menu-icon"></i>
                                <span class="menu-title">Expense</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/users">
                                <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                                <span class="menu-title">Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/customize">
                                <i class="mdi mdi-apps menu-icon"></i>
                                <span class="menu-title">Customize</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/trash">
                                <i class="mdi mdi-delete-variant menu-icon" style="color: red"></i>
                                <span class="menu-title">Trash</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                {{-- Manager Menu --}}
            @elseif($User_type[0]->user_type == 2)
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">
                                <i class="mdi mdi-home menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                                aria-controls="ui-basic">
                                <i class="mdi mdi-menu menu-icon"></i>
                                <span class="menu-title">Resgistrations</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="/account">Account</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="/account-type">Account Type</a>
                                    </li>
                                    <li class="nav-item"> <a class="nav-link" href="/city">City</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="/category">Category</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="/products">Product</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/expense">
                                <i class="mdi mdi-coin menu-icon"></i>
                                <span class="menu-title">Expense</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/users">
                                <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                                <span class="menu-title">Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/trash">
                                <i class="mdi mdi-delete-variant menu-icon" style="color: red"></i>
                                <span class="menu-title">Trash</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                {{-- Employee Menu / Neutral --}}
            @else
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        @if ($customizing->where('title', 'Dashboard')->first()?->value === '1')
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboard">
                                    <i class="mdi mdi-home menu-icon"></i>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </li>
                        @endif
                        @if ($customizing->where('title', 'Registration')->first()?->value === '1')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                                aria-controls="ui-basic">
                                <i class="mdi mdi-menu menu-icon"></i>
                                <span class="menu-title">Resgistrations</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    @if ($customizing->where('title', 'Accounts')->first()?->value === '1')
                                    <li class="nav-item"> <a class="nav-link" href="/account">Accounts</a></li>
                                    @endif
                                    @if ($customizing->where('title', 'AccountType')->first()?->value === '1')
                                    <li class="nav-item"> <a class="nav-link" href="/account-type">Account Type</a></li>
                                    @endif
                                    @if ($customizing->where('title', 'City')->first()?->value === '1')
                                    <li class="nav-item"> <a class="nav-link" href="/city">City</a></li>
                                    @endif
                                    @if ($customizing->where('title', 'Category')->first()?->value === '1')
                                    <li class="nav-item"> <a class="nav-link" href="/category">Category</a></li>
                                    @endif
                                    @if ($customizing->where('title', 'Product')->first()?->value === '1')
                                    <li class="nav-item"> <a class="nav-link" href="/products">Product</a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @endif
                        @if ($customizing->where('title', 'Expense')->first()?->value === '1')
                        <li class="nav-item">
                            <a class="nav-link" href="/expense">
                                <i class="mdi mdi-coin menu-icon"></i>
                                <span class="menu-title">Expense</span>
                            </a>
                        </li>
                        @endif
                        @if ($customizing->where('title', 'Users')->first()?->value === '1')
                            <li class="nav-item">
                                <a class="nav-link" href="/users">
                                    <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                                    <span class="menu-title">Users</span>
                                </a>
                            </li>
                        @endif
                        @if ($customizing->where('title', 'Trash')->first()?->value === '1')
                        <li class="nav-item">
                            <a class="nav-link" href="/trash">
                                <i class="mdi mdi-delete-variant menu-icon" style="color: red"></i>
                                <span class="menu-title">Trash</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
            @endif

            {{-- Google Search Bar  --}}
            <script>
                function searchonGoogle() {
                    var searchQuery = document.getElementById('SearchNow').value;
                    var searchURL = 'https://www.google.com/search?q=' + searchQuery;
                    window.open(searchURL, '_blank'); // _self use for same page
                }
            </script>
