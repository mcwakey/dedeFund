@extends('public.layout')

@section('title', ($locale === 'fr' ? 'Faire un don' : 'Donate').' - DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-8">
    <div>
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $isFr ? 'Donation' : 'Donation' }}</p>
        <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Votre contribution soutient des projets concrets.' : 'Your contribution supports concrete projects.' }}</h1>
        <p class="mt-6 text-lg leading-8 text-slate-600">
            {{ $isFr ? 'Le paiement complet pourra etre active apres validation des comptes PayPal, carte ou banque. Pour le moment, cette page enregistre les intentions de don et informe les administrateurs.' : 'Full payment can be enabled after PayPal, card, or banking accounts are validated. For now, this page records donation intents for administrators.' }}
        </p>
        <div class="mt-8 rounded-lg border border-amber-200 bg-amber-50 p-5 text-sm leading-6 text-amber-950">
            <strong>{{ $isFr ? 'Moyens prevus :' : 'Planned methods:' }}</strong>
            PayPal, virement bancaire, Visa/Mastercard, Western Union, MoneyGram.
        </div>
    </div>
    <form method="POST" action="{{ route('donation.store', ['locale' => $locale]) }}" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <input type="hidden" name="currency" value="USD">
        <div class="grid gap-5 md:grid-cols-2">
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Nom complet' : 'Full name' }}<input class="rounded-lg border-slate-300" name="donor_name" value="{{ old('donor_name') }}" required></label>
            <label class="grid gap-2 text-sm font-semibold">Email<input class="rounded-lg border-slate-300" type="email" name="email" value="{{ old('email') }}" required></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Telephone' : 'Phone' }}<input class="rounded-lg border-slate-300" name="phone" value="{{ old('phone') }}"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Pays' : 'Country' }}<input class="rounded-lg border-slate-300" name="country" value="{{ old('country') }}"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Moyen de donation' : 'Donation method' }}
                <select class="rounded-lg border-slate-300" name="donation_method">
                    @foreach (['PayPal', 'Bank transfer', 'Visa/Mastercard', 'Western Union', 'MoneyGram'] as $method)
                        <option value="{{ $method }}">{{ $method }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Montant envisage' : 'Expected amount' }}<input class="rounded-lg border-slate-300" type="number" min="1" step="0.01" name="amount" value="{{ old('amount') }}"></label>
            <label class="grid gap-2 text-sm font-semibold md:col-span-2">{{ $isFr ? 'Projet a soutenir' : 'Project to support' }}
                <select class="rounded-lg border-slate-300" name="project_id">
                    <option value="">{{ $isFr ? 'Aucun projet specifique' : 'No specific project' }}</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @selected((string) request('project_id') === (string) $project->id)>{{ $project->localized('title', $locale) }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-2 text-sm font-semibold md:col-span-2">{{ $isFr ? 'Message' : 'Message' }}<textarea class="rounded-lg border-slate-300" rows="5" name="message">{{ old('message') }}</textarea></label>
        </div>
        <button class="mt-6 rounded-full bg-emerald-700 px-6 py-3 font-bold text-white hover:bg-emerald-800">{{ $isFr ? 'Envoyer mon intention' : 'Send my intent' }}</button>
    </form>
</section>
@endsection
