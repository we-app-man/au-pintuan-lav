<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $comments = Comment::where('user_id', $user->id)->orderBy('created_at','desc')->with('group')->get();

        return response()->json(compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = $request->user();
        $user_id = $user->id;
        $alias = $user->nickname;
        $avatar = $user->avatar;
        $group_id = $request->group_id;
        $commentInfo = $request->comment;

        $comment = Comment::where(['group_id'=>$group_id,'user_id'=>$user_id])->first();

//        dd($comment_has);
        if($comment){

            $comment->comment = $commentInfo;

            $comment->save();

            $message = "更新成功";

            return response()->json(compact('comment','message'));
        }

        $count = Comment::where('group_id',$group_id)->count();

        $comment = new Comment;

        $comment->index = $count+1;
        $comment->group_id = $group_id;
        $comment->comment = $commentInfo;
        $comment->user_id = $user_id;
        $comment->alias = $alias;
        $comment->avatar = $avatar;

        $comment->save();

        $message = "发布成功";

        return response()->json(compact('comment','message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments = Comment::where('group_id',$id)->orderBy('created_at','desc')->get();

        return response()->json(compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
