<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEL Internship Portal | Engineer Your Future</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        pel: {
                            blue: '#005baa', // Corporate Blue
                            dark: '#0a2540', // Deep Navy
                            light: '#f0f6ff', // Light Wash
                            accent: '#f59e0b', // Amber Accent
                            teal: '#0d9488' // Secondary Accent
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-inter overflow-x-hidden" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navigation -->
    <nav :class="{ 'bg-white/95 backdrop-blur-md shadow-md py-3': scrolled, 'bg-transparent py-5': !scrolled }" class="fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <!-- SVG PEL Logo -->
             <img
    src="{{ asset('images/pel-logo.png') }}"
    alt="Pak Elektron Limited Official Logo"
    class="h-10 w-auto transition-transform group-hover:scale-105 object-contain"
/>
                <div class="flex flex-col">
                    <span :class="{ 'text-pel-dark': scrolled, 'text-white': !scrolled }" class="font-poppins font-bold text-lg hidden sm:block leading-tight transition-colors">
                        Pak Elektron
                    </span>
                    <span :class="{ 'text-gray-500': scrolled, 'text-gray-300': !scrolled }" class="text-xs font-semibold uppercase tracking-widest hidden sm:block transition-colors">
                        Internship Portal
                    </span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="#about" :class="{ 'text-gray-600 hover:text-pel-blue': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="font-medium text-sm tracking-wide transition-colors">Legacy</a>
                <a href="#programs" :class="{ 'text-gray-600 hover:text-pel-blue': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="font-medium text-sm tracking-wide transition-colors">Domains</a>
                <a href="#process" :class="{ 'text-gray-600 hover:text-pel-blue': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="font-medium text-sm tracking-wide transition-colors">How to Apply</a>
                <a href="#faq" :class="{ 'text-gray-600 hover:text-pel-blue': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="font-medium text-sm tracking-wide transition-colors">FAQs</a>

                <div class="flex items-center gap-4 border-l border-gray-300/50 pl-6">
                    <a href="/login" :class="{ 'text-pel-dark hover:text-pel-blue': scrolled, 'text-white hover:text-gray-200': !scrolled }" class="font-semibold text-sm transition-colors">Sign In</a>
                    <a href="/register" class="px-6 py-2.5 bg-pel-blue text-white rounded-lg font-semibold text-sm shadow-lg shadow-pel-blue/30 hover:bg-blue-700 hover:shadow-xl hover:-translate-y-0.5 transition-all">Apply Now</a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-md focus:outline-none" :class="{ 'text-pel-dark': scrolled, 'text-white': !scrolled }">
                <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden absolute top-full left-0 w-full bg-white shadow-2xl border-t border-gray-100 py-6 px-6 flex flex-col gap-5 rounded-b-2xl">
            <a href="#about" @click="mobileMenuOpen = false" class="text-gray-700 font-medium hover:text-pel-blue">Our Legacy</a>
            <a href="#programs" @click="mobileMenuOpen = false" class="text-gray-700 font-medium hover:text-pel-blue">Internship Domains</a>
            <a href="#process" @click="mobileMenuOpen = false" class="text-gray-700 font-medium hover:text-pel-blue">Application Process</a>
            <hr class="border-gray-100">
            <div class="flex flex-col gap-3 pt-2">
                <a href="/login" class="w-full text-center px-5 py-3 text-pel-blue border border-pel-blue rounded-xl font-semibold hover:bg-blue-50">Sign In</a>
                <a href="/register" class="w-full text-center px-5 py-3 bg-pel-blue text-white rounded-xl font-semibold shadow-md">Apply Now</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden bg-pel-dark">
        <!-- Abstract Animated Background -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-pel-blue rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-pel-teal rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80" alt="Engineering Background" class="w-full h-full object-cover opacity-20" />
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-pel-dark/80 to-pel-dark"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center text-white animate-fade-in-up">
            <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-white/5 backdrop-blur-md border border-white/10 mb-8 hover:bg-white/10 transition-colors cursor-default">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pel-accent opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-pel-accent"></span>
                </span>
                <span class="text-sm font-semibold tracking-wide text-gray-200 uppercase">Applications Open: Summer 2026 </span>
            </div>

            <h1 class="text-5xl md:text-7xl lg:text-8xl font-poppins font-extrabold tracking-tight mb-6 leading-[1.1]">
                Engineer Your Future <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-pel-blue to-teal-400">With Industry Leaders</span>
            </h1>

            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto mb-10 font-light leading-relaxed">
                Step into Pakistan's premier technological and manufacturing conglomerate. Bridge the gap between academic theory and real-world innovation through our immersive, hands-on internship programs.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                <a href="/register" class="w-full sm:w-auto px-8 py-4 bg-pel-blue text-white rounded-xl font-bold text-lg shadow-[0_0_40px_rgba(0,91,170,0.4)] hover:bg-blue-600 hover:-translate-y-1 transition-all flex items-center justify-center gap-2 group">
                    Start Application
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="#programs" class="w-full sm:w-auto px-8 py-4 bg-white/5 text-white border border-white/20 backdrop-blur-md rounded-xl font-bold text-lg hover:bg-white/10 transition-all">
                    Explore Domains
                </a>
            </div>
        </div>
    </div>

    <!-- Live Stats Bar -->
    <div class="bg-pel-blue relative z-20 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/20">
            <div class="p-4">
                <h3 class="text-4xl md:text-5xl font-poppins font-bold text-white mb-2">1956</h3>
                <p class="text-blue-200 font-medium text-sm uppercase tracking-wider">Year Established</p>
            </div>
            <div class="p-4">
                <h3 class="text-4xl md:text-5xl font-poppins font-bold text-white mb-2">500+</h3>
                <p class="text-blue-200 font-medium text-sm uppercase tracking-wider">Yearly Interns</p>
            </div>
            <div class="p-4">
                <h3 class="text-4xl md:text-5xl font-poppins font-bold text-white mb-2">80%</h3>
                <p class="text-blue-200 font-medium text-sm uppercase tracking-wider">Placement Rate</p>
            </div>
            <div class="p-4">
                <h3 class="text-4xl md:text-5xl font-poppins font-bold text-white mb-2">25+</h3>
                <p class="text-blue-200 font-medium text-sm uppercase tracking-wider">Partner Universities</p>
            </div>
        </div>
    </div>

    <!-- About / Legacy Section -->
    <section id="about" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <!-- Image Collage -->
                <div class="lg:w-1/2 relative">
                    <div class="absolute -inset-4 bg-gradient-to-tr from-pel-blue to-teal-400 rounded-3xl transform -rotate-3 opacity-20 blur-xl"></div>
                    <div class="relative grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80" alt="Manufacturing" class="rounded-2xl shadow-xl w-full h-64 object-cover transform translate-y-8" />
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&q=80" alt="Corporate" class="rounded-2xl shadow-xl w-full h-64 object-cover" />
                    </div>
                </div>

                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <div class="inline-block px-4 py-1.5 bg-blue-50 text-pel-blue rounded-full font-semibold text-sm tracking-widest uppercase mb-4">
                        Corporate Legacy
                    </div>
                    <h3 class="text-3xl md:text-5xl font-poppins font-bold text-gray-900 mb-6 leading-tight">
                        Powering the Nation, Empowering Youth
                    </h3>
                    <p class="text-gray-600 mb-6 leading-relaxed text-lg">
                        For over six decades, <strong>Pak Elektron Limited (PEL)</strong> has stood as a pillar of technological and industrial advancement in Pakistan. Operating through two massive divisions—Appliances and Power—we continuously innovate for a better tomorrow.
                    </p>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        The PEL Internship Management System (IMS) is designed to scout and nurture top-tier academic talent. Here, interns don't just observe; they execute, analyze, and lead projects alongside seasoned industry veterans.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 bg-pel-blue/10 text-pel-blue rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">State-of-the-Art Tech</h4>
                            <p class="text-sm text-gray-500">Access massive industrial and software infrastructures.</p>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                            <div class="w-10 h-10 bg-pel-blue/10 text-pel-blue rounded-lg flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Expert Mentorship</h4>
                            <p class="text-sm text-gray-500">Learn directly from regional industry leaders and executives.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs / Domains Section -->
    <section id="programs" class="py-24 bg-pel-light">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block px-4 py-1.5 bg-white text-pel-blue rounded-full font-semibold text-sm tracking-widest uppercase mb-4 shadow-sm border border-blue-100">
                    Available Opportunities
                </div>
                <h3 class="text-3xl md:text-5xl font-poppins font-bold text-gray-900 mb-6">Explore Internship Domains</h3>
                <p class="text-gray-600 text-lg">We offer tailored 6-week (Summer) and 12-week (Capstone) intensive programs across multiple professional disciplines.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Program 1 -->
                <div class="group bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:border-pel-blue/30 transition-all duration-300 flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-pel-blue text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10">High Demand</div>
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-50 to-blue-100 text-pel-blue rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-3">Core Engineering</h4>
                    <p class="text-gray-600 mb-6 flex-grow">Immerse yourself in Power and Appliance divisions. Gain practical expertise in Electrical, Mechanical, and Industrial engineering.</p>
                    <ul class="mb-8 space-y-2 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-pel-blue" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> R&D and Prototyping</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-pel-blue" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Quality Assurance Operations</li>
                    </ul>
                    <a href="/register?domain=engineering" class="w-full text-center px-4 py-3 bg-gray-50 text-pel-blue font-bold rounded-xl group-hover:bg-pel-blue group-hover:text-white transition-colors mt-auto">
                        Apply for Engineering
                    </a>
                </div>

                <!-- Program 2 -->
                <div class="group bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:border-pel-blue/30 transition-all duration-300 flex flex-col h-full">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-50 to-blue-100 text-pel-blue rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-3">IT & Software</h4>
                    <p class="text-gray-600 mb-6 flex-grow">Drive digital transformation. Contribute to enterprise-level architecture, web systems, and ERP infrastructure.</p>
                    <ul class="mb-8 space-y-2 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-pel-blue" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Full-Stack Web Development</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-pel-blue" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Data Analytics & Oracle ERP</li>
                    </ul>
                    <a href="/register?domain=it" class="w-full text-center px-4 py-3 bg-gray-50 text-pel-blue font-bold rounded-xl group-hover:bg-pel-blue group-hover:text-white transition-colors mt-auto">
                        Apply for IT
                    </a>
                </div>

                <!-- Program 3 -->
                <div class="group bg-white rounded-2xl border border-gray-100 p-8 shadow-sm hover:shadow-2xl hover:border-pel-blue/30 transition-all duration-300 flex flex-col h-full">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-50 to-blue-100 text-pel-blue rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-3">Business & SCM</h4>
                    <p class="text-gray-600 mb-6 flex-grow">Master the commercial ecosystem. Work with our Supply Chain, HR, Finance, and Marketing masterminds.</p>
                    <ul class="mb-8 space-y-2 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-pel-blue" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Corporate Finance & Audit</li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-pel-blue" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Global SCM & Procurement</li>
                    </ul>
                    <a href="/register?domain=business" class="w-full text-center px-4 py-3 bg-gray-50 text-pel-blue font-bold rounded-xl group-hover:bg-pel-blue group-hover:text-white transition-colors mt-auto">
                        Apply for Business
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Process -->
    <section id="process" class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-poppins font-bold text-gray-900 mb-4">Your Path to PEL</h3>
                <p class="text-gray-600">A transparent, merit-based selection process.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 -z-10 transform -translate-y-1/2"></div>

                <div class="text-center relative">
                    <div class="w-16 h-16 bg-pel-blue text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 shadow-lg shadow-pel-blue/30 border-4 border-white">1</div>
                    <h4 class="font-bold text-lg mb-2">Create Profile</h4>
                    <p class="text-sm text-gray-500">Register on our portal and complete your digital resume.</p>
                </div>
                <div class="text-center relative">
                    <div class="w-16 h-16 bg-white text-pel-blue border-4 border-pel-blue rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 shadow-lg">2</div>
                    <h4 class="font-bold text-lg mb-2">Online Assessment</h4>
                    <p class="text-sm text-gray-500">Pass domain-specific technical and aptitude tests.</p>
                </div>
                <div class="text-center relative">
                    <div class="w-16 h-16 bg-white text-pel-blue border-4 border-pel-blue rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 shadow-lg">3</div>
                    <h4 class="font-bold text-lg mb-2">Panel Interview</h4>
                    <p class="text-sm text-gray-500">Meet with department heads and HR leadership.</p>
                </div>
                <div class="text-center relative">
                    <div class="w-16 h-16 bg-pel-accent text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 shadow-lg shadow-pel-accent/30 border-4 border-white">4</div>
                    <h4 class="font-bold text-lg mb-2">Offer & Onboarding</h4>
                    <p class="text-sm text-gray-500">Receive your offer letter and begin your journey.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQs Section (Alpine.js Interactive) -->
    <section id="faq" class="py-24 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-poppins font-bold text-gray-900 mb-4">Frequently Asked Questions</h3>
                <p class="text-gray-600">Got questions? We have answers.</p>
            </div>

            <div class="space-y-4" x-data="{ active: null }">
                <!-- FAQ 1 -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <button @click="active = active === 1 ? null : 1" class="w-full px-6 py-5 text-left font-semibold text-gray-900 flex justify-between items-center focus:outline-none">
                        Who is eligible to apply?
                        <svg :class="active === 1 ? 'rotate-180 text-pel-blue' : 'text-gray-400'" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 1" x-collapse class="px-6 pb-5 text-gray-600 text-sm leading-relaxed">
                        Students currently enrolled in their 3rd or 4th year of a Bachelor's program, or Master's students from HEC recognized universities are eligible. A minimum CGPA of 2.8 is generally required depending on the domain.
                    </div>
                </div>
                <!-- FAQ 2 -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <button @click="active = active === 2 ? null : 2" class="w-full px-6 py-5 text-left font-semibold text-gray-900 flex justify-between items-center focus:outline-none">
                        Are these internships paid?
                        <svg :class="active === 2 ? 'rotate-180 text-pel-blue' : 'text-gray-400'" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 2" x-collapse class="px-6 pb-5 text-gray-600 text-sm leading-relaxed" style="display: none;">
                        Yes, PEL offers a competitive stipend to all selected interns. The exact amount varies based on the duration of the program (6 weeks vs 12 weeks) and the specific department.
                    </div>
                </div>
                <!-- FAQ 3 -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <button @click="active = active === 3 ? null : 3" class="w-full px-6 py-5 text-left font-semibold text-gray-900 flex justify-between items-center focus:outline-none">
                        Where will the internship take place?
                        <svg :class="active === 3 ? 'rotate-180 text-pel-blue' : 'text-gray-400'" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 3" x-collapse class="px-6 pb-5 text-gray-600 text-sm leading-relaxed" style="display: none;">
                        The primary locations are PEL Head Office in Lahore and our manufacturing plants. Based on the domain, some remote/hybrid modules for IT & Software might be permitted.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-pel-blue py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-poppins font-bold text-white mb-6">Ready to Engineer Your Future?</h2>
            <p class="text-blue-100 text-lg mb-10 max-w-2xl mx-auto">Join the ranks of top-tier professionals. Applications for the upcoming cycle are closing soon. Do not miss your chance to be part of the PEL legacy.</p>
            <a href="/register" class="inline-block px-10 py-4 bg-white text-pel-blue font-bold rounded-xl shadow-2xl hover:bg-gray-50 hover:scale-105 transition-all text-lg">
                Create Your Account Now
            </a>
        </div>
    </section>

    <!-- Mega Footer -->
    <footer class="bg-pel-dark text-gray-300 pt-20 pb-10 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand Column -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <svg class="w-12 h-8" viewBox="0 0 120 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="120" height="50" rx="4" fill="#005baa"/>
                            <path d="M25 35V15H35C38.5 15 40 17 40 20C40 23 38.5 25 35 25H30V35H25ZM30 20.5V21H34.5C35.5 21 36 20.5 36 19.5C36 18.5 35.5 18 34.5 18H30V20.5Z" fill="white"/>
                            <path d="M50 35V15H65V19.5H55V22.5H62V26.5H55V30.5H65V35H50Z" fill="white"/>
                            <path d="M75 35V15H80V30.5H92V35H75Z" fill="white"/>
                        </svg>
                        <span class="font-poppins font-bold text-white text-lg leading-tight">Internship<br>System</span>
                    </div>
                    <p class="text-sm text-gray-400 mb-6">
                        Pak Elektron Limited is Pakistan's pioneer in electrical manufacturing. Empowering generations through innovation and excellence since 1956.
                    </p>
                </div>

                <!-- Links Column 1 -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider uppercase text-sm">Programs</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-pel-blue transition-colors">Engineering Internship</a></li>
                        <li><a href="#" class="hover:text-pel-blue transition-colors">IT & Software Division</a></li>
                        <li><a href="#" class="hover:text-pel-blue transition-colors">Business & Management</a></li>
                        <li><a href="#" class="hover:text-pel-blue transition-colors">Supply Chain Ops</a></li>
                    </ul>
                </div>

                <!-- Links Column 2 -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider uppercase text-sm">Support</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#faq" class="hover:text-pel-blue transition-colors">FAQs</a></li>
                        <li><a href="#" class="hover:text-pel-blue transition-colors">Application Guidelines</a></li>
                        <li><a href="#" class="hover:text-pel-blue transition-colors">Contact HR</a></li>
                        <li><a href="#" class="hover:text-pel-blue transition-colors">University Partners</a></li>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider uppercase text-sm">Contact Us</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-pel-blue mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>14-KM Ferozepur Road,<br>Lahore, Pakistan</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-pel-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:internships@pel.com.pk" class="hover:text-white transition-colors">internships@pel.com.pk</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="flex flex-col md:flex-row items-center justify-between pt-8 border-t border-white/10 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Pak Elektron Limited (PEL). All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
