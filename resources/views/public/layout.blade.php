<!DOCTYPE html>
<html lang="{{ $locale ?? 'fr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'DedeFund works for dignity, justice, peace, and a world without poverty.')">
    <title>@yield('title', 'DedeFund')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    @php
        $locale = $locale ?? app()->getLocale();
        $isFr = $locale === 'fr';
        $nav = [
            ['label' => $isFr ? 'Accueil' : 'Home', 'route' => 'home'],
            ['label' => $isFr ? 'A propos' : 'About', 'route' => 'about'],
            ['label' => $isFr ? 'Actions' : 'Actions', 'route' => 'actions'],
            ['label' => $isFr ? 'Projets' : 'Projects', 'route' => 'projects.index'],
            ['label' => $isFr ? 'Blog' : 'Blog', 'route' => 'blog.index'],
            ['label' => $isFr ? 'Contact' : 'Contact', 'route' => 'contact'],
        ];
    @endphp

    <header class="sticky top-0 z-40 border-b border-white/70 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home', ['locale' => $locale]) }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-700 text-sm font-black text-white">DF</span>
                <span>
                    <span class="block text-lg font-black tracking-tight text-slate-950">DedeFund</span>
                    <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">501(c)(3) charity</span>
                </span>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-700 lg:flex">
                @foreach ($nav as $item)
                    <a class="hover:text-emerald-700" href="{{ route($item['route'], ['locale' => $locale]) }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a class="rounded-full px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100" href="{{ route('home', ['locale' => 'fr']) }}">FR</a>
                <a class="rounded-full px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100" href="{{ route('home', ['locale' => 'en']) }}">EN</a>
                <a class="rounded-full bg-amber-500 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-amber-600" href="{{ route('donate', ['locale' => $locale]) }}">
                    {{ $isFr ? 'Faire un don' : 'Donate' }}
                </a>
            </div>
        </div>
    </header>

    @if (session('status'))
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                {{ session('status') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                <strong>{{ $isFr ? 'A verifier :' : 'Please check:' }}</strong>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 bg-slate-950 text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-4 lg:px-8">
            <div class="md:col-span-2">
                <div class="text-2xl font-black">DedeFund</div>
                <p class="mt-4 max-w-xl text-sm leading-6 text-slate-300">
                    {{ $isFr ? 'Association a but non lucratif engagee pour la dignite humaine, la justice, la paix et la lutte contre la pauvrete.' : 'A nonprofit organization committed to human dignity, justice, peace, and the fight against poverty.' }}
                </p>
            </div>
            <div>
                <div class="font-bold">{{ $isFr ? 'Contact' : 'Contact' }}</div>
                <p class="mt-4 text-sm leading-6 text-slate-300">
                    897 Middle River RD<br>
                    Middle River, MD 21220, USA<br>
                    +1 240 353 8332<br>
                    info@dedefund.org
                </p>
            </div>
            <div>
                <div class="font-bold">{{ $isFr ? 'Liens' : 'Links' }}</div>
                <div class="mt-4 grid gap-2 text-sm text-slate-300">
                    <a href="{{ route('privacy', ['locale' => $locale]) }}">{{ $isFr ? 'Confidentialite' : 'Privacy' }}</a>
                    <a href="{{ route('terms', ['locale' => $locale]) }}">{{ $isFr ? 'Conditions' : 'Terms' }}</a>
                    <a href="{{ route('volunteer', ['locale' => $locale]) }}">{{ $isFr ? 'Volontariat' : 'Volunteer' }}</a>
                    <a href="{{ route('internships', ['locale' => $locale]) }}">{{ $isFr ? 'Stages' : 'Internships' }}</a>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} DedeFund. {{ $isFr ? 'Tous droits reserves.' : 'All rights reserved.' }}
        </div>
    </footer>

    <a href="https://wa.me/12403538332?text={{ urlencode($isFr ? 'Bonjour DedeFund, je souhaite avoir des informations.' : 'Hello DedeFund, I would like more information.') }}" class="fixed bottom-5 right-5 rounded-full bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-lg hover:bg-emerald-700">
        WhatsApp
    </a>
</body>
</html>
