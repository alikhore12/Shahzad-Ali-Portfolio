@extends('layouts.admin')

@section('title', 'Add skill')
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="Add skill" eyebrow="Portfolio" subtitle="New skills show up on your public skills page once published." />

    @include('admin.skills.form', ['action' => route('admin.skills.store'), 'method' => null])
@endsection
