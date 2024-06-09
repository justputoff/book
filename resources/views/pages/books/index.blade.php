@extends('layouts.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm">Create</a>
    </div>
  </div>
  <div class="card mt-2">
    <h5 class="card-header">Table Books</h5>
    <div class="table-responsive text-nowrap p-3">
      <table class="table" id="example">
        <thead>
          <tr class="text-nowrap table-dark">
            <th class="text-white">No</th>
            <th class="text-white">Title</th>
            <th class="text-white">Author</th>
            <th class="text-white">ISBN</th>
            <th class="text-white">Cover Image</th>
            <th class="text-white">Page</th>
            <th class="text-white">User</th>
            <th class="text-white">PDF</th>
            <th class="text-white">Status</th>
            <th class="text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($books as $book)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->isbn }}</td>
            <td><a href="{{ Storage::url($book->cover_image) }}" target="_blank">View Cover</a></td>
            <td>{{ $book->page }}</td>
            <td>{{ $book->user->name }}</td>
            <td><a href="{{ Storage::url($book->pdf) }}" target="_blank">Download PDF</a></td>
            <td>{{ $book->status }}</td>
            <td>
              <div class="d-flex flex-wrap">
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm me-1 mb-1">Edit</a>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline me-1 mb-1">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                @if (Auth::user()->role->name == 'admin')
                  <form action="{{ route('books.updateStatus', $book->id) }}" method="POST" class="d-inline me-1 mb-1">
                    @csrf
                    @method('PATCH')
                    <div class="input-group input-group-sm">
                      <select name="status" class="form-select form-select-sm">
                        <option value="pending" {{ $book->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ $book->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ $book->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                      </select>
                      <button type="submit" class="btn btn-info btn-sm">Update</button>
                    </div>
                  </form>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- / Content -->
@endsection
