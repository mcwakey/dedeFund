@extends('public.layout')

@php($translation = $post->translation($locale))
@section('title', $translation?->title.' - DedeFund')
@section('meta_description', $translation?->meta_description ?? $translation?->summary)

@section('content')
@php($isFr = $locale === 'fr')
<article class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
    <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">{{ $post->category?->localized('name', $locale) }}</p>
    <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-950">{{ $translation?->title }}</h1>
    <p class="mt-4 text-sm text-slate-500">{{ optional($post->published_at)->format('M d, Y') }}</p>
    <img class="mt-8 aspect-[16/9] w-full rounded-lg object-cover" src="{{ $post->featured_image }}" alt="{{ $translation?->title }}">
    <div class="prose prose-slate mt-10 max-w-none">
        <p>{{ $translation?->summary }}</p>
        {!! nl2br(e($translation?->content)) !!}
    </div>
    <a class="mt-10 inline-flex font-bold text-emerald-700" href="{{ route('blog.index', ['locale' => $locale]) }}">{{ $isFr ? 'Retour au blog' : 'Back to blog' }}</a>
</article>
@endsection
