<?php

namespace App\Http\Controllers\Wechat;

use App\Jobs\RedirectWxToBk;
use BadMethodCallException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServerController extends Controller
{
    public $wechat;

    public $wechatService;

    public function __construct()
    {
        $this->wechat = app('wechat');
        $this->wechatService = app('wechatService');
    }


    public function server(Request $request)
    {
        if ($request->method() === 'GET') {
            RedirectWxToBk::dispatch($request->all(), 'GET') ;
        } else {
            RedirectWxToBk::dispatch($request->getContent(), 'POST') ;
        }
        $this->wechat->server->push(function ($message) {
            $type = $message->MsgType;
            try {
                $res = $this->wechatService->$type($message);
                return $res;
            } catch (BadMethodCallException $e) {
                return '问题来了';
            }
        });

        $res = $this->wechat->server->serve();
        return $res;
    }

}
