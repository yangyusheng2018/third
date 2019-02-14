<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 16:42
 */

namespace app\index\controller;

use app\index\controller\Base;
use app\index\model\Domain as DomainModel;
use think\Session;
use think\Request;

class Domain extends Base
{

    public function _initialize()
    {
        if(!session('user_id')){
            $this->error("用户未登录",url("/index/login/login"));
        }

    }

    public function domain_list(){
           $domainmodel=new DomainModel();
           $data=$domainmodel->getByUserId();
           $count=count($data);
           $language=$domainmodel->pieChart($data,"language");
           $suffix=$domainmodel->pieChart($data,"suffix");
           $template=$domainmodel->pieChart($data,"template");

           $this->view->assign([
               "data"=>$data,
               "count"=>$count,
               "suffix"=>$suffix,
               "template"=>$template,
               "language"=>$language,
           ]);
           return  $this->view->fetch();
       }
    public function domain_add(){
        return  $this->view->fetch();
    }
    public function add_domain(Request $request){
        date_default_timezone_set('PRC');
           $data=$this->request->param();
            $status = 0;
            $messages = '添加失败';
            //获取后缀名
            $domains=explode(".",$data["name"])[0];
            $data["suffix"]=str_replace($domains,"",$data["name"]);

            if($data["add_time"]==""){
                $data["add_time"]=time();
            }else{
                $data["add_time"]=strtotime($data["add_time"]);
            }
            if($data["name"]!=""){
                $is_ture=DomainModel::create($data);
                if($is_ture){
                    $status = 1;
                    $messages = '添加成功';
                }
            }
            return ["status"=>$status,"message"=>$messages];
    }

    public function delete_domain(Request $request)
    {
        $id=$this->request->param("id");
        DomainModel::update(["is_delete"=>1],["id"=>$id]);
        DomainModel::destroy($id);
    }
    public function alldelete(){
        $user_id=Session::get("user_id");
        $ids=input("post.delete_id/a");
        foreach ($ids as $id){
            DomainModel::update(["is_delete"=>1],["id"=>$id,"user_id"=>$user_id]);
            DomainModel::destroy(["id"=>$id,"user_id"=>$user_id]);
        }
        return ['status'=>1,'message'=>"删除成功"];
    }
    public function unDelete(){
        $user_id=Session::get("user_id");
        DomainModel::update(["delete_time"=>NULL,"is_delete"=>0],["is_delete"=>1,"user_id"=>$user_id]);
    }
    public function domain_edit(Request $request){
           $user_id=Session::get("user_id");
           $id=$this->request->param("id");
           $data=DomainModel::get(["id"=>$id,"user_id"=>$user_id]);
           $this->view->assign("data",$data);
        return $this->view->fetch();
    }
    public function edit_domain(Request $request){
            $status = 0;
            $messages = '修改失败';
            $data=$this->request->param();
            $id=$data["id"];
            $user_id=Session::get("user_id");
            unset($data["id"]);
        if($data["add_time"]==""){
            $data["add_time"]=time();
        }else{
            $data["add_time"]=strtotime($data["add_time"]);
        }
            if($data["name"]!=""){
                $is_ture=DomainModel::update($data,["id"=>$id,"user_id"=>$user_id]);
                if($is_ture){
                    $status = 1;
                    $messages = '修改成功';
                }
            }else{
                $messages = '名字不能为空';
            }
         return ["status"=>$status,"message"=>$messages];
    }
    public function selects(Request $request){
           $user_id=Session::get("user_id");
        $params=$this->request->param();
        $firstdate=$request->param("firstdate");
        $lastdate=$request->param("lastdate");
        $firstdate=strtotime($firstdate);
        $lastdate=strtotime($lastdate);
        $domainmodel=new DomainModel();
        $where=[];
        $where2=[];
        if($firstdate!=""){
            $where["add_time"]=[">=",$firstdate];
        }
        if($lastdate!=""){
            $where2["add_time"]=["<=",$lastdate];
        }
        if(isset($params["name"])){
            $where["name"]=["like",'%'.$params["name"].'%'];
        }
        if(isset($params["suffix"])){
            $where["suffix"]=$params["suffix"];
        }
        if(isset($params["cloudflare"])){
            $where["cloudflare"]=$params["cloudflare"];
        }
        if(isset($params["language"])){
            $where["language"]=$params["language"];
        }
        if(isset($params["vps"])){
            $where["vps"]=$params["vps"];
        }
        if(isset($params["dbs"])){
            $where["dbs"]=$params["dbs"];
        }
        if(isset($params["template"])){
            $where["template"]=$params["template"];
        }
        if(isset($params["ax"])){
            $where["ax"]=$params["ax"];
        }
        if(isset($params["bx"])){
            $where["bx"]=$params["bx"];
        }
        if(isset($params["cx"])){
            $where["cx"]=$params["cx"];
        }
        if(isset($params["c1x"])){
            $where["c1x"]=$params["c1x"];
        }
        $data=$domainmodel->where(["user_id"=>$user_id])->where($where)->where($where2)->select();
        $counts=count($data);
        $language=$domainmodel->pieChart($data,"language");
        $suffix=$domainmodel->pieChart($data,"suffix");
        $template=$domainmodel->pieChart($data,"template");

        $this->view->assign([
            "data"=>$data,
            "count"=>$counts,
            "suffix"=>$suffix,
            "template"=>$template,
            "language"=>$language,
        ]);
            return $this->view->fetch("domain_list");
    }






    public function add_xp(Request $request){
        $id=$this->request->param("id");
        $xps=$this->request->param("xp");
        $domainmodel=new DomainModel();
        $domainmodel->where(["id"=>$id])->setInc($xps);
    }
    public function add_cd(Request $request){
        $id=$this->request->param("id");
        $domainmodel=new DomainModel();
        $domainmodel->where(["id"=>$id])->setInc("cd");

    }
}