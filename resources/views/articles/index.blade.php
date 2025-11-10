@extends('layouts.app')
@section('title', 'Articles')

@section('content')
<h1 class="mb-4">Articles</h1>
<a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">+ New Article</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Summary</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($articles as $article)
        <tr>
            <td>{{ $article->id }}</td>
            <td>{{ Str::limit($article->title, 40) }}</td>
            <td>{{ Str::limit($article->summary, 60) }}</td>
            <td>
                <a href="{{ route('articles.show', $article) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-warning">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection