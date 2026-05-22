@extends('public.layout')

@section('title', $title.' - DedeFund')

@section('content')
<section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-black tracking-tight text-slate-950">{{ $title }}</h1>
    <p class="mt-6 text-lg leading-8 text-slate-600">{{ $body }}</p>
</section>
@endsection
