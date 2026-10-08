@extends('layouts.admin')

@section('title', 'Edit '.$post->title)
@section('eyebrow', 'Content')

@section('content')
    <x-admin.page-head title="Edit post" eyebrow="Content" subtitle="Update the article — changes go live as soon as you save." />

    @include('admin.posts.form', ['action' => route('admin.posts.update', $post), 'method' => 'PUT', 'post' => $post])
@endsection
