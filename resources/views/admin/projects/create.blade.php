@extends('layouts.admin')

@section('title', 'New project')
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="New project" eyebrow="Portfolio" subtitle="Add a case study — you can save it as a draft and publish later." />

    @include('admin.projects.form', ['action' => route('admin.projects.store'), 'method' => null])
@endsection
