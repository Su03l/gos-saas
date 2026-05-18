<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Governance SaaS | Enterprise Board Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-primary { background-color: #1e3a8a; }
        .text-primary { color: #1e3a8a; }
        .border-primary { border-color: #1e3a8a; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <div class="h-10 w-10 bg-primary rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-primary">Governance<span class="text-gray-900">SaaS</span></span>
                </div>
                <div class="hidden md:flex items-center space-x-8 space-x-reverse text-sm font-semibold">
                    <a href="#features" class="text-gray-600 hover:text-primary transition">Features</a>
                    <a href="#pricing" class="text-gray-600 hover:text-primary transition">Pricing</a>
                    <a href="{{ route('login') }}" class="text-gray-900 px-5 py-2.5 rounded-full border border-gray-200 hover:bg-gray-50 transition">Client Login</a>
                    <a href="#demo" class="bg-primary text-white px-6 py-2.5 rounded-full hover:bg-blue-900 shadow-lg shadow-blue-900/20 transition">Book a Demo</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative py-20 lg:py-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-primary text-xs font-bold uppercase tracking-wider mb-6">The Future of Board Management</span>
                <h1 class="text-5xl lg:text-7xl font-bold text-gray-900 mb-8 leading-tight">
                    Secure Governance for <span class="text-primary italic">Enterprise</span> Boards
                </h1>
                <p class="text-xl text-gray-600 mb-12 leading-relaxed max-w-2xl mx-auto">
                    Centralize your board meetings, automate legal minutes with AI, and cast binding electronic votes—all in one encrypted, multi-tenant environment.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#demo" class="w-full sm:w-auto bg-primary text-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-blue-900 transition shadow-xl shadow-blue-900/30">Start Your Free Trial</a>
                    <a href="#features" class="w-full sm:w-auto bg-white text-gray-700 border border-gray-200 px-10 py-4 rounded-xl font-bold text-lg hover:bg-gray-50 transition">Watch Product Tour</a>
                </div>
            </div>
        </div>
        <!-- Decorative Background -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 opacity-10">
            <svg viewBox="0 0 1024 1024" class="h-[64rem] w-[64rem]" aria-hidden="true"><circle cx="512" cy="512" r="512" fill="url(#pattern)" fill-opacity="1"/><defs><radialGradient id="pattern"><stop stop-color="#1e3a8a"/><stop offset="1" stop-color="#fff"/></radialGradient></defs></svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Built for Serious Compliance</h2>
                <p class="text-gray-600">Enterprise-grade tools to streamline board operations and reduce legal risks.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition group">
                    <div class="h-14 w-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-primary transition-colors">
                        <svg class="h-8 w-8 text-primary group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Virtual Data Room (VDR)</h3>
                    <p class="text-gray-600 leading-relaxed">Secure, encrypted document storage with watermarking and version control for confidential board papers.</p>
                </div>
                <div class="bg-white p-10 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition group">
                    <div class="h-14 w-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-primary transition-colors">
                        <svg class="h-8 w-8 text-primary group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">AI-Powered Minutes</h3>
                    <p class="text-gray-600 leading-relaxed">Transform meeting recordings and transcripts into structured, legally compliant minutes in seconds.</p>
                </div>
                <div class="bg-white p-10 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition group">
                    <div class="h-14 w-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-primary transition-colors">
                        <svg class="h-8 w-8 text-primary group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Legally Binding Voting</h3>
                    <p class="text-gray-600 leading-relaxed">Secure electronic voting with digital signatures and timestamped receipts for all board resolutions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Simple, Scalable Pricing</h2>
                <p class="text-gray-600">Choose the plan that fits your organization's governance needs.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div class="bg-white p-12 rounded-3xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-500 mb-2">Starter Plan</h3>
                    <div class="text-4xl font-bold mb-6">$199<span class="text-lg font-medium text-gray-400">/month</span></div>
                    <ul class="space-y-4 mb-10 text-gray-600">
                        <li class="flex items-center"><svg class="h-5 w-5 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Up to 10 Board Members</li>
                        <li class="flex items-center"><svg class="h-5 w-5 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> AI Minutes Generation</li>
                        <li class="flex items-center"><svg class="h-5 w-5 text-green-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Standard VDR Storage</li>
                    </ul>
                    <a href="#" class="block text-center py-4 px-8 rounded-xl border border-gray-200 font-bold hover:bg-gray-50 transition">Get Started</a>
                </div>
                <div class="bg-primary p-12 rounded-3xl border border-blue-900 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 bg-blue-600 text-white text-[10px] font-bold px-4 py-1 uppercase tracking-widest">Most Popular</div>
                    <h3 class="text-lg font-bold text-blue-200 mb-2">Enterprise Plan</h3>
                    <div class="text-4xl font-bold text-white mb-6">Custom Pricing</div>
                    <ul class="space-y-4 mb-10 text-blue-100">
                        <li class="flex items-center"><svg class="h-5 w-5 text-blue-300 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Unlimited Board Members</li>
                        <li class="flex items-center"><svg class="h-5 w-5 text-blue-300 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Custom Branding & Domain</li>
                        <li class="flex items-center"><svg class="h-5 w-5 text-blue-300 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Priority 24/7 Support</li>
                    </ul>
                    <a href="#demo" class="block text-center py-4 px-8 rounded-xl bg-white text-primary font-bold hover:bg-gray-100 transition">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-24 bg-primary relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="text-white">
                    <h2 class="text-4xl font-bold mb-6">Ready to upgrade your board's efficiency?</h2>
                    <p class="text-xl text-blue-100 mb-8">Join leading enterprises who trust us with their most sensitive governance data.</p>
                    <div class="flex items-center gap-4 text-blue-200 font-semibold">
                        <div class="flex -space-x-3 space-x-reverse">
                            <div class="h-10 w-10 rounded-full border-2 border-primary bg-gray-200"></div>
                            <div class="h-10 w-10 rounded-full border-2 border-primary bg-gray-300"></div>
                            <div class="h-10 w-10 rounded-full border-2 border-primary bg-gray-400"></div>
                        </div>
                        <span>Trusted by 500+ Board Chairmen</span>
                    </div>
                </div>
                <div class="bg-white p-10 rounded-3xl shadow-2xl">
                    <form class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" placeholder="First Name" class="w-full px-5 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:outline-none focus:border-primary">
                            <input type="text" placeholder="Last Name" class="w-full px-5 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:outline-none focus:border-primary">
                        </div>
                        <input type="email" placeholder="Corporate Email" class="w-full px-5 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:outline-none focus:border-primary">
                        <textarea placeholder="Tell us about your organization" rows="3" class="w-full px-5 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:outline-none focus:border-primary"></textarea>
                        <button type="submit" class="w-full py-4 bg-primary text-white rounded-xl font-bold hover:bg-blue-900 transition shadow-lg shadow-blue-900/20">Book My Strategy Session</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Decorative SVG -->
        <div class="absolute right-0 bottom-0 opacity-20">
            <svg width="400" height="400" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="100" cy="100" r="100" fill="white"/></svg>
        </div>
    </section>

    <footer class="py-12 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} Governance SaaS. Built with security and privacy by design.</p>
        </div>
    </footer>
</body>
</html>
