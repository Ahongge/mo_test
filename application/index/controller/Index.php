<?php
namespace app\index\controller;

use think\cache\driver\Redis;
use think\Db;

class Index
{
    public function index()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $sql = "select id, uid, agent_id, test from test  limit 100000,100000";
        $list = Db::query($sql);
//        dump($list);die;
        foreach ($list as $v){
            $redis->hSet('user-between-uid-id',$v['uid'],$v['id']);
            $redis->hSet('user-between-id-uid',$v['id'],$v['uid']);
//            if (empty($v['agent_id'])){
//                $v['agent_id'] = 0;
//            }
            $redis->hSet('user-between-agent-id',$v['id'],$v['agent_id']);
            $redis->hSet('user-between-id-test',$v['id'],$v['test']);
        }
        echo 'OK';

    }

    public function hello()
    {

    }
}
