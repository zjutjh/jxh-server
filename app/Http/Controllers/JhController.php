<?php

namespace App\Http\Controllers;

use App\Message;
use App\Notifications\TemplateMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class JhController extends Controller
{
    public function sendMsResult(Request $request)
    {
        $stuCsv = $request->file('csv');
        $id = $request->get('id');
        $file = fopen($stuCsv->getRealPath(), 'r');
        $stuArr = [];
        while ($data = fgetcsv($file)) {
            $stuArr [] = $data;
        }
        $message = Message::where('id', $id)->first();
        $config = [
            'template_id' => config('templatemsg.message.template_id'),
            // todo url
            'url' => url('message/show', [$id]),
            'data' => [
                'first' => [$message->title, '#05328E'],
                'keyword1' => '浙江工业大学',
                'keyword2' => $message->informer,
                'keyword3' => date('Y-m-d H:i:s', time()),
                'keyword4' => [$message->notify_content, '#4D0015'],
                'remark' => '点击查看详情'
            ]
        ];

        foreach ($stuArr as $k) {
            $user = User::where('sid', $k[0])->first();
            if (!!!$user)
                $user->notify(new TemplateMessage($config));
        }

        return RJM(null, 1, '已经全部发送');

    }

    /**
     * 确定参加笔试
     */
    public function sureGoBs()
    {
        $openid = session('openid');
        $user = User::where('openid', $openid)->first();
        Redis::sadd('ms2020', $user->sid);
        return view('jxh.success', ['content' => '已经确定你参加笔试']);
    }


    public function wxRedirect(Request $request)
    {
        return app('wechat')->oauth->setRequest($request)->redirect('http://jxh.jh.zjut.edu.cn/ms/sure');
    }


    public function getSureNum()
    {
        $lists = Redis::smembers('ms2020');
        $data = '';
        foreach ($lists as $k)
            $data .= $k . "</br>";

        return $data;
    }
}
