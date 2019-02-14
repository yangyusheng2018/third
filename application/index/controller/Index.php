<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2018/8/16
 * Time: 0:01
 */

namespace app\index\controller;

use app\index\controller\Base;
use org\Upload;
use think\Request;
use think\File;
use think\Image;
class Index extends Base
{

public function index(){
    if(!session('user_id')){
        $this->error("用户未登录",url("/index/login/login"));
    }
    if(session('user_id')){
        $this->error("用户已经登录",url("/index/domain/domain_list"));
    }
}


}