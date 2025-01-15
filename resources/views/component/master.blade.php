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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('adminToken');

            if (!token) {
                alert('Please login first');
                window.location.href = "{{ route('login') }}";
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
        @include('component.sidebar')
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
                                    <div class="card-title text-center">Overall Statistics</div>
                                    <div class="card-category text-center mb-4">Daily information about statistics in the system</div>
                                    <div class="row g-4 justify-content-center">
                                        <!-- Total Pengguna -->
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                                <div class="stat-icon mb-2">
                                                    <i class="fas fa-users fa-2x text-primary"></i>
                                                </div>
                                                <h6 class="fw-bold">Pengguna</h6>
                                                <a href="{{ route('user.index') }}" class="fw-bold text-primary">
                                                    <h2 class="text-primary fw-bold">{{ $totalUser }}</h2>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Total Trip -->
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                                <div class="stat-icon mb-2">
                                                    <i class="fas fa-map-marked-alt fa-2x text-primary"></i>
                                                </div>
                                                <h6 class="fw-bold">Total Trip</h6>
                                                <a href="{{ route('trip.index') }}" class="fw-bold text-primary">
                                                    <h2 class="text-primary fw-bold">{{ $totalTrip }}</h2>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Open Trip -->
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                                <div class="stat-icon mb-2">
                                                    <i class="fas fa-map fa-2x text-primary"></i>
                                                </div>
                                                <h6 class="fw-bold">Open Trip</h6>
                                                <a href="{{ route('trip.index') }}" class="fw-bold text-primary">
                                                    <h2 class="text-primary fw-bold">{{ $totalOpenTrip }}</h2>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Private Trip -->
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                                <div class="stat-icon mb-2">
                                                    <i class="fas fa-lock fa-2x text-primary"></i>
                                                </div>
                                                <h6 class="fw-bold">Private Trip</h6>
                                                <a href="{{ route('trip.index') }}" class="fw-bold text-primary">
                                                    <h2 class="text-primary fw-bold">{{ $totalPrivateTrip }}</h2>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Request Custom Trip -->
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                                <div class="stat-icon mb-2">
                                                    <i class="fas fa-cogs fa-2x text-primary"></i>
                                                </div>
                                                <h6 class="fw-bold">Request Custom Trip</h6>
                                                <a href="{{ route('custom.index') }}" class="fw-bold text-primary">
                                                    <h2 class="text-primary fw-bold">{{ $totalCustom }}</h2>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Status Custom: Di Terima -->
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                                <div class="stat-icon mb-2">
                                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                                </div>
                                                <h6 class="fw-bold">Status Custom</h6>
                                                <h6 class="fw-bold text-success">Di Terima</h6>
                                                <a href="{{ route('custom.index') }}" class="fw-bold text-success">
                                                    <h2 class="text-success fw-bold">{{ $totalDiterima }}</h2>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Status Custom: Di Tolak -->
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                                <div class="stat-icon mb-2">
                                                    <i class="fas fa-times-circle fa-2x text-danger"></i>
                                                </div>
                                                <h6 class="fw-bold">Status Custom</h6>
                                                <h6 class="fw-bold text-danger">Di Tolak</h6>
                                                <a href="{{ route('custom.index') }}" class="fw-bold text-danger">
                                                    <h2 class="text-danger fw-bold">{{ $totalDitolak }}</h2>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Status Custom: Pending -->
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                                <div class="stat-icon mb-2">
                                                    <i class="fas fa-hourglass-half fa-2x text-warning"></i>
                                                </div>
                                                <h6 class="fw-bold">Status Custom</h6>
                                                <h6 class="fw-bold text-warning">Pending</h6>
                                                <a href="{{ route('custom.index') }}" class="fw-bold text-warning">
                                                    <h2 class="text-warning fw-bold">{{ $totalPanding }}</h2>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
                    <div class="row d-flex justify-content-center">
                        <!-- Card untuk Total Reservasi -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-cart-plus fa-2x text-success"></i> <!-- Ikon belanja -->
                                </div>
                                <h6 class="fw-bold">Total Reservasi (Sementara)</h6>
                                <h2 class="text-success fw-bold">{{ $formattedTotalReservasi }}</h2>
                            </div>
                        </div>

                        <!-- Card untuk Jumlah Reservasi -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-clipboard-list fa-2x text-info"></i> <!-- Ikon reservasi -->
                                </div>
                                <h6 class="fw-bold">Jumlah Reservasi</h6>
                                <h2 class="text-info fw-bold">{{ $reservasiCount }} Reservasi</h2>
                            </div>
                        </div>

                        <!-- Card untuk Total Pembelian -->
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="stat-card shadow-sm text-center p-3 rounded">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-credit-card fa-2x text-warning"></i> <!-- Ikon pembayaran -->
                                </div>
                                <h6 class="fw-bold">Total Pembelian</h6>
                                <h2 class="text-warning fw-bold">Rp 0</h2> <!-- Ganti dengan data yang sesuai -->
                            </div>
                        </div>
                    </div>

                    <!-- Chart (Tetap di bawah) -->
                    <div class="col-12 mt-4">
                        <div class="pull-in">
                            <canvas id="dailySalesChart"></canvas>
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

</html>