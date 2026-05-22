@extends('public.layout')

@section('title', ($locale === 'fr' ? 'A propos' : 'About').' - DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="max-w-3xl">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">DedeFund</p>
        <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Une organisation de charite orientee impact' : 'An impact-driven charity organization' }}</h1>
        <p class="mt-6 text-lg leading-8 text-slate-600">
            {{ $isFr ? 'DedeFund est presentee comme une association a but non lucratif de droit americain, reconnue sous le statut 501(c)(3), avec une mission internationale de lutte contre la pauvrete.' : 'DedeFund is presented as a US nonprofit charity under 501(c)(3) status, with an international mission to fight poverty.' }}
        </p>
    </div>
    <div class="mt-12 grid gap-6 md:grid-cols-3">
        @foreach ([
            $isFr ? 'Dignite humaine' : 'Human dignity',
            $isFr ? 'Justice et paix' : 'Justice and peace',
            $isFr ? 'Solidarite active' : 'Active solidarity',
        ] as $value)
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-black">{{ $value }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $isFr ? 'Une valeur directrice pour concevoir et suivre chaque action.' : 'A guiding value for designing and monitoring every action.' }}</p>
            </div>
        @endforeach
    </div>
</section>
@endsection
