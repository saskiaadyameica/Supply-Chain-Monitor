@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="fw-bold">News Intelligence</h1>
        <p class="text-secondary">
            Latest logistics, trade, shipping, and economy news.
        </p>
    </div>

    <form action="{{ route('news.index') }}" method="GET" class="row g-3 mb-4">

        <div class="col-md-5">
            <input
                type="text"
                class="form-control"
                name="keyword"
                placeholder="Country / Keyword"
                value="{{ $keyword }}">
        </div>

        <div class="col-md-5">
            <select class="form-select" name="category">

                @foreach(['Logistics','Trade','Shipping','Economy'] as $item)

                    <option
                        value="{{ $item }}"
                        {{ $category == $item ? 'selected' : '' }}>
                        {{ $item }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="col-md-2">
            <button
                class="btn w-100 text-white"
                style="background:#d88ca2;">
                Search
            </button>
        </div>

    </form>

    @php
        $overall = 'Neutral';

        if ($positivePercent > $negativePercent && $positivePercent > $neutralPercent) {
            $overall = 'Positive';
        } elseif ($negativePercent > $positivePercent && $negativePercent > $neutralPercent) {
            $overall = 'Negative';
        }
    @endphp

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-1">News Sentiment Analysis</h5>
            <p class="text-muted mb-0">
                Overall Sentiment :
                <strong>{{ $overall }}</strong>
            </p>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-start border-success border-4">
                <div class="card-body text-center">
                    <h6 class="text-muted">Positive</h6>
                    <h2 class="text-success">{{ $positivePercent }}%</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-start border-secondary border-4">
                <div class="card-body text-center">
                    <h6 class="text-muted">Neutral</h6>
                    <h2 class="text-secondary">{{ $neutralPercent }}%</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-start border-danger border-4">
                <div class="card-body text-center">
                    <h6 class="text-muted">Negative</h6>
                    <h2 class="text-danger">{{ $negativePercent }}%</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        @forelse($articles as $article)

            <div class="col-lg-6 mb-4">

                <div class="card shadow-sm h-100">

                    @if(!empty($article['image']))
                        <img
                            src="{{ $article['image'] }}"
                            class="card-img-top"
                            style="height:220px; object-fit:cover;">
                    @endif

                    <div class="card-body">

                        @if($article['sentiment'] == 'Positive')
                            <span class="badge bg-success mb-2">
                                Positive
                            </span>

                        @elseif($article['sentiment'] == 'Negative')
                            <span class="badge bg-danger mb-2">
                                Negative
                            </span>

                        @else
                            <span class="badge bg-secondary mb-2">
                                Neutral
                            </span>
                        @endif

                        <h5 class="fw-semibold">
                            {{ $article['title'] }}
                        </h5>

                        <small class="text-muted">
                            {{ $article['source']['name'] }}
                            •
                            {{ date('d M Y', strtotime($article['publishedAt'])) }}
                        </small>

                        <p class="mt-3">
                            {{ $article['description'] }}
                        </p>

                        <hr>

                        <div class="d-flex justify-content-between">

                            <small class="text-success">
                                Positive Score :
                                <strong>{{ $article['positive_score'] }}</strong>
                            </small>

                            <small class="text-danger">
                                Negative Score :
                                <strong>{{ $article['negative_score'] }}</strong>
                            </small>

                        </div>

                    </div>

                    <div class="card-footer bg-white border-0">

                        <a
                            href="{{ $article['url'] }}"
                            target="_blank"
                            class="btn btn-outline-primary w-100">

                            Read More

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-warning">
                    No news found.
                </div>
            </div>

        @endforelse

    </div>

</div>

@endsection