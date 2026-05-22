@extends('public.layout')

@section('title', ($locale === 'fr' ? 'Volontariat' : 'Volunteer').' - DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-8">
    <div>
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Amis et volontaires' : 'Friends and volunteers' }}</p>
        <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Mettez vos competences au service de l impact.' : 'Put your skills to work for impact.' }}</h1>
        <p class="mt-6 text-lg leading-8 text-slate-600">{{ $isFr ? 'Rejoignez DedeFund comme ami, volontaire, cooperant ou personne ressource.' : 'Join DedeFund as a friend, volunteer, partner, or resource person.' }}</p>
    </div>
    <form method="POST" enctype="multipart/form-data" action="{{ route('volunteer.store', ['locale' => $locale]) }}" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <div class="grid gap-5 md:grid-cols-2">
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Nom complet' : 'Full name' }}<input class="rounded-lg border-slate-300" name="full_name" required></label>
            <label class="grid gap-2 text-sm font-semibold">Email<input class="rounded-lg border-slate-300" type="email" name="email" required></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Telephone' : 'Phone' }}<input class="rounded-lg border-slate-300" name="phone"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Pays' : 'Country' }}<input class="rounded-lg border-slate-300" name="country"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Ville' : 'City' }}<input class="rounded-lg border-slate-300" name="city"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Contribution souhaitee' : 'Desired contribution' }}<input class="rounded-lg border-slate-300" name="contribution_type"></label>
            <label class="grid gap-2 text-sm font-semibold md:col-span-2">{{ $isFr ? 'Competences' : 'Skills' }}<textarea class="rounded-lg border-slate-300" rows="4" name="skills"></textarea></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Disponibilite' : 'Availability' }}<input class="rounded-lg border-slate-300" name="availability"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Documents' : 'Documents' }}<input class="rounded-lg border-slate-300" type="file" name="documents[]" multiple></label>
            <label class="grid gap-2 text-sm font-semibold md:col-span-2">{{ $isFr ? 'Message' : 'Message' }}<textarea class="rounded-lg border-slate-300" rows="5" name="message"></textarea></label>
        </div>
        <button class="mt-6 rounded-full bg-emerald-700 px-6 py-3 font-bold text-white hover:bg-emerald-800">{{ $isFr ? 'Envoyer ma candidature' : 'Send application' }}</button>
    </form>
</section>
@endsection
