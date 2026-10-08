@extends('layouts.admin')

@section('title', 'Add testimonial')
@section('eyebrow', 'Content')

@section('content')
    <x-admin.page-head title="Add testimonial" eyebrow="Content" subtitle="Add a quote — it appears on your site once published." />

    @include('admin.testimonials.form', ['action' => route('admin.testimonials.store'), 'method' => null])
@endsection
