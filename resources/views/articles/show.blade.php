@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="articles-header">
        <div class="header-flex">
            <a href="{{ route('articles.index') }}" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1>News & Articles</h1>
        </div>
        <p>Stay updated with plastic waste issue in Indonesia</p>
    </div>

    <!-- Article Content -->
    <div class="article-detail">
        <article class="article-detail-card">
            <div class="article-detail-image">
                <img 
                    src="{{ $article['image'] }}"
                    alt="{{ $article['title'] }}"
                >
            </div>

            <div class="article-detail-body">
                <h1 class="article-detail-title">{{ $article['title'] }}</h1>

                <p class="article-detail-author">
                    By <span>{{ $article['author'] }}</span>
                </p>

                <div class="article-detail-content prose">
                    {{ $article['content'] }}
                </div>

                @if(!empty($article['url']))
                    <div class="article-source-link">
                        <a href="{{ $article['url'] }}" target="_blank">
                            Read full article on original source
                        </a>
                    </div>
                @endif
            </div>
        </article>
    </div>
@endsection