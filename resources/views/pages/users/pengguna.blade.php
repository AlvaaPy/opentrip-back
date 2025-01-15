<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Permata Wisata - Dashboard Admin</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{asset('examples/assets/img/permata-wisata.png')}}" />

    <!-- Fonts and icons -->
    <script src="{{asset('examples/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ["{{asset('examples/assets/css/fonts.min.css')}}"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset ('examples/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset ('examples/assets/css/atlantis.min.css')}}">
    <link rel="stylesheet" href="{{asset ('examples/assets/css/demo.css')}}">
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="index.html" class="logo" style="text-decoration: none;">
                    <img src="{{asset('examples/assets/img/permata-wisata.png')}}" alt="navbar brand" class="navbar-brand" style="width: 50px; height: auto; display: inline-block;">
                </a>

                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            @include ('pages.Trip.headnav')
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        @include('pages.users.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="content">
                <div class="panel-header bg-primary-gradient">
                    <div class="page-inner py-5">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                                <h5 class="text-white op-7 mb-2">Permata Wisata - Dashboard Admin</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row mt--2">
                        <div class="col-md-12">
                            <div class="card full-height">
                                <div class="card-body">
                                    <div class="card-title fw-bold">Package Trip</div>
                                    <div class="card-category">Data management for Package Trips</div>
                                    <div class="table-responsive">
                                        <table id="package-trip-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Full Name</th>
                                                    <th>username</th>
                                                    <th>email</th>
                                                    <th>no_tlpn</th>
                                                    <th>birth date</th>
                                                    <th>Gender</th>
                                                    <th>Profile Picture</th>
                                                    <th>Kode Otp</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="package-trip-body">
                                                @foreach ($users as $user )
                                                <tr>
                                                    <td>{{$user->userID}}</td>
                                                    <td>{{$user->fullname}}</td>
                                                    <td>{{$user->username}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>{{$user->noTlpn}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($user->birthDate)->toDateString() }}</td>
                                                    <td>{{$user->gender}}</td>
                                                    <td>
                                                        <img src="{{ asset('uploads/profile_pictures/' . $user->profile_picture) }}" alt="{{ $user->username }}" width="50">
                                                    </td>
                                                    <td>{{$user->otp}}</td>
                                                    <td class="text-center">
                                                        <div style="display: flex; gap: 10px;">
                                                            <form action="{{ route('pengguna.edit', $user->userID)}}" method="GET" style="display:inline;">
                                                            @csrf
                                                                <button type="submit" class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('pengguna.delete', $user->userID) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this package trip?')">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @include('pages.Trip.footer')
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="{{asset ('examples/assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{asset ('examples/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset ('examples/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset ('examples/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{asset ('examples/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset ('examples/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>


    <!-- Chart JS -->
    <script src="{{asset ('examples/assets/js/plugin/chart.js/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{asset ('examples/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Chart Circle -->
    <script src="{{asset ('examples/assets/js/plugin/chart-circle/circles.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset ('examples/assets/js/plugin/datatables/datatables.min.js')}}"></script>


    <!-- jQuery Vector Maps -->
    <script src="{{asset ('examples/assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset ('examples/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{asset ('examples/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Atlantis JS -->
    <script src=" {{asset ('examples/assets/js/atlantis.min.js')}}"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{asset ('examples/assets/js/setting-demo.js')}}"></script>
    <script src="{{asset ('examples/assets/js/demo.js')}}"></script>

</body>

</html>i