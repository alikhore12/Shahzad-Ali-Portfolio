@extends('layouts.admin')

@section('title', 'Edit '.$service->name)
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="Edit service" eyebrow="Portfolio" subtitle="Update the service — changes go live as soon as you save." />

    @include('admin.services.form', ['action' => route('admin.services.update', $service), 'method' => 'PUT', 'service' => $service])
@endsection
