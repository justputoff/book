<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Package; // Import model Package
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class BookController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        // dd('a');
        $books = Book::with('user', 'package')->get(); // Memuat relasi package
        return response()->json([
            'data' => $books,
            'message' => 'success',
            'code' => 200
        ], 200);
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
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

            $book = Book::create([
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

            DB::commit();

            return response()->json([
                'data' => $book,
                'message' => 'Book created successfully.',
                'code' => 201
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'message' => 'Failed to create book: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    // Menampilkan detail buku
    public function show($id)
    {
        $book = Book::with('user', 'package')->findOrFail($id); // Memuat relasi package
        return response()->json([
            'data' => $book,
            'message' => 'success',
            'code' => 200
        ], 200);
    }

    // Memperbarui buku yang ada
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
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

            DB::commit();

            return response()->json([
                'data' => $book,
                'message' => 'Book updated successfully.',
                'code' => 200
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'message' => 'Failed to update book: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    // Menghapus buku
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $book = Book::findOrFail($id);

            // Hapus cover image, PDF, dan bukti pembayaran jika ada
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

            DB::commit();

            return response()->json([
                'data' => null,
                'message' => 'Book deleted successfully.',
                'code' => 204
            ], 204);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'message' => 'Failed to delete book: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    // Memperbarui status buku
    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|in:pending,accepted,rejected',
            ]);

            $book = Book::findOrFail($id);
            $book->status = $request->status;
            $book->save();

            DB::commit();

            return response()->json([
                'data' => $book,
                'message' => 'Book status updated successfully.',
                'code' => 200
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'message' => 'Failed to update book status: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
}
