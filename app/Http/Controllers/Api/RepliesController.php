<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Models\Reply;
use App\Http\Requests\Api\ReplyRequest;
use App\Transformers\ReplyTransformer;

class RepliesController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function store(ReplyRequest $request,Topic $topic, Reply $reply)
    {

        $reply->content = $request->content;
        $reply->topic_id = $topic->id;
        $reply->user_id = $this->user()->id;
        $reply->save();
//        $reply->create(['content'=>'回复内容','topic_id'=>'1','user_id'=>'13']);
        return $this->response->item($reply, new ReplyTransformer())
            ->setStatusCode(201);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', '成功删除回复！');
    }
}
