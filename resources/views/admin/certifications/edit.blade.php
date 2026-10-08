@extends('layouts.admin')

@section('title', 'Edit certification')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Edit certification" eyebrow="Journey" subtitle="Update this credential." />

    @include('admin.certifications.form', ['action' => route('admin.certifications.update', $certification), 'method' => 'PUT', 'certification' => $certification])
@endsection
