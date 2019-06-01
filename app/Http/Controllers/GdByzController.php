<?php

namespace App\Http\Controllers;

use App\Services\FaceMergeServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic;

class GdByzController extends Controller
{

    public function __construct()
    {

    }


    public function oauth(Request $request) {
        $oauth = app('wechat')->oauth->setRequest($request)->redirect(url('jxh/byz'));
        return $oauth;
    }



    public function index() {
        $wuser = app('wechat')->oauth->user();
        $openid = $wuser->getId();
        $wuser = app('wechat')->user->get($openid);
        dd($wuser);
        if ($wuser['subscribe']) {
            return redirect('http://weixin.qq.com/r/TjozK_-EzbKyratI929c');
        }

        if (!$user = User::where('openid', $openid)->first()) {
            return redirect('/oauth');
        }

        if (!$user->sid) {
            return redirect('/oauth');
        }



    }


    public function getZjz(Request $request) {
        return view('gdbyz.upload');
    }


    public function submit(Request $request) {
        $data = $request->all();

    }

    public function upload(Request $request) {
        $file = $request->file('file');
        $path = $file->store('public/images');
        $url = substr($path, 7);
        $url = url('storage/' . $url);
        return RJM(['url'=> $url], 1, '上传成功');

    }



}
