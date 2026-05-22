@extends('public.layout')

@section('title', 'Contact - DedeFund')

@section('content')
@php($isFr = $locale === 'fr')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-8">
    <div>
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">Contact</p>
        <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $isFr ? 'Parlons de votre contribution.' : 'Let us talk about your contribution.' }}</h1>
        <div class="mt-8 rounded-lg border border-slate-200 bg-white p-6 text-sm leading-7 shadow-sm">
            <strong>DedeFund</strong><br>
            897 Middle River RD, Middle River, MD 21220, USA<br>
            +1 240 353 8332<br>
            info@dedefund.org<br>
            dedeusca@gmail.com
        </div>
    </div>
    <form method="POST" action="{{ route('contact.store', ['locale' => $locale]) }}" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        <input type="hidden" name="context" value="general">
        <div class="grid gap-5 md:grid-cols-2">
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Nom complet' : 'Full name' }}<input class="rounded-lg border-slate-300" name="full_name" required></label>
            <label class="grid gap-2 text-sm font-semibold">Email<input class="rounded-lg border-slate-300" type="email" name="email" required></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Telephone' : 'Phone' }}<input class="rounded-lg border-slate-300" name="phone"></label>
            <label class="grid gap-2 text-sm font-semibold">{{ $isFr ? 'Sujet' : 'Subject' }}<input class="rounded-lg border-slate-300" name="subject"></label>
            <label class="grid gap-2 text-sm font-semibold md:col-span-2">{{ $isFr ? 'Message' : 'Message' }}<textarea class="rounded-lg border-slate-300" rows="6" name="message" required></textarea></label>
        </div>
        <button class="mt-6 rounded-full bg-emerald-700 px-6 py-3 font-bold text-white hover:bg-emerald-800">{{ $isFr ? 'Envoyer' : 'Send' }}</button>
    </form>
</section>
@endsection
