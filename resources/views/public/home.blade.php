@extends('public.layout')

@section('title', 'DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="relative overflow-hidden bg-slate-950">
    <div class="absolute inset-0 bg-cover bg-center opacity-45" style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1800&q=80');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/80 to-emerald-950/40"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <p class="text-sm font-bold uppercase tracking-[0.25em] text-amber-300">DedeFund</p>
            <h1 class="mt-4 text-4xl font-black tracking-tight text-white sm:text-6xl">
                {{ $isFr ? 'Ensemble pour un monde sans pauvrete' : 'Together for a world without poverty' }}
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-200">
                {{ $isFr ? 'Nous mobilisons la solidarite internationale pour soutenir les femmes, les enfants, les jeunes et les familles vulnerables.' : 'We mobilize international solidarity to support women, children, youth, and vulnerable families.' }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a class="rounded-full bg-amber-500 px-6 py-3 font-bold text-white hover:bg-amber-600" href="{{ route('donate', ['locale' => $locale]) }}">{{ $isFr ? 'Faire un don' : 'Donate' }}</a>
                <a class="rounded-full bg-white px-6 py-3 font-bold text-slate-950 hover:bg-slate-100" href="{{ route('projects.index', ['locale' => $locale]) }}">{{ $isFr ? 'Financer un projet' : 'Fund a project' }}</a>
                <a class="rounded-full border border-white/40 px-6 py-3 font-bold text-white hover:bg-white/10" href="{{ route('volunteer', ['locale' => $locale]) }}">{{ $isFr ? 'Devenir volontaire' : 'Become a volunteer' }}</a>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Notre mission' : 'Our mission' }}</p>
            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Une plateforme d impact, de confiance et d action.' : 'An impact platform built for trust and action.' }}</h2>
        </div>
        <p class="text-lg leading-8 text-slate-600">
            {{ $isFr ? 'DedeFund presente ses actions, mobilise des donateurs, accueille des volontaires et organise ses projets via une plateforme administrable et bilingue.' : 'DedeFund presents its work, mobilizes donors, welcomes volunteers, and manages projects through a bilingual, administrable platform.' }}
        </p>
    </div>

    <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-5">
        @foreach ($areas as $area)
            <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-2xl">{{ $area->icon ?? 'Impact' }}</div>
                <h3 class="mt-4 font-black text-slate-950">{{ $area->localized('name', $locale) }}</h3>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $area->localized('summary', $locale) }}</p>
            </article>
        @endforeach
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-6">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Projets phares' : 'Featured projects' }}</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Des projets prets a etre soutenus' : 'Projects ready for support' }}</h2>
            </div>
            <a class="hidden rounded-full border border-slate-300 px-5 py-2 text-sm font-bold hover:border-emerald-700 hover:text-emerald-700 sm:inline-flex" href="{{ route('projects.index', ['locale' => $locale]) }}">{{ $isFr ? 'Voir tout' : 'View all' }}</a>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ($featuredProjects as $project)
                @php($translation = $project->translation($locale))
                <article class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                    <img class="h-48 w-full object-cover" src="{{ $project->featured_image }}" alt="{{ $translation?->title }}">
                    <div class="p-5">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">{{ $project->area?->localized('name', $locale) }}</p>
                        <h3 class="mt-2 text-xl font-black">{{ $translation?->title }}</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $translation?->summary }}</p>
                        <div class="mt-5 h-2 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-emerald-600" style="width: {{ $project->fundingPercent() }}%"></div>
                        </div>
                        <div class="mt-2 text-xs font-semibold text-slate-500">{{ $project->fundingPercent() }}% funded</div>
                        <a class="mt-5 inline-flex font-bold text-emerald-700" href="{{ route('projects.show', ['locale' => $locale, 'slug' => $translation?->slug]) }}">{{ $isFr ? 'Voir le projet' : 'View project' }}</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="mx-auto grid max-w-7xl gap-8 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8">
    <div class="rounded-lg bg-emerald-800 p-8 text-white">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-amber-200">{{ $isFr ? 'Mobilisation' : 'Mobilization' }}</p>
        <h2 class="mt-3 text-3xl font-black">{{ $isFr ? 'Aidez-nous a transformer une intention en impact.' : 'Help turn intention into impact.' }}</h2>
        <p class="mt-4 text-emerald-50">{{ $isFr ? 'Chaque don, competence et partenariat peut soutenir un projet concret.' : 'Every donation, skill, and partnership can support a concrete project.' }}</p>
        <a class="mt-6 inline-flex rounded-full bg-white px-5 py-3 font-bold text-emerald-800" href="{{ route('donate', ['locale' => $locale]) }}">{{ $isFr ? 'Contribuer' : 'Contribute' }}</a>
    </div>
    <div class="rounded-lg border border-slate-200 bg-white p-8">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Actualites recentes' : 'Recent news' }}</p>
        <div class="mt-6 grid gap-5">
            @foreach ($latestPosts as $post)
                @php($translation = $post->translation($locale))
                <a class="block border-b border-slate-200 pb-5 last:border-0 last:pb-0" href="{{ route('blog.show', ['locale' => $locale, 'slug' => $translation?->slug]) }}">
                    <h3 class="font-black text-slate-950">{{ $translation?->title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $translation?->summary }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
