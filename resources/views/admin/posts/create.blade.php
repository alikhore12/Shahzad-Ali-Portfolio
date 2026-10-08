@extends('layouts.admin')

@section('title', 'New post')
@section('eyebrow', 'Content')

@section('content')
    <x-admin.page-head title="New post" eyebrow="Content" subtitle="Start as a draft, publish when you are ready." />

    @include('admin.posts.form', ['action' => route('admin.posts.store'), 'method' => null])
@endsection
