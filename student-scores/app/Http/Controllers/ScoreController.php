<?php

namespace App\Http\Controllers;

use App\Models\Scorename;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource with pagination and search.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Scorename::query();

        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        $students = $query->paginate(8);

        return view('scores.index', compact('students', 'keyword'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        Scorename::create($validated);

        return response()->json([
            'success' => true,
            'message' => '添加成功'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $student = Scorename::findOrFail($id);
        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => '更新成功'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Scorename::findOrFail($id);
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => '删除成功'
        ]);
    }
}
