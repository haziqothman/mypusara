<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Feedback; // Jangan import model Feedback dulu

class FeedbackController extends Controller
{
    public function index()
    {
        // Buat dummy data feedback
        $feedbacks = [
            (object) ['id' => 1, 'name' => 'John Doe', 'message' => 'This is a great service!'],
            (object) ['id' => 2, 'name' => 'Jane Smith', 'message' => 'I had a wonderful experience.'],
            (object) ['id' => 3, 'name' => 'Peter Jones', 'message' => 'Could be better, but overall satisfied.'],
        ];

        // Kirim data dummy ke view
        return view('feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        // Tampilkan form pembuatan feedback (masih dummy, belum simpan ke database)
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        // Simulasi penyimpanan feedback (belum ke database)
        // Di sini Anda bisa menampilkan pesan sukses atau error seolah-olah data disimpan
        return redirect()->route('customer.feedback.index')->with('success', 'Feedback created successfully (Dummy).');
    }

    public function show()
    {
        // Buat dummy data untuk detail feedback berdasarkan ID
        $feedback = [
            1 => (object) ['id' => 1, 'name' => 'John Doe', 'message' => 'This is a great service!', 'created_at' => now(), 'updated_at' => now()],
            2 => (object) ['id' => 2, 'name' => 'Jane Smith', 'message' => 'I had a wonderful experience.', 'created_at' => now(), 'updated_at' => now()],
            3 => (object) ['id' => 3, 'name' => 'Peter Jones', 'message' => 'Could be better, but overall satisfied.', 'created_at' => now(), 'updated_at' => now()],
        ];

        // $feedback = $dummyFeedbacks["id"] ?? null; // Ambil data berdasarkan ID, atau null jika tidak ada

        if (!$feedback) {
            abort(404); // Tampilkan error 404 jika feedback tidak ditemukan
        }

        return view('feedback.show', compact('feedback'));
    }
}