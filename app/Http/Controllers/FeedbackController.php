<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Tampilan untuk User mengisi feedback
    public function index()
    {
        return view('user.feedback.index');
    }

    // Menyimpan feedback ke database
    public function store(Request $request)
    {
        $request->validate([
            'isi_feedback' => 'required|string|min:5',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'isi_feedback' => $request->isi_feedback,
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }

    // Tampilan untuk Admin melihat rekap
    public function adminIndex()
    {
        $feedbacks = Feedback::with('user')->latest()->get();
        return view('feedback.admin', compact('feedbacks'));
    }
}