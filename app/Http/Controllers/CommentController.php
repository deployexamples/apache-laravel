<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getAllComment()
    {
        try {
            $comments = Comment::get(['id','comment','created_by']);
            return response()->json([
                'status' => 1,
                'data' => $comments
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getComment($id)
    {
        // dd($id);
        try{
            $comments = Comment::where('question_id',$id)->get(['id','comment','created_by']);
            return response()->json([
                'status' => 1,
                'data' => $comments
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
    

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $userComment = new Comment();
            $userComment->question_id = $request->get('question_id');
            $userComment->comment = $request->get('comment');
            $userComment->created_by = $request->get('created_by');
            $userComment->save();
            return response()->json([
                'status' => 1,
                'message' => 'comment inserted.'
            ]);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
