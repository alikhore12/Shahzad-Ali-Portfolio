@extends('layouts.admin')

@section('title', 'Edit testimonial')
@section('eyebrow', 'Content')

@section('content')
    <x-admin.page-head title="Edit testimonial" eyebrow="Content" subtitle="Update this quote." />

    @include('admin.testimonials.form', ['action' => route('admin.testimonials.update', $testimonial), 'method' => 'PUT', 'testimonial' => $testimonial])
@endsection
