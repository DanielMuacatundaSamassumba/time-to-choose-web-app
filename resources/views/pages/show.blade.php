@extends('layouts.app')

@section('title', $page->title)

@section('meta_description', $page->meta_desc ?? '')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-4">{{ $page->title }}</h1>
        <div class="prose lg:prose-xl">
            {!! $page->content !!}
        </div>
    </div>
@endsection
