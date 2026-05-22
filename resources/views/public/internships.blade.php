@extends('public.layout')

@section('title', ($locale === 'fr' ? 'Offres de stages' : 'Internships').' - DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-8">
    <div>
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Stages' : 'Internships' }}</p>
        <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Postulez en ligne' : 'Apply online' }}</h1>
        <p class="mt-6 text-lg leading-8 text-slate-600">{{ $isFr ? 'Les documents sont stockes dans un espace prive du serveur pour traitement par l administration.' : 'Documents are stored in the server private storage for admin review.' }}</p>
    </div>
    <form method="POST" enctype="multipart/form-data" action="{{ route('internships.store', ['locale' => $locale]) }}" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <div class="grid gap-5 md:grid-cols-2">
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Nom complet' : 'Full name' }}<input class="rounded-lg border-slate-300" name="full_name" required></label>
            <label class="grid gap-2 text-sm font-semibold">Email<input class="rounded-lg border-slate-300" type="email" name="email" required></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Telephone' : 'Phone' }}<input class="rounded-lg border-slate-300" name="phone"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Pays' : 'Country' }}<input class="rounded-lg border-slate-300" name="country"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Domaine' : 'Domain' }}<input class="rounded-lg border-slate-300" name="domain"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Type de stage' : 'Internship type' }}<input class="rounded-lg border-slate-300" name="internship_type"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Date souhaitee' : 'Desired start date' }}<input class="rounded-lg border-slate-300" type="date" name="desired_start_date"></label>
            <label class="grid gap-2 text-sm font-semibold">CV<input class="rounded-lg border-slate-300" type="file" name="cv"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Attestation' : 'Certificate' }}<input class="rounded-lg border-slate-300" type="file" name="study_certificate"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Lettre institutionnelle' : 'Institution letter' }}<input class="rounded-lg border-slate-300" type="file" name="institution_letter"></label>
            <label class="grid gap-2 text-sm font-semibold md:col-span-2">{{ $isFr ? 'Autres pieces' : 'Other files' }}<input class="rounded-lg border-slate-300" type="file" name="other_documents[]" multiple></label>
            <label class="grid gap-2 text-sm font-semibold md:col-span-2">{{ $isFr ? 'Lettre de motivation' : 'Motivation letter' }}<textarea class="rounded-lg border-slate-300" rows="5" name="motivation"></textarea></label>
        </div>
        <button class="mt-6 rounded-full bg-emerald-700 px-6 py-3 font-bold text-white hover:bg-emerald-800">{{ $isFr ? 'Envoyer ma candidature' : 'Send application' }}</button>
    </form>
</section>
@endsection
