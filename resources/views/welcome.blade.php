<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTU FabLab Digital Service Hub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 
                        primary: "#001740", 
                        "primary-light": "#F4D462",
                        secondary: "#0F2A71",
                        "secondary-yellow": "#F5C400",
                        "secondary-light": "#FFFDF0"
                    },
                    borderRadius: {
                        none: "0px",
                        sm: "4px",
                        DEFAULT: "8px",
                        md: "12px",
                        lg: "16px",
                        xl: "20px",
                        "2xl": "24px",
                        "3xl": "32px",
                        full: "9999px",
                        button: "8px",
                    },
                },
            },
        };
    </script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">

    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--secondary-light);
            background-color: var(--primary-dark);
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(15, 42, 113, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(15, 42, 113, 0.15) 0%, transparent 50%),
                linear-gradient(135deg, rgba(0, 23, 64, 0.9) 0%, rgba(0, 23, 64, 1) 100%);
            background-attachment: fixed;
        }
        .hero-section {
            background-image: url('{{ asset('images/fablab.jpg') }}');
            background-size: cover;
            background-position: center right;
            position: relative;
        }
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 23, 64, 0.8) 0%, rgba(0, 23, 64, 0.4) 100%);
            z-index: 0;
        }
        .hero-section > div {
            position: relative;
            z-index: 1;
        }
        .tech-pattern {
            position: absolute;
            background-image: 
                linear-gradient(to right, rgba(244, 212, 98, 0.1) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(244, 212, 98, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            opacity: 0.3;
        }
        .section-divider {
            height: 5px;
            background: linear-gradient(90deg, var(--primary-light), var(--secondary-yellow), var(--primary-light));
        }
        input:focus, button:focus {
            outline: none;
        }
        select {
            appearance: none;
        }
        .service-card {
            transition: all 0.3s ease;
            border-bottom: 4px solid transparent;
            position: relative;
            overflow: hidden;
        }
        .service-card::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 50px 50px 0;
            border-color: transparent var(--primary-light) transparent transparent;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .service-card:hover::after {
            opacity: 1;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            border-bottom: 4px solid var(--primary-light);
        }
        .card-hover-effect {
            transition: all 0.3s ease;
        }
        .card-hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }
        .tech-btn {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .tech-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s ease;
            z-index: -1;
        }
        .tech-btn:hover::before {
            left: 100%;
        }
        .section-title {
            position: relative;
            display: inline-block;
        }
        .section-title::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--primary-light);
        }
        :root {
            --primary-dark: #001740;
            --primary-light: #F4D462;
            --secondary-accent: #0F2A71;
            --secondary-yellow: #F5C400;
            --secondary-light: #FFFDF0;
        }
    </style>
</head>
<body class="bg-primary">
    <!-- Header -->
    <header class="bg-secondary-light shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <a href="/" class="text-3xl font-['Pacifico'] text-primary mr-10">CTU FabLab</a>
                <nav class="hidden md:flex space-x-8">
                    <a href="#services" class="text-primary hover:text-secondary font-medium">Services</a>
                    <a href="#about" class="text-primary hover:text-secondary font-medium">About</a>
                    <a href="#equipment" class="text-primary hover:text-secondary font-medium">Equipment</a>
                    <a href="#gallery" class="text-primary hover:text-secondary font-medium">Gallery</a>
                    <a href="#faq" class="text-primary hover:text-secondary font-medium">FAQ</a>
                    <a href="#contact" class="text-primary hover:text-secondary font-medium">Contact</a>
                </nav>
            </div>
            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline-block">
                            @csrf
                            <button type="submit" class="text-primary hover:text-secondary font-medium">Log Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-primary hover:text-secondary font-medium">Log In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-primary text-secondary-light px-4 py-2 !rounded-button font-medium hover:bg-secondary transition whitespace-nowrap">Register</a>
                        @endif
                    @endauth
                @endif
                <button class="md:hidden w-10 h-10 flex items-center justify-center text-primary">
                    <i class="ri-menu-line ri-lg"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section min-h-[600px] flex items-center">
        <div class="container mx-auto px-4 w-full">
            <div class="max-w-2xl bg-secondary-light/90 backdrop-blur-sm p-10 rounded-lg relative overflow-hidden">
                <div class="tech-pattern"></div>
                <div class="relative z-10">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-primary">
                        Digital Fabrication <br /><span class="text-secondary">Made Accessible</span>
                    </h1>
                    <p class="text-lg text-primary mb-8">
                        CTU FabLab offers cutting-edge fabrication services for students,
                        faculty, and the community. From 3D printing to laser cutting, bring
                        your ideas to life with our state-of-the-art equipment.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('service-catalog') }}" class="bg-primary text-secondary-light px-6 py-3 !rounded-button font-medium hover:bg-secondary transition whitespace-nowrap text-center tech-btn">Explore Services</a>
                        <a href="#contact" class="bg-secondary-light text-primary border border-primary px-6 py-3 !rounded-button font-medium hover:bg-primary-light hover:text-primary transition whitespace-nowrap text-center tech-btn">Get Started</a>
                    </div>
                </div>
                <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary-light/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-secondary-yellow/20 rounded-full blur-3xl"></div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-secondary-light relative">
        <div class="tech-pattern"></div>
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-primary section-title">Our Services</h2>
            <p class="text-lg text-primary text-center mb-12 max-w-3xl mx-auto">
                Explore our range of digital fabrication services designed to bring
                your ideas to life with precision and quality.
            </p>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- 3D Printing -->
                <div class="service-card bg-secondary-light rounded-lg shadow-md overflow-hidden transition-all duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="https://readdy.ai/api/search-image?query=modern%25203D%2520printer%2520in%2520action%2520creating%2520a%2520detailed%2520prototype%2520with%2520vibrant%2520filament.%2520The%2520machine%2520is%2520shown%2520in%2520a%2520clean%2520workspace%2520with%2520soft%2520lighting%2520highlighting%2520the%2520printing%2520process.%2520The%2520image%2520has%2520a%2520professional%2520technical%2520feel%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=2&orientation=landscape" alt="3D Printing Service" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-primary">3D Printing</h3>
                        <p class="text-primary mb-4">
                            Transform digital designs into physical objects with our
                            high-resolution 3D printing services using various materials.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="text-sm text-primary/70">Starting at</span>
                                <p class="text-secondary font-semibold">₱150/hour</p>
                            </div>
                        </div>
                        <a href="{{ route('service-catalog') }}" class="block bg-primary-light text-primary font-bold px-4 py-2 !rounded-button hover:bg-secondary-yellow hover:text-primary transition whitespace-nowrap text-center border-2 border-primary tech-btn">Request</a>
                    </div>
                </div>

                <!-- Laser Cutting -->
                <div class="service-card bg-secondary-light rounded-lg shadow-md overflow-hidden transition-all duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520laser%2520cutting%2520machine%2520precisely%2520cutting%2520a%2520pattern%2520into%2520a%2520sheet%2520of%2520material.%2520The%2520laser%2520beam%2520is%2520visible%2520with%2520a%2520slight%2520glow%2520as%2520it%2520works.%2520The%2520machine%2520is%2520in%2520a%2520clean%2520workspace%2520with%2520soft%2520lighting%2520and%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=3&orientation=landscape" alt="Laser Cutting Service" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-primary">Laser Cutting</h3>
                        <p class="text-primary mb-4">
                            Precision cutting and engraving on various materials including
                            wood, acrylic, fabric, and paper.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="text-sm text-primary/70">Starting at</span>
                                <p class="text-secondary font-semibold">₱200/hour</p>
                            </div>
                        </div>
                        <a href="{{ route('service-catalog') }}" class="block bg-secondary text-secondary-light font-bold px-4 py-2 !rounded-button hover:bg-primary transition whitespace-nowrap text-center border-2 border-secondary tech-btn">Request</a>
                    </div>
                </div>

                <!-- Woodwork -->
                <div class="service-card bg-secondary-light rounded-lg shadow-md overflow-hidden transition-all duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520woodworking%2520station%2520with%2520CNC%2520router%2520machine%2520carving%2520a%2520detailed%2520pattern%2520into%2520a%2520wooden%2520panel.%2520The%2520workspace%2520is%2520clean%2520with%2520wood%2520shavings%2520visible%2520around%2520the%2520project.%2520The%2520image%2520has%2520warm%2520tones%2520highlighting%2520the%2520natural%2520wood%2520material%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=4&orientation=landscape" alt="Woodwork Service" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-primary">Woodwork</h3>
                        <p class="text-primary mb-4">
                            Custom woodworking services including CNC routing, carving, and
                            furniture prototyping.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="text-sm text-primary/70">Starting at</span>
                                <p class="text-secondary font-semibold">₱250/hour</p>
                            </div>
                        </div>
                        <a href="{{ route('service-catalog') }}" class="block bg-primary-light text-primary font-bold px-4 py-2 !rounded-button hover:bg-secondary-yellow hover:text-primary transition whitespace-nowrap text-center border-2 border-primary tech-btn">Request</a>
                    </div>
                </div>

                <!-- Embroidery -->
                <div class="service-card bg-secondary-light rounded-lg shadow-md overflow-hidden transition-all duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="https://readdy.ai/api/search-image?query=modern%2520digital%2520embroidery%2520machine%2520stitching%2520a%2520colorful%2520design%2520onto%2520fabric.%2520The%2520machine%2520is%2520shown%2520mid-process%2520with%2520thread%2520spools%2520visible%2520and%2520a%2520partially%2520completed%2520design.%2520The%2520workspace%2520is%2520clean%2520and%2520well-lit%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=5&orientation=landscape" alt="Embroidery Service" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-primary">Embroidery</h3>
                        <p class="text-primary mb-4">
                            Digital embroidery services for custom designs on clothing,
                            bags, patches, and other textile items.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="text-sm text-primary/70">Starting at</span>
                                <p class="text-secondary font-semibold">₱180/hour</p>
                            </div>
                        </div>
                        <a href="{{ route('service-catalog') }}" class="block bg-secondary-yellow text-primary font-bold px-4 py-2 !rounded-button hover:bg-primary-light hover:text-primary transition whitespace-nowrap text-center border-2 border-primary tech-btn">Request</a>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('service-catalog') }}" class="inline-flex items-center text-secondary font-medium hover:text-primary transition">
                    View complete service catalog
                    <i class="ri-arrow-right-line ri-sm ml-1"></i>
                </a>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- How It Works -->
    <section class="py-16 bg-primary-light/20 relative">
        <div class="tech-pattern"></div>
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-primary section-title">How It Works</h2>
            <p class="text-lg text-primary text-center mb-12 max-w-3xl mx-auto">
                Our streamlined process makes it easy to bring your ideas to life.
            </p>

            <div class="grid md:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mb-4 mx-auto relative">
                        <i class="ri-user-add-line ri-xl text-primary"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-secondary-light font-bold">
                            1
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-primary">Register</h3>
                    <p class="text-primary">
                        Create an account based on your user type (student, faculty, or
                        external).
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mb-4 mx-auto relative">
                        <i class="ri-upload-cloud-line ri-xl text-primary"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-secondary rounded-full flex items-center justify-center text-secondary-light font-bold">
                            2
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-primary">Upload Files</h3>
                    <p class="text-primary">
                        Submit your design files and specify your service requirements.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mb-4 mx-auto relative">
                        <i class="ri-money-dollar-circle-line ri-xl text-primary"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-secondary-yellow rounded-full flex items-center justify-center text-primary font-bold">
                            3
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-primary">Payment</h3>
                    <p class="text-primary">
                        Receive a quote and complete payment through our secure system.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center mb-4 mx-auto relative">
                        <i class="ri-truck-line ri-xl text-primary"></i>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary rounded-full flex items-center justify-center text-secondary-light font-bold">
                            4
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-primary">Delivery</h3>
                    <p class="text-primary">
                        Track your order and receive notification when it's ready for
                        pickup.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- About Section -->
    <section id="about" class="py-16 bg-secondary-light relative">
        <div class="tech-pattern"></div>
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-8 text-primary section-title">About CTU FabLab</h2>
                    <p class="text-primary mb-4">
                        The CTU FabLab Digital Service Hub is a state-of-the-art
                        fabrication laboratory at Cebu Technological University Danao
                        Campus. We provide access to advanced digital fabrication tools
                        and technologies to students, faculty, and the broader community.
                    </p>
                    <p class="text-primary mb-6">
                        Our mission is to democratize access to digital fabrication
                        technologies, fostering innovation, creativity, and
                        entrepreneurship in the region.
                    </p>
                </div>
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('images/Fablab logo.jpg') }}" alt="CTU FabLab Logo" class="max-w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Equipment Showcase -->
    <section id="equipment" class="py-16 bg-primary-light/20 relative">
        <div class="tech-pattern"></div>
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-primary section-title">Our Equipment</h2>
            <p class="text-lg text-primary text-center mb-12 max-w-3xl mx-auto">
                Explore our cutting-edge fabrication equipment available for your
                projects.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Equipment 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-primary-light">
                    <div class="h-56 overflow-hidden">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520Ultimaker%2520S5%25203D%2520printer%2520in%2520a%2520clean%2520laboratory%2520environment%252C%2520shown%2520from%2520a%2520slight%2520angle%2520to%2520display%2520its%2520features.%2520The%2520machine%2520has%2520a%2520sleek%2520design%2520with%2520visible%2520printing%2520components%2520and%2520a%2520digital%2520display.%2520The%2520background%2520is%2520simple%2520and%2520clean.&width=500&height=400&seq=7&orientation=landscape" alt="Ultimaker S5 3D Printer" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-primary">Ultimaker S5 3D Printer</h3>
                        <p class="text-primary mb-4">
                            Professional dual-extrusion 3D printer with a large build volume
                            and exceptional print quality.
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">330 x 240 x 300 mm build volume</span>
                            </div>
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">Dual extrusion capability</span>
                            </div>
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">20-micron resolution</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipment 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-primary-light">
                    <div class="h-56 overflow-hidden">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520Epilog%2520Fusion%2520Pro%252032%2520laser%2520cutter%2520in%2520a%2520clean%2520laboratory%2520environment%2520shown%2520from%2520a%2520slight%2520angle%2520to%2520display%2520its%2520features.%2520The%2520machine%2520has%2520a%2520large%2520cutting%2520bed%2520with%2520the%2520top%2520open%2520to%2520show%2520the%2520interior.%2520The%2520background%2520is%2520simple%2520and%2520clean.&width=500&height=400&seq=8&orientation=landscape" alt="Epilog Fusion Pro 32 Laser Cutter" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-primary">Epilog Fusion Pro 32 Laser Cutter</h3>
                        <p class="text-primary mb-4">
                            High-precision laser cutter and engraver for a wide range of
                            materials with advanced features.
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">32" x 20" work area</span>
                            </div>
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">80-watt CO₂ laser tube</span>
                            </div>
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">Camera positioning system</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipment 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-primary-light">
                    <div class="h-56 overflow-hidden">
                        <img src="https://readdy.ai/api/search-image?query=professional%2520Shopbot%2520PRSalpha%2520CNC%2520router%2520in%2520a%2520clean%2520workshop%2520environment%2520shown%2520from%2520a%2520slight%2520angle%2520to%2520display%2520its%2520large%2520cutting%2520bed%2520and%2520gantry%2520system.%2520The%2520machine%2520is%2520robust%2520with%2520visible%2520mechanical%2520components.%2520The%2520background%2520is%2520simple%2520and%2520clean.&width=500&height=400&seq=9&orientation=landscape" alt="Shopbot PRSalpha CNC Router" class="w-full h-full object-cover object-top">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-primary">Shopbot PRSalpha CNC Router</h3>
                        <p class="text-primary mb-4">
                            Industrial-grade CNC router for precision cutting, carving, and
                            machining of wood, plastic, and soft metals.
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">4' x 8' cutting area</span>
                            </div>
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">7.5 HP spindle</span>
                            </div>
                            <div class="flex items-center">
                                <i class="ri-check-line ri-sm text-secondary mr-2"></i>
                                <span class="text-primary">Vacuum hold-down system</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="#" class="inline-flex items-center text-secondary font-medium hover:text-primary transition">
                    View all equipment specifications
                    <i class="ri-arrow-right-line ri-sm ml-1"></i>
                </a>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Project Gallery -->
    <section id="gallery" class="py-16 bg-secondary-light relative">
        <div class="tech-pattern"></div>
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-primary section-title">Project Gallery</h2>
            <p class="text-lg text-primary text-center mb-12 max-w-3xl mx-auto">
                Explore some of the amazing projects created at our FabLab.
            </p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="grid gap-4">
                    <div class="overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('images/p19.jpg') }}" alt="Project 19" class="max-w-full h-auto">
                    </div>
                    <div class="overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('images/p1.jpg') }}" alt="Project 1" class="max-w-full h-auto">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div class="overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('images/p5.jpg') }}" alt="Project 5" class="max-w-full h-auto">
                    </div>
                    <div class="overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('images/p8.jpg') }}" alt="Project 8" class="max-w-full h-auto">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div class="overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('images/p27.jpg') }}" alt="Project 27" class="max-w-full h-auto">
                    </div>
                    <div class="overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('images/p11.jpg') }}" alt="Project 11" class="max-w-full h-auto">
                    </div>
                </div>
                <div class="grid gap-4">
                    <div class="overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('images/p7.jpg') }}" alt="Project 7" class="max-w-full h-auto">
                    </div>
                    <div class="overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('images/p10.jpg') }}" alt="Project 10" class="max-w-full h-auto">
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="#" class="bg-primary text-white px-6 py-3 !rounded-button font-medium hover:bg-primary/90 transition whitespace-nowrap inline-block">View Full Gallery</a>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- FAQ Section -->
    <section id="faq" class="py-16 bg-primary-light/20 relative">
        <div class="tech-pattern"></div>
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-primary section-title">Frequently Asked Questions</h2>
            <p class="text-lg text-primary text-center mb-12 max-w-3xl mx-auto">
                Find answers to common questions about our services and processes.
            </p>

            <div class="max-w-3xl mx-auto space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button class="w-full px-6 py-4 text-left font-semibold flex justify-between items-center focus:outline-none faq-toggle">
                        <span>How do I place an order for 3D printing?</span>
                        <i class="ri-add-line ri-lg text-primary"></i>
                    </button>
                    <div class="px-6 py-4 bg-gray-50 faq-content hidden">
                        <p class="text-gray-600">
                            To place a 3D printing order, first register or log in to your
                            account. Navigate to the Services section, select 3D Printing,
                            and follow the prompts to upload your design files (STL, OBJ,
                            etc.). You'll be able to specify material, color, and other
                            parameters before submitting your order for a quote.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button class="w-full px-6 py-4 text-left font-semibold flex justify-between items-center focus:outline-none faq-toggle">
                        <span>What file formats do you accept?</span>
                        <i class="ri-add-line ri-lg text-primary"></i>
                    </button>
                    <div class="px-6 py-4 bg-gray-50 faq-content hidden">
                        <p class="text-gray-600">
                            We accept a variety of file formats depending on the service:
                        </p>
                        <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-600">
                            <li>3D Printing: STL, OBJ, 3MF, STEP</li>
                            <li>Laser Cutting: AI, SVG, DXF, PDF</li>
                            <li>CNC Routing: DXF, SVG, STEP, STL</li>
                            <li>Embroidery: PES, DST, EXP, JEF</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button class="w-full px-6 py-4 text-left font-semibold flex justify-between items-center focus:outline-none faq-toggle">
                        <span>How are prices calculated for services?</span>
                        <i class="ri-add-line ri-lg text-primary"></i>
                    </button>
                    <div class="px-6 py-4 bg-gray-50 faq-content hidden">
                        <p class="text-gray-600">
                            Pricing is calculated based on several factors:
                        </p>
                        <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-600">
                            <li>3D Printing: Material volume, print time, and material type</li>
                            <li>Laser Cutting: Machine time, material cost, and complexity</li>
                            <li>CNC Routing: Machine time, material cost, and setup requirements</li>
                            <li>Embroidery: Stitch count, thread changes, and fabric type</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button class="w-full px-6 py-4 text-left font-semibold flex justify-between items-center focus:outline-none faq-toggle">
                        <span>What is the typical turnaround time?</span>
                        <i class="ri-add-line ri-lg text-primary"></i>
                    </button>
                    <div class="px-6 py-4 bg-gray-50 faq-content hidden">
                        <p class="text-gray-600">
                            Turnaround times vary based on service type, current workload,
                            and project complexity:
                        </p>
                        <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-600">
                            <li>Small 3D prints: 1-3 business days</li>
                            <li>Laser cutting jobs: 1-2 business days</li>
                            <li>CNC routing projects: 2-5 business days</li>
                            <li>Embroidery work: 1-3 business days</li>
                        </ul>
                        <p class="mt-2 text-gray-600">
                            Rush services are available for an additional fee, subject to
                            equipment availability.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <button class="w-full px-6 py-4 text-left font-semibold flex justify-between items-center focus:outline-none faq-toggle">
                        <span>Do you offer design assistance?</span>
                        <i class="ri-add-line ri-lg text-primary"></i>
                    </button>
                    <div class="px-6 py-4 bg-gray-50 faq-content hidden">
                        <p class="text-gray-600">
                            Yes, we offer design assistance services at an hourly rate. Our
                            staff can help with:
                        </p>
                        <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-600">
                            <li>Converting 2D designs to 3D models</li>
                            <li>Optimizing designs for fabrication</li>
                            <li>Troubleshooting design issues</li>
                            <li>Basic CAD modeling assistance</li>
                        </ul>
                        <p class="mt-2 text-gray-600">
                            Design assistance can be requested during the order process or
                            by contacting our staff directly.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="#" class="inline-flex items-center text-primary font-medium hover:text-primary/80">
                    View all FAQs
                    <i class="ri-arrow-right-line ri-sm ml-1"></i>
                </a>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Contact & Location -->
    <section id="contact" class="py-16 bg-secondary-light relative">
        <div class="tech-pattern"></div>
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-primary section-title">Contact Us</h2>
            <p class="text-lg text-primary text-center mb-12 max-w-3xl mx-auto">
                Have questions or need assistance? Reach out to our team.
            </p>

            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <div class="bg-gray-50 rounded-lg p-8 shadow-sm h-full">
                        <h3 class="text-2xl font-semibold mb-6">Get in Touch</h3>

                        <form class="space-y-6">
                            <div>
                                <label for="name" class="block text-gray-700 mb-2">Full Name</label>
                                <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded focus:border-primary focus:ring-1 focus:ring-primary">
                            </div>
                            <div>
                                <label for="email" class="block text-gray-700 mb-2">Email Address</label>
                                <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded focus:border-primary focus:ring-1 focus:ring-primary">
                            </div>
                            <div>
                                <label for="subject" class="block text-gray-700 mb-2">Subject</label>
                                <input type="text" id="subject" class="w-full px-4 py-2 border border-gray-300 rounded focus:border-primary focus:ring-1 focus:ring-primary">
                            </div>
                            <div>
                                <label for="message" class="block text-gray-700 mb-2">Message</label>
                                <textarea id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded focus:border-primary focus:ring-1 focus:ring-primary"></textarea>
                            </div>
                            <button type="submit" class="bg-primary text-white px-6 py-3 !rounded-button font-medium hover:bg-primary/90 transition whitespace-nowrap">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>

                <div>
                    <div class="bg-gray-50 rounded-lg p-8 shadow-sm mb-8">
                        <h3 class="text-2xl font-semibold mb-6">Location & Hours</h3>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center text-primary mr-4">
                                    <i class="ri-map-pin-line ri-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Address</h4>
                                    <p class="text-gray-600">
                                        CTU FabLab, Cebu Technological University<br>Danao
                                        Campus, Sabang, Danao City<br>Cebu, Philippines 6004
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center text-primary mr-4">
                                    <i class="ri-time-line ri-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Operating Hours</h4>
                                    <p class="text-gray-600">
                                        Monday - Friday: 8:00 AM - 5:00 PM<br>Saturday: 9:00 AM
                                        - 12:00 PM<br>Sunday: Closed
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center text-primary mr-4">
                                    <i class="ri-phone-line ri-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium">Contact</h4>
                                    <p class="text-gray-600">
                                        Phone: (032) 123-4567<br>Email: fablab@ctu.edu.ph
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm h-[300px]">
                        <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://public.readdy.ai/gen_page/map_placeholder_1280x720.png');"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Newsletter -->
    <section class="py-16 bg-primary-light/20 relative">
        <div class="tech-pattern"></div>
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-8 text-primary section-title">Stay Updated</h2>
                <p class="text-lg text-primary mb-8">
                    Subscribe to our newsletter for the latest updates on services,
                    workshops, and special offers.
                </p>

                <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                    <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary">
                    <button type="submit" class="bg-primary text-white px-6 py-3 !rounded-button font-medium hover:bg-primary/90 transition whitespace-nowrap">
                        Subscribe
                    </button>
                </form>

                <p class="text-sm text-gray-500 mt-4">
                    We respect your privacy. Unsubscribe at any time.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-secondary-light pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <a href="/" class="text-3xl font-['Pacifico'] text-primary-light mb-4 inline-block">CTU FabLab</a>
                    <p class="text-secondary-light/80 mb-6">
                        Empowering innovation through digital fabrication technologies at
                        Cebu Technological University.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center hover:bg-primary-light hover:text-primary transition">
                            <i class="ri-facebook-fill"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center hover:bg-primary-light hover:text-primary transition">
                            <i class="ri-twitter-fill"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center hover:bg-primary-light hover:text-primary transition">
                            <i class="ri-instagram-line"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center hover:bg-primary-light hover:text-primary transition">
                            <i class="ri-youtube-fill"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4 text-primary-light">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-secondary-light/80 hover:text-primary-light transition">Home</a></li>
                        <li><a href="#services" class="text-secondary-light/80 hover:text-primary-light transition">Services</a></li>
                        <li><a href="#about" class="text-secondary-light/80 hover:text-primary-light transition">About Us</a></li>
                        <li><a href="#equipment" class="text-secondary-light/80 hover:text-primary-light transition">Equipment</a></li>
                        <li><a href="#gallery" class="text-secondary-light/80 hover:text-primary-light transition">Project Gallery</a></li>
                        <li><a href="#faq" class="text-secondary-light/80 hover:text-primary-light transition">FAQs</a></li>
                        <li><a href="#contact" class="text-secondary-light/80 hover:text-primary-light transition">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4 text-primary-light">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-secondary-light/80 hover:text-primary-light transition">3D Printing</a></li>
                        <li><a href="#" class="text-secondary-light/80 hover:text-primary-light transition">Laser Cutting</a></li>
                        <li><a href="#" class="text-secondary-light/80 hover:text-primary-light transition">CNC Routing</a></li>
                        <li><a href="#" class="text-secondary-light/80 hover:text-primary-light transition">Embroidery</a></li>
                        <li><a href="#" class="text-secondary-light/80 hover:text-primary-light transition">Design Assistance</a></li>
                        <li><a href="#" class="text-secondary-light/80 hover:text-primary-light transition">Workshops & Training</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4 text-primary-light">Contact Information</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <div class="w-6 h-6 flex items-center justify-center text-primary-light mr-3">
                                <i class="ri-map-pin-line"></i>
                            </div>
                            <span class="text-secondary-light/80">CTU Danao Campus, Sabang, Danao City, Cebu, Philippines 6004</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 flex items-center justify-center text-primary-light mr-3">
                                <i class="ri-phone-line"></i>
                            </div>
                            <span class="text-secondary-light/80">(032) 123-4567</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 flex items-center justify-center text-primary-light mr-3">
                                <i class="ri-mail-line"></i>
                            </div>
                            <span class="text-secondary-light/80">fablab@ctu.edu.ph</span>
                        </li>
                        <li class="flex items-start">
                            <div class="w-6 h-6 flex items-center justify-center text-primary-light mr-3">
                                <i class="ri-time-line"></i>
                            </div>
                            <span class="text-secondary-light/80">Mon-Fri: 8AM-5PM<br>Sat: 9AM-12PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-secondary/30">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-secondary-light/60 text-sm mb-4 md:mb-0">
                        © 2025 CTU FabLab Digital Service Hub. All rights reserved.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-secondary-light/60 text-sm hover:text-primary-light transition">Privacy Policy</a>
                        <a href="#" class="text-secondary-light/60 text-sm hover:text-primary-light transition">Terms of Service</a>
                        <a href="#" class="text-secondary-light/60 text-sm hover:text-primary-light transition">Cookie Policy</a>
                    </div>
                </div>
                <div class="mt-6 flex justify-center space-x-4">
                    <i class="ri-visa-fill ri-lg text-secondary-light/60"></i>
                    <i class="ri-mastercard-fill ri-lg text-secondary-light/60"></i>
                    <i class="ri-paypal-fill ri-lg text-secondary-light/60"></i>
                    <i class="ri-bank-card-fill ri-lg text-secondary-light/60"></i>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // FAQ Toggle
            const faqToggles = document.querySelectorAll(".faq-toggle");

            faqToggles.forEach((toggle) => {
                toggle.addEventListener("click", function () {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector("i");

                    if (content.classList.contains("hidden")) {
                        content.classList.remove("hidden");
                        icon.classList.remove("ri-add-line");
                        icon.classList.add("ri-subtract-line");
                    } else {
                        content.classList.add("hidden");
                        icon.classList.remove("ri-subtract-line");
                        icon.classList.add("ri-add-line");
                    }
                });
            });
        });
    </script>
</body>
</html>