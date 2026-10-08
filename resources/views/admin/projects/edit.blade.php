@extends('layouts.admin')

@section('title', 'Edit '.$project->name)
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="Edit project" eyebrow="Portfolio" subtitle="Update the case study — changes go live as soon as you save." />

    @include('admin.projects.form', ['action' => route('admin.projects.update', $project), 'method' => 'PUT', 'project' => $project])
@endsection
