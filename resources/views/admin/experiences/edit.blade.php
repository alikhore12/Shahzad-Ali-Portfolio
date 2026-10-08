@extends('layouts.admin')

@section('title', 'Edit experience')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Edit experience" eyebrow="Journey" subtitle="Update this timeline entry." />

    @include('admin.experiences.form', ['action' => route('admin.experiences.update', $experience), 'method' => 'PUT', 'experience' => $experience])
@endsection
