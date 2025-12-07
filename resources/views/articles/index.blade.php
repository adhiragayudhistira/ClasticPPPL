@extends('layouts.app')

@section('title', 'News & Articles - Clastic')

@section('content')
    <!-- Header -->
    <div class="articles-header">
        <div class="header-flex">
            <h1>News & Articles</h1>
        </div>
        <p>Stay updated with plastic waste issue in Indonesia</p>
    </div>

    <!-- Articles List -->
    <div class="articles-list">
        @forelse($articles as $article)
            <a href="{{ route('articles.show', $article['id']) }}" class="article-card">
                <div class="article-card-image">
                    <img 
                        src="{{ $article['image'] }}" 
                        alt="{{ $article['title'] }}"
                        style="object-position: {{ $loop->iteration == 2 ? 'center 30%' : ($loop->iteration == 4 ? 'center 20%' : 'center center') }};"
                    >
                </div>

                <div class="article-card-content">
                    <h3 class="article-card-title">{{ $article['title'] }}</h3>
                    <p class="article-card-excerpt">{{ $article['excerpt'] }}</p>
                    <div class="article-card-footer">
                        <span class="article-card-author">By {{ $article['author'] }}</span>
                        <span class="article-card-read">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Read article
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon"></div>
                <p class="empty-state-title">No articles available at the moment</p>
                <p class="empty-state-subtitle">Please check back later!</p>
            </div>
        @endforelse
    </div>
@endsection