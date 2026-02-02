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
            'file' => 'nullable|file|mimes:png,jpg,jpeg,pdf,doc,docx|max:5120', // 5MB max
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('feedback', 'public');
        }

        Feedback::create([
            'user_id' => Auth::id(),
            'isi_feedback' => $request->isi_feedback,
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }

    // History feedback user
    public function history()
    {
        $feedbacks = Feedback::where('user_id', Auth::id())->orderBy('created_at', 'asc')->get();
        return view('user.feedback.history', compact('feedbacks'));
    }

    // Update feedback
    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        
        // Pastikan feedback milik user yang login
        if ($feedback->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'isi_feedback' => 'required|string|min:5',
            'file' => 'nullable|file|mimes:png,jpg,jpeg,pdf,doc,docx|max:5120',
        ]);

        $filePath = $feedback->file_path; // Keep existing file
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($filePath && \Storage::disk('public')->exists($filePath)) {
                \Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('feedback', 'public');
        }

        $feedback->update([
            'isi_feedback' => $request->isi_feedback,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil diperbarui!');
    }

    // Delete feedback
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        
        \Log::info('Destroy feedback called', ['feedback_id' => $feedback->id, 'user_id' => $feedback->user_id, 'auth_id' => Auth::id()]);
        
        // Pastikan feedback milik user yang login
        if ($feedback->user_id !== Auth::id()) {
            \Log::warning('Unauthorized delete attempt', ['feedback_user' => $feedback->user_id, 'auth_user' => Auth::id()]);
            abort(403, 'Unauthorized');
        }

        // Delete file if exists
        if ($feedback->file_path && \Storage::disk('public')->exists($feedback->file_path)) {
            \Storage::disk('public')->delete($feedback->file_path);
        }

        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback berhasil dihapus!');
    }

    // Tampilan untuk Admin melihat rekap
    public function adminIndex()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(10);
        
        // Total feedback
        $totalFeedback = Feedback::count();
        
        // Extract keywords for word cloud
        $feedbackTexts = Feedback::pluck('isi_feedback')->toArray();
        $wordCloud = $this->extractKeywords($feedbackTexts);
        
        // Top word (first one)
        $topWord = count($wordCloud) > 0 ? $wordCloud[0] : ['word' => 'Infrastruktur', 'count' => 0];
        
        // All words for grid
        $topWords = $wordCloud;
        
        // Get most common category/keyword
        $kategoriUtama = count($wordCloud) > 0 ? $wordCloud[0]['word'] : 'Infrastruktur';
        
        return view('admin.evaluasi.index', compact('feedbacks', 'totalFeedback', 'topWord', 'topWords', 'kategoriUtama'));
    }

    // Update feedback status (untuk admin)
    public function updateStatus(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai'
        ]);
        
        $feedback->update([
            'status' => $request->status
        ]);
        
        return response()->json(['success' => true, 'message' => 'Status berhasil diubah']);
    }

    // Extract keywords from text untuk word cloud
    private function extractKeywords($texts)
    {
        $stopwords = ['dan', 'atau', 'yang', 'dari', 'untuk', 'ke', 'di', 'pada', 'dengan', 'adalah', 'ini', 'itu', 'dalam', 'akan', 'telah', 'dapat', 'ada', 'juga', 'oleh', 'karena', 'saat', 'sudah', 'tidak', 'lebih', 'lagi'];
        
        $words = [];
        
        foreach ($texts as $text) {
            // Split text to words
            $textWords = preg_split('/\s+/', strtolower($text));
            
            foreach ($textWords as $word) {
                // Remove punctuation
                $word = preg_replace('/[^\p{L}\p{N}]/u', '', $word);
                
                // Skip short words and stopwords
                if (strlen($word) > 3 && !in_array($word, $stopwords)) {
                    $words[$word] = ($words[$word] ?? 0) + 1;
                }
            }
        }
        
        // Sort by frequency
        arsort($words);
        
        // Convert to array format
        $result = [];
        foreach (array_slice($words, 0, 15) as $word => $count) {
            $result[] = ['word' => ucfirst($word), 'count' => $count];
        }
        
        return $result;
    }
}