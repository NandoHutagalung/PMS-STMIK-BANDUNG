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
            'pegawai' => $request->pegawai,
            'jabatan' => $request->jabatan,
            'feedback' => $request->feedback,
            'status' => $request->status,
        ]);

        return redirect('/feedback');
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
            'pegawai' => $request->pegawai,
            'jabatan' => $request->jabatan,
            'feedback' => $request->feedback,
            'status' => $request->status,
        ]);

        return redirect('/feedback');
    }

    public function destroy($id)
    {
        Feedback::findOrFail($id)->delete();

        return redirect('/feedback');
    }
}