<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Package; // Import model Package
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        $books = Book::with('user', 'packages')->get(); // Memuat relasi package
        // dd($books);
        return view('pages.books.index', compact('books'));
    }

    // Menampilkan form pembuatan buku baru
    public function create()
    {
        $packages = Package::all(); // Mengambil semua package
        return view('pages.books.create', compact('packages'));
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:255',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page' => 'required|integer',
            'pdf' => 'required|mimes:pdf|max:10000',
            'packages_id' => 'required|exists:packages,id', // Validasi packages_id
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi payment_proof
        ]);

        $coverImagePath = $request->file('cover_image')->store('cover_images', 'public');
        $pdfPath = $request->file('pdf')->store('pdfs', 'public');
        $paymentProofPath = $request->file('payment_proof') ? $request->file('payment_proof')->store('payment_proofs', 'public') : null;

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'cover_image' => $coverImagePath,
            'page' => $request->page,
            'pdf' => $pdfPath,
            'user_id' => Auth::id(),
            'status' => 'pending', // Atur status default sesuai kebutuhan
            'packages_id' => $request->packages_id, // Menyimpan packages_id
            'payment_proof' => $paymentProofPath, // Menyimpan payment_proof
        ]);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    // Menampilkan form pengeditan buku
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $packages = Package::all(); // Mengambil semua package
        return view('pages.books.edit', compact('book', 'packages'));
    }

    // Memperbarui buku yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page' => 'required|integer',
            'pdf' => 'nullable|mimes:pdf|max:10000',
            'packages_id' => 'required|exists:packages,id', // Validasi packages_id
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi payment_proof
        ]);

        $book = Book::findOrFail($id);

        $book->title = $request->title;
        $book->author = $request->author;
        $book->isbn = $request->isbn;
        $book->page = $request->page;
        $book->packages_id = $request->packages_id; // Memperbarui packages_id

        if ($request->hasFile('cover_image')) {
            // Hapus cover image lama jika ada
            if ($book->cover_image) {
                Storage::delete('public/' . $book->cover_image);
            }
            $coverImagePath = $request->file('cover_image')->store('cover_images', 'public');
            $book->cover_image = $coverImagePath;
        }

        if ($request->hasFile('pdf')) {
            // Hapus PDF lama jika ada
            if ($book->pdf) {
                Storage::delete('public/' . $book->pdf);
            }
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
            $book->pdf = $pdfPath;
        }

        if ($request->hasFile('payment_proof')) {
            // Hapus bukti pembayaran lama jika ada
            if ($book->payment_proof) {
                Storage::delete('public/' . $book->payment_proof);
            }
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            $book->payment_proof = $paymentProofPath;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    // Menghapus buku
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Hapus cover image dan PDF jika ada
        if ($book->cover_image) {
            Storage::delete('public/' . $book->cover_image);
        }
        if ($book->pdf) {
            Storage::delete('public/' . $book->pdf);
        }
        if ($book->payment_proof) {
            Storage::delete('public/' . $book->payment_proof);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    // Memperbarui status buku
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $book = Book::findOrFail($id);
        $book->status = $request->status;
        $book->save();

        return redirect()->route('books.index')->with('success', 'Book status updated successfully.');
    }

    // Menampilkan daftar buku
    public function list()
    {
        $books = Book::all();
        return view('pages.books.list', compact('books'));
    }
}
