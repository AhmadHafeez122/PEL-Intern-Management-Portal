<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEL Internship Portal | Engineer Your Future</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@500;600;700;800;900&display=swap" rel="stylesheet">

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
                        'blob': 'blob 10s infinite',
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(40px, -60px) scale(1.15)' },
                            '66%': { transform: 'translate(-30px, 30px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .grid-mesh {
            background-size: 50px 50px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }
        .grid-mesh-dark {
            background-size: 50px 50px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0.02) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(0, 0, 0, 0.02) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-[#fcfdff] text-slate-800 font-inter overflow-x-hidden" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 25)">

    <!-- Navigation Header -->
    <nav :class="{ 'bg-white/95 backdrop-blur-md shadow-lg py-4 border-b border-gray-100': scrolled, 'bg-transparent py-6 border-b border-white/5': !scrolled }"
         class="fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-3.5 group">
                <img src="{{ asset('images/pel-logo.png') }}" alt="Pak Elektron Limited Logo" class="h-11 w-auto transition-transform group-hover:scale-105 object-contain" />
                <div class="flex flex-col">
                    <span :class="{ 'text-pel-dark': scrolled, 'text-white': !scrolled }" class="font-poppins font-bold text-lg leading-tight transition-colors">
                        Pak Elektron
                    </span>
                    <span :class="{ 'text-slate-500': scrolled, 'text-slate-300': !scrolled }" class="text-[10px] font-bold uppercase tracking-widest transition-colors">
                        Internship Portal
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Menu -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="#about" :class="{ 'text-slate-600 hover:text-pel-blue': scrolled, 'text-slate-200 hover:text-white': !scrolled }" class="font-semibold text-sm tracking-wide transition-colors">Legacy</a>
                <a href="#programs" :class="{ 'text-slate-600 hover:text-pel-blue': scrolled, 'text-slate-200 hover:text-white': !scrolled }" class="font-semibold text-sm tracking-wide transition-colors">Tracks</a>
                <a href="#process" :class="{ 'text-slate-600 hover:text-pel-blue': scrolled, 'text-slate-200 hover:text-white': !scrolled }" class="font-semibold text-sm tracking-wide transition-colors">Process</a>
                <a href="#faq" :class="{ 'text-slate-600 hover:text-pel-blue': scrolled, 'text-slate-200 hover:text-white': !scrolled }" class="font-semibold text-sm tracking-wide transition-colors">FAQs</a>

                <div class="flex items-center gap-4 border-l border-slate-300/40 pl-8">
                    <a href="/login" :class="{ 'text-pel-dark hover:text-pel-blue': scrolled, 'text-white hover:text-slate-200': !scrolled }" class="font-bold text-sm transition-colors">Sign In</a>
                    <a href="/register" class="px-6 py-3 bg-pel-blue text-white rounded-xl font-bold text-sm shadow-lg shadow-pel-blue/30 hover:bg-blue-700 hover:shadow-xl hover:-translate-y-0.5 transition-all">Apply Now</a>
                </div>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-xl focus:outline-none bg-white/10 hover:bg-white/20 transition-all" :class="{ 'text-pel-dark': scrolled, 'text-white': !scrolled }">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Mobile Drawer menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden absolute top-full left-0 w-full bg-white shadow-xl border-t border-gray-100 py-6 px-8 flex flex-col gap-4 rounded-b-3xl">
            <a href="#about" @click="mobileMenuOpen = false" class="text-slate-700 font-semibold hover:text-pel-blue py-1">Legacy</a>
            <a href="#programs" @click="mobileMenuOpen = false" class="text-slate-700 font-semibold hover:text-pel-blue py-1">Tracks</a>
            <a href="#process" @click="mobileMenuOpen = false" class="text-slate-700 font-semibold hover:text-pel-blue py-1">Process</a>
            <a href="#faq" @click="mobileMenuOpen = false" class="text-slate-700 font-semibold hover:text-pel-blue py-1">FAQs</a>
            <hr class="border-slate-100">
            <div class="flex flex-col gap-3 pt-2">
                <a href="/login" class="w-full text-center px-5 py-3 text-pel-blue border border-pel-blue/30 rounded-xl font-bold hover:bg-blue-50">Sign In</a>
                <a href="/register" class="w-full text-center px-5 py-3 bg-pel-blue text-white rounded-xl font-bold shadow-md shadow-pel-blue/10">Apply Now</a>
            </div>
        </div>
    </nav>

    <!-- Big Premium Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center pt-24 overflow-hidden bg-pel-dark">

        <!-- Graphic Grid & Blobs Background -->
        <div class="absolute inset-0 z-0 overflow-hidden grid-mesh">
            <div class="absolute top-10 -left-10 w-96 h-96 bg-pel-blue rounded-full mix-blend-multiply filter blur-[80px] opacity-25 animate-blob"></div>
            <div class="absolute top-20 -right-20 w-96 h-96 bg-pel-teal rounded-full mix-blend-multiply filter blur-[80px] opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-20 left-40 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[80px] opacity-20 animate-blob animation-delay-4000"></div>

            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80" alt="Engineering Hub" class="w-full h-full object-cover opacity-15" />
            <div class="absolute inset-0 bg-gradient-to-b from-pel-dark/40 via-pel-dark/90 to-pel-dark"></div>
        </div>

        <!-- Hero Content container -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center text-white animate-fade-in-up mt-8">

            <!-- Live notice badge -->
            <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 mb-8 hover:bg-white/10 transition-all cursor-default shadow-lg backdrop-blur-md">

                <span class="text-xs font-bold tracking-widest text-slate-200 uppercase font-poppins">Applications Open: Summer Intake</span>
            </div>

            <!-- Big Typographic Header -->
            <h1 class="text-5xl sm:text-7xl lg:text-8xl font-poppins font-black tracking-tight mb-8 leading-[1.05]">
                Engineer Your Future <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-sky-300 to-teal-400">With Industry Leaders</span>
            </h1>

            <p class="text-base sm:text-xl text-slate-300 max-w-3xl mx-auto mb-12 font-light leading-relaxed">
                Step into Pakistan's pioneer engineering, technology, and manufacturing conglomerate. Bridge academia and professional leadership through our immersive, hands-on internship portal.
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-5 max-w-md mx-auto sm:max-w-none">
                <a href="/register" class="w-full sm:w-auto px-10 py-5 bg-pel-blue text-white rounded-2xl font-bold text-lg shadow-[0_8px_32px_rgba(0,91,170,0.4)] hover:bg-blue-600 hover:-translate-y-1 transition-all flex items-center justify-center gap-2 group">
                    Start Application
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="#programs" class="w-full sm:w-auto px-10 py-5 bg-white/5 text-white border border-white/10 backdrop-blur-md rounded-2xl font-bold text-lg hover:bg-white/10 transition-all">
                    Explore Tracks
                </a>
            </div>
        </div>
    </div>

    <!-- Glowing Live Statistics bar -->
    <div class="bg-pel-blue/95 backdrop-blur-md relative z-20 border-y border-white/15">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10 grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/10">
            <div class="p-2">
                <h3 class="text-4xl md:text-5xl font-poppins font-black text-white mb-2">1956</h3>
                <p class="text-blue-100 font-bold text-[11px] uppercase tracking-widest">Year Established</p>
            </div>
            <div class="p-2">
                <h3 class="text-4xl md:text-5xl font-poppins font-black text-white mb-2">500+</h3>
                <p class="text-blue-100 font-bold text-[11px] uppercase tracking-widest">Annual Placements</p>
            </div>
            <div class="p-2">
                <h3 class="text-4xl md:text-5xl font-poppins font-black text-white mb-2">80%</h3>
                <p class="text-blue-100 font-bold text-[11px] uppercase tracking-widest">Placement Rate</p>
            </div>
            <div class="p-2">
                <h3 class="text-4xl md:text-5xl font-poppins font-black text-white mb-2">25+</h3>
                <p class="text-blue-100 font-bold text-[11px] uppercase tracking-widest">Partner Universities</p>
            </div>
        </div>
    </div>

    <!-- Legacy Section -->
    <section id="about" class="py-32 bg-white relative grid-mesh-dark">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-20">

                <!-- Graphic Collage -->
                <div class="lg:w-1/2 relative w-full">
                    <div class="absolute -inset-4 bg-gradient-to-tr from-pel-blue to-teal-400 rounded-3xl transform -rotate-3 opacity-15 blur-2xl"></div>
                    <div class="relative grid grid-cols-2 gap-6">
                        <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80" alt="Manufacturing division" class="rounded-3xl shadow-xl w-full h-80 object-cover transform translate-y-12 transition-transform hover:translate-y-6 duration-500" />
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&q=80" alt="Advanced research center" class="rounded-3xl shadow-xl w-full h-80 object-cover transition-transform hover:-translate-y-6 duration-500" />
                    </div>
                </div>

                <!-- Text info panel -->
                <div class="lg:w-1/2 space-y-6">
                    <div class="inline-block px-4 py-1.5 bg-blue-50 text-pel-blue rounded-full font-bold text-xs tracking-widest uppercase font-poppins">
                        Corporate Legacy
                    </div>
                    <h2 class="text-4xl md:text-5xl font-poppins font-black text-slate-900 leading-tight">
                        Powering the Nation, Empowering Youth
                    </h2>
                    <p class="text-slate-600 font-light leading-relaxed text-lg">
                        For over six decades, <strong>Pak Elektron Limited (PEL)</strong> has stood as a pillar of technological and industrial advancement in Pakistan. Operating through two massive divisions — Appliances and Power — we continuously innovate for a better tomorrow.
                    </p>
                    <p class="text-slate-600 font-light leading-relaxed">
                        The PEL Internship Management System (IMS) is designed to scout and nurture top-tier academic talent. Here, interns don't just observe; they execute, analyze, and lead projects alongside seasoned industry veterans.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-pel-blue shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1">State-of-the-Art Tech</h4>
                                <p class="text-sm text-slate-500">Access massive industrial and software infrastructures.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-pel-blue shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1">Expert Mentorship</h4>
                                <p class="text-sm text-slate-500">Learn directly from regional industry leaders and executives.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Professional Tracks / Domains Section -->
    <section id="programs" class="py-32 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-block px-4 py-1.5 bg-white text-pel-blue rounded-full font-bold text-xs tracking-widest uppercase mb-4 shadow-sm border border-blue-100 font-poppins">
                    Internship Placement Tracks
                </div>
                <h2 class="text-4xl md:text-5xl font-poppins font-black text-slate-900">Explore Internship Domains</h2>
                <p class="text-slate-500 mt-4 text-lg font-light">We offer tailored intensive training blocks spanning multiple fields and divisions.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Track 1 -->
                <div class="group bg-white rounded-3xl border border-slate-200/50 p-8 shadow-sm hover:shadow-xl hover:border-pel-blue/20 transition-all duration-300 flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-pel-blue text-white text-[10px] font-bold uppercase tracking-widest px-4.5 py-1.5 rounded-bl-xl">Core Track</div>
                    <div class="w-16 h-16 bg-blue-50 text-pel-blue rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3 font-poppins">Core Engineering</h3>
                    <p class="text-slate-600 mb-8 flex-grow font-light leading-relaxed">Work within major Power or Appliance operations. Gain practical expertise in Electrical, Mechanical, and Production engineering.</p>
                    <ul class="mb-8 space-y-3.5 text-sm text-slate-500 font-semibold border-t border-slate-100 pt-6">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-pel-blue rounded-full"></span> Design & Prototyping</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-pel-blue rounded-full"></span> Quality Assurance Controls</li>
                    </ul>
                    <a href="/register" class="w-full text-center px-4 py-3.5 bg-slate-50 text-pel-blue font-bold rounded-2xl group-hover:bg-pel-blue group-hover:text-white transition-colors mt-auto shadow-sm">
                        Apply for Engineering
                    </a>
                </div>

                <!-- Track 2 -->
                <div class="group bg-white rounded-3xl border border-slate-200/50 p-8 shadow-sm hover:shadow-xl hover:border-pel-blue/20 transition-all duration-300 flex flex-col h-full">
                    <div class="w-16 h-16 bg-teal-50 text-pel-teal rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3 font-poppins">IT & Software Track</h3>
                    <p class="text-slate-600 mb-8 flex-grow font-light leading-relaxed">Drive digital infrastructure. Contribute directly to database systems, web applications, ERP architectures, and analytical dashboards.</p>
                    <ul class="mb-8 space-y-3.5 text-sm text-slate-500 font-semibold border-t border-slate-100 pt-6">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-pel-teal rounded-full"></span> Full-Stack Applications</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-pel-teal rounded-full"></span> Data & ERP Implementations</li>
                    </ul>
                    <a href="/register" class="w-full text-center px-4 py-3.5 bg-slate-50 text-pel-teal font-bold rounded-2xl group-hover:bg-pel-teal group-hover:text-white transition-colors mt-auto shadow-sm">
                        Apply for IT / CS
                    </a>
                </div>

                <!-- Track 3 -->
                <div class="group bg-white rounded-3xl border border-slate-200/50 p-8 shadow-sm hover:shadow-xl hover:border-pel-blue/20 transition-all duration-300 flex flex-col h-full">
                    <div class="w-16 h-16 bg-amber-50 text-pel-accent rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3 font-poppins">Business & SCM</h3>
                    <p class="text-slate-600 mb-8 flex-grow font-light leading-relaxed">Master industrial operations. Work within logistics networks, audit offices, marketing groups, or human resources.</p>
                    <ul class="mb-8 space-y-3.5 text-sm text-slate-500 font-semibold border-t border-slate-100 pt-6">
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-pel-accent rounded-full"></span> Finance, HR & Audits</li>
                        <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-pel-accent rounded-full"></span> Supply Chain Operations</li>
                    </ul>
                    <a href="/register" class="w-full text-center px-4 py-3.5 bg-slate-50 text-pel-accent font-bold rounded-2xl group-hover:bg-pel-accent group-hover:text-white transition-colors mt-auto shadow-sm">
                        Apply for Business
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- Application Process Steps -->
    <section id="process" class="py-32 bg-white relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center mb-24 max-w-2xl mx-auto">
                <h2 class="text-4xl font-poppins font-black text-slate-900">Your Path to PEL</h2>
                <p class="text-slate-500 mt-3 font-light">A transparent, merit-driven evaluation workflow.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-12 relative">
                <!-- Connecting bar (Visible on desktop md) -->
                <div class="hidden md:block absolute top-8 left-[12%] right-[12%] h-0.5 bg-slate-200/80 -z-10"></div>

                <!-- Step 1 -->
                <div class="text-center group">
                    <div class="w-16 h-16 bg-pel-blue text-white rounded-2xl flex items-center justify-center text-xl font-bold mx-auto mb-6 shadow-lg shadow-pel-blue/20 transition-transform group-hover:scale-105 border-4 border-white">1</div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2 font-poppins">Create Profile</h4>
                    <p class="text-sm text-slate-500 leading-relaxed font-light">Register on our portal and verify your account credentials.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center group">
                    <div class="w-16 h-16 bg-white text-pel-blue border-2 border-pel-blue/30 rounded-2xl flex items-center justify-center text-xl font-bold mx-auto mb-6 shadow-md transition-transform group-hover:scale-105">2</div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2 font-poppins">Upload CV</h4>
                    <p class="text-sm text-slate-500 leading-relaxed font-light">Submit details of your university domain and upload your resume.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center group">
                    <div class="w-16 h-16 bg-white text-pel-blue border-2 border-pel-blue/30 rounded-2xl flex items-center justify-center text-xl font-bold mx-auto mb-6 shadow-md transition-transform group-hover:scale-105">3</div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2 font-poppins">Admin Review</h4>
                    <p class="text-sm text-slate-500 leading-relaxed font-light">HR reviews qualifications and schedules interviews.</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center group">
                    <div class="w-16 h-16 bg-pel-accent text-white rounded-2xl flex items-center justify-center text-xl font-bold mx-auto mb-6 shadow-lg shadow-pel-accent/20 transition-transform group-hover:scale-105 border-4 border-white">4</div>
                    <h4 class="font-bold text-lg text-slate-900 mb-2 font-poppins">Verify & Begin</h4>
                    <p class="text-sm text-slate-500 leading-relaxed font-light">Get allocated a verified supervisor and starting logs.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- FAQ Accordion section -->
    <section id="faq" class="py-32 bg-slate-50 border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">

            <div class="text-center mb-20">
                <h2 class="text-4xl font-poppins font-black text-slate-900">Frequently Asked Questions</h2>
                <p class="text-slate-500 mt-2 font-light">Have questions? We have answers.</p>
            </div>

            <div class="space-y-4" x-data="{ active: null }">

                <!-- Accordion 1 -->
                <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden shadow-sm">
                    <button @click="active = active === 1 ? null : 1" class="w-full px-6 py-5.5 text-left font-semibold text-slate-900 flex justify-between items-center focus:outline-none transition-colors hover:bg-slate-50/50">
                        <span class="font-poppins">Who is eligible to apply?</span>
                        <svg :class="active === 1 ? 'rotate-180 text-pel-blue' : 'text-slate-400'" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 1" x-collapse class="px-6 pb-6 text-slate-500 text-sm leading-relaxed border-t border-slate-50 pt-4 font-light">
                        Students currently enrolled in their 3rd or 4th year of a Bachelor's program, or Master's students from HEC recognized universities are eligible. A minimum CGPA of 2.8 is generally required depending on the domain.
                    </div>
                </div>

                <!-- Accordion 2 -->
                <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden shadow-sm">
                    <button @click="active = active === 2 ? null : 2" class="w-full px-6 py-5.5 text-left font-semibold text-slate-900 flex justify-between items-center focus:outline-none transition-colors hover:bg-slate-50/50">
                        <span class="font-poppins">Are these internships paid?</span>
                        <svg :class="active === 2 ? 'rotate-180 text-pel-blue' : 'text-slate-400'" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 2" x-collapse class="px-6 pb-6 text-slate-500 text-sm leading-relaxed border-t border-slate-50 pt-4 font-light" style="display: none;">
                        Yes, PEL offers a competitive stipend to all selected interns. The exact amount varies based on the duration of the program (6 weeks vs 12 weeks) and the specific department.
                    </div>
                </div>

                <!-- Accordion 3 -->
                <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden shadow-sm">
                    <button @click="active = active === 3 ? null : 3" class="w-full px-6 py-5.5 text-left font-semibold text-slate-900 flex justify-between items-center focus:outline-none transition-colors hover:bg-slate-50/50">
                        <span class="font-poppins">Where will the internship take place?</span>
                        <svg :class="active === 3 ? 'rotate-180 text-pel-blue' : 'text-slate-400'" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="active === 3" x-collapse class="px-6 pb-6 text-slate-500 text-sm leading-relaxed border-t border-slate-50 pt-4 font-light" style="display: none;">
                        The primary locations are PEL Head Office in Lahore and our manufacturing plants. Based on the domain, some remote/hybrid modules for IT & Software might be permitted.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Mega Call to Action Panel -->
    <section class="bg-pel-dark py-28 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5 z-0"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-pel-blue rounded-full filter blur-[100px] opacity-20"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 lg:px-8 text-center space-y-8">
            <h2 class="text-4xl md:text-6xl font-poppins font-black text-white leading-tight">Ready to Engineer Your Future?</h2>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto font-light leading-relaxed">
                Join the ranks of top-tier professionals. Applications for the upcoming cycle are reviewed on a rolling basis.
            </p>
            <a href="/register" class="inline-block px-12 py-5 bg-white text-pel-blue font-bold rounded-2xl shadow-xl hover:bg-slate-50 hover:scale-105 transition-all text-lg font-poppins">
                Create Your Account Now
            </a>
        </div>
    </section>

    <!-- Premium Mega Footer -->
    <footer class="bg-[#071324] text-slate-400 pt-24 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-16">
                <!-- Branding column -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/pel-logo.png') }}" alt="PEL" class="h-10 w-auto object-contain bg-white/10 p-1.5 rounded-lg border border-white/5" />
                        <span class="font-poppins font-bold text-white text-lg tracking-wide leading-tight">IMS Portal</span>
                    </div>
                    <p class="text-sm text-slate-500 font-light leading-relaxed">
                        Pak Elektron Limited is Pakistan's pioneer in electrical manufacturing. Empowering generations through innovation and industrial excellence since 1956.
                    </p>
                </div>

                <!-- Tracks column -->
                <div class="space-y-6">
                    <h4 class="text-white font-bold tracking-wider uppercase text-sm font-poppins">Tracks</h4>
                    <ul class="space-y-3.5 text-sm font-medium">
                        <li><a href="#" class="hover:text-white transition-colors">Engineering Internship</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">IT & Software Tracks</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Business Operations</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Supply Chain Logistics</a></li>
                    </ul>
                </div>

                <!-- Support column -->
                <div class="space-y-6">
                    <h4 class="text-white font-bold tracking-wider uppercase text-sm font-poppins">Support</h4>
                    <ul class="space-y-3.5 text-sm font-medium">
                        <li><a href="#faq" class="hover:text-white transition-colors">FAQ Support</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Candidate Guides</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">HR Desk</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Affiliated Colleges</a></li>
                    </ul>
                </div>

                <!-- Contact column -->
                <div class="space-y-6">
                    <h4 class="text-white font-bold tracking-wider uppercase text-sm font-poppins">Contact Us</h4>
                    <ul class="space-y-4.5 text-sm font-medium text-slate-500 leading-relaxed">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-pel-blue shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>14-KM Ferozepur Road,<br>Lahore, Pakistan</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-pel-blue shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:internships@pel.com.pk" class="hover:text-white transition-colors">internships@pel.com.pk</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright footer bottom -->
            <div class="flex flex-col md:flex-row items-center justify-between pt-10 border-t border-slate-800 text-xs text-slate-600 font-medium">
                <p>&copy; {{ date('Y') }} Pak Elektron Limited (Saigol Group). All rights reserved.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-slate-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-400 transition-colors">Terms of Service</a>
                </div>
            </div>

        </div>
    </footer>

    {{-- Floated AI Chatbot Widget Included Back --}}
    @include('components.chatbot')

</body>
</html>
