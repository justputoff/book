@extends('layouts.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <h5 class="card-header">Edit Book</h5>
    <div class="card-body">
      <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required>
        </div>
        <div class="mb-3">
          <label for="author" class="form-label">Author</label>
          <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required>
        </div>
        <div class="mb-3">
          <label for="isbn" class="form-label">ISBN</label>
          <input type="text" class="form-control" id="isbn" name="isbn" value="{{ $book->isbn }}" required>
        </div>
        <div class="mb-3">
          <label for="cover_image" class="form-label">Cover Image</label>
          <input type="file" class="form-control" id="cover_image" name="cover_image">
          @if ($book->cover_image)
            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" width="100" class="mt-2">
          @endif
        </div>
        <div class="mb-3">
          <label for="page" class="form-label">Page</label>
          <input type="number" class="form-control" id="page" name="page" value="{{ $book->page }}" required>
        </div>
        <div class="mb-3">
          <label for="pdf" class="form-label">PDF</label>
          <input type="file" class="form-control" id="pdf" name="pdf">
          @if ($book->pdf)
            <a href="{{ Storage::url($book->pdf) }}" target="_blank" class="d-block mt-2">Current PDF</a>
          @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
<!-- / Content -->
@endsection
