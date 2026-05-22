@extends('public.layout')

@section('title', 'Blog - DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="max-w-3xl">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Actualites' : 'News' }}</p>
        <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Histoires, rapports et appels a contribution' : 'Stories, reports, and calls for support' }}</h1>
    </div>
    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @foreach ($posts as $post)
            @php($translation = $post->translation($locale))
            <article class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <img class="h-44 w-full object-cover" src="{{ $post->featured_image }}" alt="{{ $translation?->title }}">
                <div class="p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">{{ $post->category?->localized('name', $locale) }}</p>
                    <h2 class="mt-2 text-xl font-black">{{ $translation?->title }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $translation?->summary }}</p>
                    <a class="mt-5 inline-flex font-bold text-emerald-700" href="{{ route('blog.show', ['locale' => $locale, 'slug' => $translation?->slug]) }}">{{ $isFr ? 'Lire' : 'Read' }}</a>
                </div>
            </article>
        @endforeach
    </div>
    <div class="mt-10">{{ $posts->links() }}</div>
</section>
@endsection
