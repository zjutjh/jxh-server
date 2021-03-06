<?php
/**
 * Created by PhpStorm.
 * User: 70473
 * Date: 2018/6/16
 * Time: 17:31
 */

namespace App\Services;


use App\Reply;

class WechatService
{


    /** 处理事件
     * @param $message
     * @return mixed
     */
    public function event($message)
    {
        $eventType = $message->Event;
        $res = $this->$eventType($message);
        return $res;
    }

    public function subscribe($message)
    {

    }

    public function unsubscribe($message)
    {

    }

    public function SCAN($message)
    {

    }


    public function CLICK($message)
    {

    }

    /**
     * 处理事件
     */


    public function text($message)
    {
        $response = $this->matchKeyword($message);
        return $response ? $response : '';

    }

    /**
     * 关键词匹配
     */
    public function matchKeyword($message) {
        $content = $message->MsgType == 'text' ? $message->Content : $message->EventKey;
        $keywords = Reply::all();
        foreach ($keywords as $k => $v) {
            if ($v->status == 1 && is_match($content, $v)) {
                return $this->reply();
            }
        }
    }


    public function reply() {

    }




    public function image($message)
    {

    }

    public function voice($message)
    {

    }

    public function location($message)
    {

    }

    public function link($message)
    {

    }

    public function file($message)
    {

    }

}