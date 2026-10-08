@extends('layouts.admin')

@section('title', 'Edit '.$skill->name)
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="Edit skill" eyebrow="Portfolio" subtitle="Update the skill — changes go live as soon as you save." />

    @include('admin.skills.form', ['action' => route('admin.skills.update', $skill), 'method' => 'PUT', 'skill' => $skill])
@endsection
