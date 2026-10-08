@extends('layouts.admin')

@section('title', 'Add experience')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Add experience" eyebrow="Journey" subtitle="Add a role to your public timeline." />

    @include('admin.experiences.form', ['action' => route('admin.experiences.store'), 'method' => null])
@endsection
