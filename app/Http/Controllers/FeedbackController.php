<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all();

        return view('feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        Feedback::create([

            'pemberi_feedback' => $request->pemberi_feedback,
            'penerima_feedback' => $request->penerima_feedback,

            'feedback' => $request->feedback,
            'status' => $request->status,

        ]);

        return redirect('/feedback')
            ->with('success', 'Feedback berhasil ditambahkan');
    }

    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('feedback.edit', compact('feedback'));
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $feedback->update([

            'pemberi_feedback' => $request->pemberi_feedback,
            'penerima_feedback' => $request->penerima_feedback,

            'feedback' => $request->feedback,
            'status' => $request->status,

        ]);

        return redirect('/feedback')
            ->with('success', 'Feedback berhasil diupdate');
    }

    public function destroy($id)
    {
        Feedback::findOrFail($id)->delete();

        return redirect('/feedback')
            ->with('success', 'Feedback berhasil dihapus');
    }
}