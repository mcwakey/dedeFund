@extends('public.layout')

@section('title', ($locale === 'fr' ? 'Projets' : 'Projects').' - DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="flex flex-wrap items-end justify-between gap-6">
        <div class="max-w-3xl">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Projets a financer' : 'Projects to fund' }}</p>
            <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Soutenez des actions concretes' : 'Support concrete action' }}</h1>
        </div>
        <a class="rounded-full bg-amber-500 px-5 py-3 font-bold text-white hover:bg-amber-600" href="{{ route('donate', ['locale' => $locale]) }}">{{ $isFr ? 'Faire un don' : 'Donate' }}</a>
    </div>

    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @foreach ($projects as $project)
            @php($translation = $project->translation($locale))
            <article class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <img class="h-48 w-full object-cover" src="{{ $project->featured_image }}" alt="{{ $translation?->title }}">
                <div class="p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">{{ $project->area?->localized('name', $locale) }}</p>
                    <h2 class="mt-2 text-xl font-black">{{ $translation?->title }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $translation?->summary }}</p>
                    <div class="mt-5 flex items-center justify-between text-sm font-semibold text-slate-600">
                        <span>{{ number_format((float) $project->raised_amount) }} {{ $project->currency }}</span>
                        <span>{{ number_format((float) $project->target_amount) }} {{ $project->currency }}</span>
                    </div>
                    <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-emerald-600" style="width: {{ $project->fundingPercent() }}%"></div>
                    </div>
                    <a class="mt-5 inline-flex font-bold text-emerald-700" href="{{ route('projects.show', ['locale' => $locale, 'slug' => $translation?->slug]) }}">{{ $isFr ? 'Details' : 'Details' }}</a>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-10">{{ $projects->links() }}</div>
</section>
@endsection
