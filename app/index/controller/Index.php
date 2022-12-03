<?php
/*
 * @Author       : Lucifer
 * @Date         : 2022-12-03 19:44:40
 * @LastEditTime : 2022-12-03 20:35:22
 * @FilePath     : \tp6_demo1\app\index\controller\Index.php
 */

declare(strict_types=1);

namespace app\index\controller;

use app\index\model\Message;
use think\Request;
use think\facade\View;

class Index
{
    public function index()
    {
        $res = Message::order('id desc')->select()->toArray();
        // 从数据库中获取全部出来如何转成array
        return View::fetch('', ['list' => $res]);
        // 返回视图显示，并且携带数据
    }

    public function send(Request $request)
    {
        $input = input();
        // 获取前端传过来的数据
        $res = new Message;
        $res->save([
            'username'      =>      $input['username'],
            'content'       =>      $input['content'],
            'ip'            =>      $request->ip()
        ]);
        // 保存前端发送过来的数据
        if (!$res) {
            // 如果保存失败则返回
            return json(array(['status'=>201,'msg'=>'保存失败']));
        } else {
            // 如果保存成功则返回
            return json(array(['status'=>200,'msg'=>'保存成功']));
        }
    }
}
