<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
    <div class="container-fluid">
        <div class="collapse" id="search-nav">
            <form class="navbar-left navbar-form nav-search mr-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-search pr-1">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                    <input type="text" placeholder="Search ..." class="form-control">
                </div>
            </form>
        </div>
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item toggle-nav-search hidden-caret">
                <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                    <i class="fa fa-search"></i>
                </a>
            </li>
            <li class="nav-item dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="examples/assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg"><img src="examples/assets/img/profile.jpg" alt="image profile" class="avatar-img rounded"></div>
                                <div class="u-text">
                                    <h4 id="nameh">Alva</h4>
                                    <p class="text-muted" id="emailh">alva@permatawisata.com</p><a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">My Profile</a>
                            <a class="dropdown-item" href="#">My Balance</a>
                            <a class="dropdown-item" href="#">Inbox</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Account Setting</a>
                            <div class="dropdown-divider"></div>
                            <!-- Menambahkan Form Logout -->
                            <form action="{{ route('admin.logout') }}" method="POST" id="logoutForm">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>

                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<script>
    // Mengambil nama pengguna dari local storage dan menampilkannya di sidebar
    const name = localStorage.getItem('adminName');
    if (name) {
        // Memperbarui konten nama pengguna di sidebar
        const nameElement = document.getElementById('nameh');
        nameElement.childNodes[0].nodeValue = name; // Mengupdate nama pengguna
    }

    const email = localStorage.getItem('adminEmail');
    if (email) {
        // Mengambil email pengguna dan menampilkan email di sidebar
        const emailElement = document.getElementById('emailh');
        emailElement.childNodes[0].nodeValue = email; // Mengupdate email pengguna
    }

    // Fungsi untuk logout
    document.getElementById("logoutForm").addEventListener("submit", function(event) {
        event.preventDefault();
        
        // Menghapus token dari localStorage
        localStorage.removeItem('adminToken');
        localStorage.removeItem('adminName');
        localStorage.removeItem('adminEmail');
        localStorage.removeItem('adminUsername');
        
        // Menjalankan form submit untuk logout
        this.submit();
    });
</script>