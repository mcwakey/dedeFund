@extends('public.layout')

@section('title', ($locale === 'fr' ? 'Nos actions' : 'Our actions').' - DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="max-w-3xl">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Domaines d intervention' : 'Intervention areas' }}</p>
        <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Cinq axes pour agir durablement' : 'Five areas for durable action' }}</h1>
    </div>
    <div class="mt-10 grid gap-6 md:grid-cols-2">
        @foreach ($areas as $area)
            <article class="rounded-lg border border-slate-200 bg-white p-7 shadow-sm">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-emerald-700">{{ $area->icon }}</p>
                <h2 class="mt-3 text-2xl font-black">{{ $area->localized('name', $locale) }}</h2>
                <p class="mt-4 leading-7 text-slate-600">{{ $area->localized('body', $locale) ?: $area->localized('summary', $locale) }}</p>
            </article>
        @endforeach
    </div>
</section>
@endsection
