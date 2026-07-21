@extends('layouts.dashboard')

@section('content')

<div class="dashboard-container">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h3 class="fw-bold mb-1">Analysis Articles</h3>

            <p class="text-secondary mb-0">
                Manage analysis articles.
            </p>

        </div>

        <a href="{{ route('admin.articles.create') }}"
           class="btn btn-pink">

            <i class="bi bi-plus-circle me-1"></i>

            Add Article

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="country-card">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th width="60">No</th>
                    <th width="120">Image</th>
                    <th>Title</th>
                    <th width="180">Category</th>
                    <th width="180">Created</th>
                    <th width="170">Action</th>

                </tr>

            </thead>

            <tbody>

            @forelse($articles as $article)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        @if($article->image)

                            <img
                                src="{{ asset('storage/'.$article->image) }}"
                                width="100"
                                class="rounded">

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        {{ $article->title }}

                    </td>

                    <td>

                        {{ $article->category }}

                    </td>

                    <td>

                        {{ $article->created_at->format('d M Y') }}

                    </td>

                    <td>

                        <a href="{{ route('admin.articles.edit',$article) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form
                            action="{{ route('admin.articles.destroy',$article) }}"
                            method="POST"
                            class="d-inline">

                            @csrf

                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this article?')">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center">

                        No articles found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection