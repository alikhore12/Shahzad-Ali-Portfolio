@extends('layouts.admin')

@section('title', 'Add certification')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Add certification" eyebrow="Journey" subtitle="Add a certificate to your credentials." />

    @include('admin.certifications.form', ['action' => route('admin.certifications.store'), 'method' => null])
@endsection
