@extends('public.layout')

@php($translation = $project->translation($locale))
@section('title', $translation?->title.' - DedeFund')
@section('meta_description', $translation?->meta_description ?? $translation?->summary)

@section('content')
@php($isFr = $locale === 'fr')
<section class="bg-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $project->area?->localized('name', $locale) }}</p>
            <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $translation?->title }}</h1>
            <p class="mt-6 text-lg leading-8 text-slate-600">{{ $translation?->summary }}</p>
        </div>
        <img class="aspect-[4/3] w-full rounded-lg object-cover shadow-sm" src="{{ $project->featured_image }}" alt="{{ $translation?->title }}">
    </div>
</section>

<section class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 lg:grid-cols-[1fr_340px] lg:px-8">
    <article class="prose prose-slate max-w-none">
        <h2>{{ $isFr ? 'Description' : 'Description' }}</h2>
        <p>{{ $translation?->description }}</p>
        <h2>{{ $isFr ? 'Objectif general' : 'General objective' }}</h2>
        <p>{{ $translation?->general_objective }}</p>
        <h2>{{ $isFr ? 'Beneficiaires' : 'Beneficiaries' }}</h2>
        <p>{{ $translation?->beneficiaries }}</p>
        <h2>{{ $isFr ? 'Impacts attendus' : 'Expected impact' }}</h2>
        <p>{{ $translation?->expected_impact }}</p>
    </article>
    <aside class="h-fit rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-sm font-bold uppercase tracking-[0.18em] text-slate-500">{{ $isFr ? 'Financement' : 'Funding' }}</div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <div class="text-2xl font-black">{{ number_format((float) $project->raised_amount) }} {{ $project->currency }}</div>
                <div class="text-sm text-slate-500">{{ $isFr ? 'mobilises' : 'raised' }}</div>
            </div>
            <div class="text-right">
                <div class="text-lg font-black">{{ number_format((float) $project->target_amount) }} {{ $project->currency }}</div>
                <div class="text-sm text-slate-500">{{ $isFr ? 'objectif' : 'goal' }}</div>
            </div>
        </div>
        <div class="mt-5 h-3 overflow-hidden rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-emerald-600" style="width: {{ $project->fundingPercent() }}%"></div>
        </div>
        <a class="mt-6 flex justify-center rounded-full bg-amber-500 px-5 py-3 font-bold text-white hover:bg-amber-600" href="{{ route('donate', ['locale' => $locale, 'project_id' => $project->id]) }}">{{ $isFr ? 'Financer ce projet' : 'Fund this project' }}</a>
        <dl class="mt-6 grid gap-3 text-sm">
            <div class="flex justify-between gap-4"><dt class="text-slate-500">{{ $isFr ? 'Lieu' : 'Location' }}</dt><dd class="font-semibold">{{ $project->location }}</dd></div>
            <div class="flex justify-between gap-4"><dt class="text-slate-500">{{ $isFr ? 'Statut' : 'Status' }}</dt><dd class="font-semibold">{{ ucfirst($project->status) }}</dd></div>
        </dl>
    </aside>
</section>
@endsection
