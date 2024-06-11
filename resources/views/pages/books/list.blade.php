@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="mb-4">Book List</h1>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        @foreach($books as $book)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <img src="{{ Storage::url($book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text">Author: {{ $book->author }}</p>
                    <p class="card-text">ISBN: {{ $book->isbn }}</p>
                    <p class="card-text">Pages: {{ $book->page }}</p>
                    <a href="{{ Storage::url($book->pdf) }}" class="btn btn-primary mt-4">See Book</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
