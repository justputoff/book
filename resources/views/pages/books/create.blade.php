@extends('layouts.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <h5 class="card-header">Create Book</h5>
    <div class="card-body">
      <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
          <label for="author" class="form-label">Author</label>
          <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="mb-3">
          <label for="isbn" class="form-label">ISBN</label>
          <input type="text" class="form-control" id="isbn" name="isbn" required>
        </div>
        <div class="mb-3">
          <label for="cover_image" class="form-label">Cover Image</label>
          <input type="file" class="form-control" id="cover_image" name="cover_image" required>
        </div>
        <div class="mb-3">
          <label for="page" class="form-label">Page</label>
          <input type="number" class="form-control" id="page" name="page" required>
        </div>
        <div class="mb-3">
          <label for="pdf" class="form-label">PDF</label>
          <input type="file" class="form-control" id="pdf" name="pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
<!-- / Content -->
@endsection
