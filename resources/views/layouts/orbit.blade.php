<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>VitaGuard - Member</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('orbit/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('orbit/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('orbit/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('orbit/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('orbit/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('orbit/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('orbit/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('orbit/css/main.css') }}" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- =======================================================
  * Template Name: Orbit
  * Template URL: https://bootstrapmade.com/orbit-bootstrap-template/
  * Updated: Jan 13 2026 with Bootstrap v5.3.8
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">

    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('member.dashboard') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.webp" alt=""> -->
        <h1 class="sitename">VitaGuard</h1><span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('member.dashboard') }}" class="active">Dashboard</a></li>
          <li><a href="{{ route('member.dashboard') }}#portfolio">Latest Articles</a></li>
          <li><a href="{{ route('member.dashboard') }}#services">Features</a></li>
          <li><a href="{{ route('member.dashboard') }}#testimonials">My Appointments</a></li>
          <form id="logout-form"
            action="{{ route('logout') }}"
            method="POST"
            style="display: none;">
            @csrf
          </form>
          <li>
            <a href="#"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="bi bi-box-arrow-right"></i>
              Logout
            </a>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">

    @yield('content')
    @stack('script')
    @stack('modal')

  </main>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('orbit/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('orbit/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('orbit/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('orbit/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('orbit/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('orbit/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('orbit/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('orbit/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('orbit/js/main.js') }}"></script>

</body>

</html>
