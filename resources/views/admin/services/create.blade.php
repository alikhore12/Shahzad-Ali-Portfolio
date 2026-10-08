@extends('layouts.admin')

@section('title', 'Add service')
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="Add service" eyebrow="Portfolio" subtitle="New services show up on your public services page once published." />

    @include('admin.services.form', ['action' => route('admin.services.store'), 'method' => null])
@endsection
