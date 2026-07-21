@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

<div class="country-card">

<h3 class="mb-4">

Edit Analysis Article

</h3>

<form
action="{{ route('admin.articles.update',$article) }}"
method="POST"
enctype="multipart/form-data">

@csrf

@method('PUT')

<div class="mb-3">

<label>Title</label>

<input
type="text"
name="title"
class="form-control"
value="{{ $article->title }}"
required>

</div>

<div class="mb-3">

<label>Category</label>

<input
type="text"
name="category"
class="form-control"
value="{{ $article->category }}"
required>

</div>

@if($article->image)

<div class="mb-3">

<img
src="{{ asset('storage/'.$article->image) }}"
width="200"
class="rounded">

</div>

@endif

<div class="mb-3">

<label>Replace Image</label>

<input
type="file"
name="image"
class="form-control">

</div>

<div class="mb-3">

<label>Content</label>

<textarea
name="content"
rows="12"
class="form-control"
required>{{ $article->content }}</textarea>

</div>

<button class="btn btn-pink">

Update

</button>

<a
href="{{ route('admin.articles.index') }}"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

@endsection