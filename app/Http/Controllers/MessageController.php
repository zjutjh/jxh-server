<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * 创建消息推送
     */
    public function create(Request $request) {
        $title = $request->get('title');
        $informer = $request->get('informer');
        $content=  $request->get('content');

        $message = new Message();
        $message->title = $title;
        $message->informer = $informer;
        $message->content = $content;
        $message->save();
        return RJM(null, 1, '保存成功');
    }

    /**
     * 发送模版消息
     */
    public function sendMessage(Request $request) {
        $message_id = $request->get('id');
        $message = Message::where('id', $message_id)->first();


    }

    /**
     * 更新消息
     */
    public function update(Request $request) {
        $id = $request->get('id');
        $title = $request->get('title');
        $informer = $request->get('informer');
        $content=  $request->get('content');

        $message = Message::where('id', $id)->first();
        $message->title = $title;
        $message->informer = $informer;
        $message->content = $content;
        $message->save();
        return RJM(null, 1, '保存成功');
    }


    public function show($id) {
        $message = Message::where('id', $id)->first();
        $message->view = ++$message->view;
        $message->save();
        return view('jxh.show', ['messaeg' => $message]);
    }


}