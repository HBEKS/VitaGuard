@extends('layouts.orbit')

@section('title', 'Dashboard')
@section('sidebar-dashboard', 'active')

@section('content')

<!-- awal dashboard -->
<section id="hero" class="hero section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                <div class="hero-content">
                    <div class="hero-tag" data-aos="fade-up" data-aos-delay="250">
                    </div>

                    <h1 class="hero-headline" data-aos="fade-up" data-aos-delay="300">Welcome Back, {{ Auth::user()->name }} 👋</h1>

                    <p class="hero-text" data-aos="fade-up" data-aos-delay="350">
                        Your health is our priority. Book appointments with trusted doctors, manage your consultations, and stay informed through health articles.
                    </p>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                <div class="stats-grid">
                    <div class="stat-card stat-card-primary" data-aos="zoom-in" data-aos-delay="350">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-rocket-takeoff"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">17+ </span>
                            <span class="stat-title">Available Services</span>
                        </div>
                    </div>

                    <div class="stat-card" data-aos="zoom-in" data-aos-delay="400">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-heart"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">35+</span>
                            <span class="stat-title">Categories Available</span>
                        </div>
                    </div>

                    <div class="stat-card" data-aos="zoom-in" data-aos-delay="450">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">5+</span>
                            <span class="stat-title"> Experienced Doctors</span>
                        </div>
                    </div>

                    <div class="stat-card stat-card-accent" data-aos="zoom-in" data-aos-delay="500">
                        <div class="stat-icon-wrap">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-value">10+</span>
                            <span class="stat-title">Users Trust VitaGuard</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- akhir dashboard  -->

<!-- start Health article  -->
<section id="portfolio" class="portfolio section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Latest Health Articles</h2>
        <p>Read Our Latest Uploaded Health Articles</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="isotope-layout"
            data-default-filter="*"
            data-layout="fitRows"
            data-sort="original-order">
            <div class="row g-4 isotope-container"
                data-aos="fade-up"
                data-aos-delay="200">
                @forelse($latestArticles as $article)
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item">
                    <div class="project-card">
                        <div class="image-wrapper">
                            @if($article->image_url)
                            <img src="{{ asset('storage/articles/'.$article->image_url) }}"
                                class="img-fluid"
                                alt="{{ $article->title }}"
                                loading="lazy">
                            @else
                            <img src="{{ asset('orbit/img/portfolio/portfolio-1.webp') }}"
                                class="img-fluid"
                                alt="Article"
                                loading="lazy">
                            @endif
                            <div class="hover-overlay">
                                <div class="overlay-actions">
                                    @if($article->image_url)
                                    <a href="{{ asset('storage/articles/'.$article->image_url) }}"
                                        class="glightbox action-btn"
                                        data-gallery="articles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('article.show', ['article' => $article->id]) }}"
                                        class="action-btn">
                                        <i class="bi bi-link-45deg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="project-info">
                            <h3>
                                {{ $article->title }}
                            </h3>
                            <p>
                                {{ \Illuminate\Support\Str::limit(strip_tags($article->content),80) }}
                            </p>
                            <div class="project-meta">
                                <div class="tech-tags">
                                    <span>
                                        {{ $article->author->name ?? 'VitaGuard' }}
                                    </span>
                                    <span>
                                        {{ ceil(str_word_count(strip_tags($article->content))/200) }} min read
                                    </span>
                                </div>
                                <span class="year">
                                    {{ $article->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No articles available.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- end health article -->

<!-- start menu card -->
<section id="services" class="services section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Features</h2>
        <p>Explore VitaGuard's powerful features</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
            <!-- Service Card 1 - List Articles-->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-journal-medical"></i>
                    </div>
                    <h3>Articles</h3>
                    <p>Read our latest health articles and expert insights.</p>
                    <a href="{{ route('article') }}" class="service-link">
                        <span>Discover More</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div><!-- End Service Card -->

            <!-- Service Card 2 - Categories -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h3>Categories</h3>
                    <p>Explore different health categories and find what you're looking for.</p>
                    <a href="{{ route('categories.index') }}" class="service-link">
                        <span>Discover More</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div><!-- End Service Card -->

            <!-- Service Card 3 - Services -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h3>Services</h3>
                    <p>Discover our range of healthcare services designed to meet your needs.</p>
                    <a href="{{ route('services.index') }}" class="service-link">
                        <span>Discover More</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div><!-- End Service Card -->

            <!-- Service Card 4 - Doctors -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-person-vcard"></i>
                    </div>
                    <h3>Doctors</h3>
                    <p>See our expert doctors and their profiles.</p>
                    <a href="{{ route('listDoctor') }}" class="service-link">
                        <span>Discover More</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div><!-- End Service Card -->

            <!-- Service Card 5 - Appointments -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                    <h3>Appointments</h3>
                    <p>See your upcoming and historical appointments and manage them easily.</p>
                    <a href="{{ route('booking.index') }}" class="service-link">
                        <span>Discover More</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div><!-- End Service Card -->

            <!-- Service Card 6 - Profile -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h3>Profile</h3>
                    <p>Manage your personal information and update your profile details.</p>
                    <a href="{{ route('profile') }}" class="service-link">
                        <span>Discover More</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div><!-- End Service Card -->

        </div>

        <!-- Stats Row -->
        <div class="stats-row" data-aos="fade-up" data-aos-delay="400">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">250+</span>
                        <span class="stat-label">Projects Delivered</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Client Satisfaction</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <span class="stat-number">40+</span>
                        <span class="stat-label">Team Experts</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
<!-- end menu card -->

<!-- start active appointment -->
<section id="testimonials" class="testimonials section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>My Appointments</h2>
        <p>See your upcoming and past appointments</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-4" data-aos="fade-right" data-aos-delay="150">
                <div class="testimonials-sidebar">

                    <div class="avatar-stack">
                        @foreach($activeAppointments->take(4) as $appointment)
                        <img src="{{ $appointment->doctor->avatar
                ? asset('storage/'.$appointment->doctor->avatar)
                : asset('orbit/img/person/person-m-3.webp') }}"
                            class="avatar">
                        @endforeach
                        <span class="avatar-count">
                            {{ $activeAppointments->count() }}
                        </span>
                    </div>

                    <div class="sidebar-content">
                        <span class="satisfied-badge">
                            <i class="bi bi-calendar2-check-fill"></i>
                            Active Appointments
                        </span>
                        <h3>Your Upcoming Consultations</h3>
                        <p>
                            You currently have
                            <strong>{{ $activeAppointments->count() }}</strong>
                            active appointment(s).
                        </p>
                        <a href="{{ route('booking.index') }}"
                            class="btn-view-all">
                            View All Appointments
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div><!-- End Left Sidebar -->

            <!-- Right Testimonials Slider -->
            <div class="col-lg-8" data-aos="fade-left" data-aos-delay="200">
                <div class="testimonials-carousel swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 700,
                            "autoplay": {
                                "delay": 5000
                            },
                            "slidesPerView": 1,
                            "spaceBetween": 24,
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            },
                            "breakpoints": {
                                "768": {
                                    "slidesPerView": 2
                                }
                            }
                        }
                    </script>

                    <div class="swiper-wrapper">
                        @forelse($activeAppointments as $appointment)
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <div class="card-top">
                                    <div class="stars">
                                        @if($appointment->status=='pending')
                                        <span class="badge bg-warning">
                                            Pending
                                        </span>

                                        @elseif($appointment->status=='confirmed')
                                        <span class="badge bg-primary">
                                            Confirmed
                                        </span>

                                        @else
                                        <span class="badge bg-success">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                        @endif
                                    </div>
                                    <span class="quote-mark">
                                        <i class="bi bi-calendar-check"></i>
                                    </span>
                                </div>

                                <p class="testimonial-text">
                                    <strong>Service</strong><br>
                                    {{ $appointment->service->service_name }}
                                    <br><br>
                                    <strong>Date</strong><br>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                                    at
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                </p>
                                <div class="author-info">
                                    <img
                                        src="{{ $appointment->doctor->avatar
                    ? asset('storage/'.$appointment->doctor->avatar)
                    : asset('orbit/img/person/person-m-3.webp') }}"
                                        class="author-img">
                                    <div class="author-details">
                                        <h5>
                                            Dr.
                                            {{ $appointment->doctor->name }}
                                        </h5>
                                        <span>
                                            {{ $appointment->doctor->specialization_name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x display-4"></i>
                                    <h5 class="mt-3">
                                        No Active Appointment
                                    </h5>
                                    <p>
                                        You don't have any active appointments.
                                    </p>
                                    <a href="{{ route('booking.index') }}"
                                        class="btn btn-primary">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div><!-- End Right Testimonials Slider -->
        </div>
    </div>
</section>
<!-- end active appointment -->

@endsection