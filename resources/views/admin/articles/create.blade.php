@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="country-card">

        <h3 class="mb-4">
            Add Analysis Article
        </h3>

        <a href="{{ route('admin.articles.create',['import'=>1]) }}"
        class="btn btn-primary mb-3">

        Import Latest News

        </a>

        <form
            action="{{ route('admin.articles.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-3">

                <label>Title</label>

                <input
                type="text"
                name="title"
                class="form-control"
                value="{{ old('title', $news['title'] ?? '') }}"
                required>

            </div>

            <div class="mb-3">

                <label>Category</label>

                <input
                type="text"
                name="category"
                class="form-control"
                value="{{ old('category','News') }}"
                required>

            </div>

            <div class="mb-3">

                <label>Image</label>

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
                required>{{ old('content', $news['description'] ?? '') }}</textarea>

            </div>

            <button class="btn btn-pink">
                Save
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