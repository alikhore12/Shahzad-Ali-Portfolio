@extends('layouts.admin')

@section('title', 'Add education')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Add education" eyebrow="Journey" subtitle="Add a degree or course to your background." />

    @include('admin.education.form', ['action' => route('admin.education.store'), 'method' => null])
@endsection
