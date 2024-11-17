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
                            <div class="ml-md-auto py-2 py-md-0">
                                <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                                <a href="#" class="btn btn-secondary btn-round">Add Customer</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row mt--2">
                        <div class="col-md-6">
                            <div class="card full-height">
                                <div class="card-body">
                                    <div class="card-title">Overall statistics</div>
                                    <div class="card-category">Daily information about statistics in system</div>
                                    <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                                        <div class="px-2 pb-2 pb-md-0 text-center">
                                            <div id="circles-1"></div>
                                            <h6 class="fw-bold mt-3 mb-0">Pengguna</h6>
                                        </div>
                                        <div class="px-2 pb-2 pb-md-0 text-center">
                                            <div id="circles-2"></div>
                                            <h6 class="fw-bold mt-3 mb-0">Open Trip</h6>
                                        </div>
                                        <div class="px-2 pb-2 pb-md-0 text-center">
                                            <div id="circles-3"></div>
                                            <h6 class="fw-bold mt-3 mb-0">Custom Trip</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="card-title">Sales</div>
                                    <div class="card-category">$date ?</div>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <h1>$total_sales ?</h1>
                                    </div>
                                    <div class="pull-in">
                                        <canvas id="dailySalesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body pb-0">
                                    <div class="h1 fw-bold float-right text-warning">+7%</div>
                                    <h2 class="mb-2">213</h2>
                                    <p class="text-muted">Transactions</p>
                                    <div class="pull-in sparkline-fix">
                                        <div id="lineChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="card full-height">
                                <div class="card-header">
                                    <div class="card-title">Feed Activity</div>
                                </div>
                                <div class="card-body">
                                    <ol class="activity-feed">
                                        <li class="feed-item feed-item-secondary">
                                            <time class="date" datetime="9-25">Sep 25</time>
                                            <span class="text">Responded to need <a href="#">"Volunteer opportunity"</a></span>
                                        </li>
                                        <li class="feed-item feed-item-success">
                                            <time class="date" datetime="9-24">Sep 24</time>
                                            <span class="text">Added an interest <a href="#">"Volunteer Activities"</a></span>
                                        </li>
                                        <li class="feed-item feed-item-info">
                                            <time class="date" datetime="9-23">Sep 23</time>
                                            <span class="text">Joined the group <a href="single-group.php">"Boardsmanship Forum"</a></span>
                                        </li>
                                        <li class="feed-item feed-item-warning">
                                            <time class="date" datetime="9-21">Sep 21</time>
                                            <span class="text">Responded to need <a href="#">"In-Kind Opportunity"</a></span>
                                        </li>
                                        <li class="feed-item feed-item-danger">
                                            <time class="date" datetime="9-18">Sep 18</time>
                                            <span class="text">Created need <a href="#">"Volunteer Opportunity"</a></span>
                                        </li>
                                        <li class="feed-item">
                                            <time class="date" datetime="9-17">Sep 17</time>
                                            <span class="text">Attending the event <a href="single-event.php">"Some New Event"</a></span>
                                        </li>
                                    </ol>
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

</html>