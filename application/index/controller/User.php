<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2018/8/21
 * Time: 19:41
 *  $mes=[
'name'=>[ "require"=>'用户名不能为空，请检查'],
'password'=>[ "require"=>'密码不能为空，请检查'],
'verify'=>[ "require"=>'验证码不能为空，请检查',
"captche"=>'验证码不正确，请检查'],
];
 */

namespace app\index\controller;
use app\index\controller\Base;
use think\Model;
use think\Request;
use app\index\model\User as UserModel;
use think\Db;
use think\Session;
use think\Validate;
class User extends Base
{
    public function logout(){
        Session::delete("user_id");
        Session::delete("user_info");
        $this->success("退出成功","login/login");
    }
    public function admin_add(){

        return $this->fetch();
    }
    public function checkPassWord(){
        $password=trim($this->request->param("password"));
        $status=1;
        $messages="";
        if($password==""){
            $status=0;
            $messages="密码不能为空";
        }
        return ['status'=>$status,'message'=>$messages];
    }

    public function checkUserName(){
        $userName=trim($this->request->param("name"));
        $users=UserModel::get(["name"=>$userName]);
        $status=1;
        $messages="";
        if($users!=null){
            $status=0;
            $messages="用户名已经被使用";
        }
        if($userName==""){
            $status=0;
            $messages="用户名不能为空";
        }
        if(strlen($userName)>30){
            $status=0;
            $messages="用户名太长";
        }
        return ['status'=>$status,'message'=>$messages];
    }
    public function add_admin(Request $request){
        $data=$request->param();
        $ch_name=$this->checkUserName();
        $ch_pass=$this->checkPassWord();
        $status = 0;
        $messages = '添加失败';
        $insterData=[
            'name'=>$data["name"],
            'password'=>md5($data['password']),
        ];
        if($ch_name["status"]==0){$messages=$ch_name["message"];}
        if($ch_pass["status"]==0){$messages=$ch_pass["message"];}

        if($ch_name["status"]==1&$ch_pass["status"]==1){
            $insterTrue=UserModel::create($insterData);
            if($insterTrue!=null){
                $status=1;
                $messages="添加成功";
            }

        }
        return ['status'=>$status,'message'=>$messages];
    }

    public function admin_edit(Request $request){
        $this->islogin();
        $id=$this->request->param('id');
        $user=UserModel::get($id);
        //var_dump($user);
        $user_info=$user->getData();
        $name=$user->getData('name');
        $password=$user->getData('password');
        $email=$user->getData('email');
        $this->view->assign('name',$name);
        $this->view->assign('password',md5($password));
        $this->view->assign('email',$email);
        $this->view->assign('id',$id);
        $this->view->assign('user_info',$user_info);
        return $this->view->fetch();
        //var_dump($name);
    }

    public function edit_admin(Request $request){
        $this->islogin();
        $data=$this->request->param();
        $ch_name=$this->checkUserName1();
        $ch_pass=$this->checkPassWord();

        $status = 0;
        $messages = '添加失败';
        $id=$this->request->param("id");
        $rule=[
            "name"=>"require" ,
            "password"=>"require",
        ];
        $msg = [
            'name'=>'名称格式错误',
            'password'=>'密码格式错误',
        ];
        $validate = new Validate($rule,$msg);
        $result=$validate->check($data);
        $insterData=[
            'name'=>$data["name"],
            'password'=>md5($data['password']),
        ];
        $user_info_name=Session::get("user_info.name");
        if($user_info_name=="admin"){
            $insterData["role"]=$data["role"];
        }
        $messages=$validate->getError();
        if($ch_name["status"]==0){$messages=$ch_name["message"];}
        if($ch_pass["status"]==0){$messages=$ch_pass["message"];}

        if($result==true&$ch_name["status"]==1&$ch_pass["status"]==1){
            $insterTrue=UserModel::update($insterData,["id"=>$id]);
            if($insterTrue!=null){
                $status=1;
                $messages="更新成功";
            }

        }
        return ['status'=>$status,'message'=>$messages];
    }
}
