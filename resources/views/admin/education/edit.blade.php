@extends('layouts.admin')

@section('title', 'Edit education')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Edit education" eyebrow="Journey" subtitle="Update this education entry." />

    @include('admin.education.form', ['action' => route('admin.education.update', $education), 'method' => 'PUT', 'education' => $education])
@endsection
