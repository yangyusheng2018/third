<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/5
 * Time: 19:47
 */

namespace app\index\controller;

use app\index\controller\Base;
use app\index\model\History as HistoryModel;
use think\Session;
use think\Request;
use think\db;
class History extends Base
{
    public function history_list(){
        $HistoryModel=new HistoryModel();
        $data=$HistoryModel->getByUserId();
        $data=$HistoryModel->data_list($data);


        $count=count($data);

        $this->view->assign([
            "data"=>$data,
            "count"=>$count,
        ]);
        return  $this->view->fetch();
    }
    public function history_add(){
        return $this->fetch();
    }
    public function add_history(Request $request){
        date_default_timezone_set('PRC');
        $data=$this->request->param();
        $status = 0;
        $messages = '添加失败';
        //获取后缀名
        $domains=explode(".",$data["name"])[0];
        $data["suffix"]=str_replace($domains,"",$data["name"]);

        if($data["create_time"]==""){
            $data["create_time"]=time();
        }else{
            $data["create_time"]=strtotime($data["create_time"]);
        }
        if($data["name"]!=""){
            $is_ture=HistoryModel::create($data);
            if($is_ture){
                $lastid=Db::name('history')->getLastInsID();
                    $status=1;
                    $messages="添加成功";
                    $files=$request->file("file-Portrait1");
                    $dir="upload/goods/".$lastid;// 自定义文件上传路径
                    if(!is_dir($dir)){
                        mkdir($dir,0777,true);
                    }

                    $i=1;
                    $imageurl="";
                    foreach($files as $picFile){
                        $imgnames=time()+$i;
                        $info = $picFile->move($dir,$imgnames);
                        $imageurl.="/".str_replace("\\","/",$info->getPathname()).",";
                        $i++;
                    }
                HistoryModel::update(["imageurl"=>$imageurl],["id"=>$lastid]);



            }
        }
        return ["status"=>$status,"message"=>$messages];
    }

    public function history_edit(Request $request){
        $user_id=Session::get("user_id");
        $id=$this->request->param("id");
        $data=HistoryModel::get(["id"=>$id,"user_id"=>$user_id]);
        $this->view->assign("data",$data);
        return $this->view->fetch();
    }
    public function edit_history(Request $request){
        $status = 0;
        $messages = '修改失败';
        $data=$this->request->param();
        $id=$data["id"];
        $user_id=Session::get("user_id");
        unset($data["id"]);
        if($data["name"]!=""){
            $is_ture=HistoryModel::update($data,["id"=>$id,"user_id"=>$user_id]);
            if($is_ture){
                $status = 1;
                $messages = '修改成功';
            }
        }else{
            $messages = '名字不能为空';
        }
        return ["status"=>$status,"message"=>$messages];
    }

    public function delete_goods(Request $request)
    {
        $id=$this->request->param("id");
        HistoryModel::update(["is_delete"=>1],["id"=>$id]);
        HistoryModel::destroy($id);
        $this->delDirAndFile("upload/goods/".$id,true);
    }
    public function delete_pic(Request $request){
        $imgurl=$this->request->param("imgurl");
        $id=$this->request->param("id");
        $counts=$this->request->param("counts");
        $imgurl = substr($imgurl,1);
        if(file_exists($imgurl)){
            unlink($imgurl);
            $counts=$counts-1;
        }
        $goods=HistoryModel::get($id);
        $imgurl1=$goods->getData("imageurl");
        $imgurl1=str_replace("/".$imgurl.",","",$imgurl1);
        HistoryModel::update(["imageurl"=>$imgurl1],["id"=>$id]);
    }

    public function pic_edit(Request $request){
        $id=$this->request->param("id");
        $data3=HistoryModel::get("$id")->getData();
        $counts=substr_count( $data3["imageurl"],",");
        $data3["imageurl"] = substr($data3["imageurl"],0,strlen($data3["imageurl"])-1);
        $imgs=explode(",",$data3["imageurl"]);
        $this->view->assign("counts",$counts);
        $this->view->assign("imgs",$imgs);
        $this->view->assign("data3",$data3);
        return $this->view->fetch();
    }
    public function edit_pic(Request $request){
        $redata=$this->request->param();
        $status = 0;
        $messages = '修改失败';
        $files=$request->file("file-Portrait1");

        $id=$this->request->param("id");
        $data=HistoryModel::get("$id")->getData();
        $counts=substr_count( $data["imageurl"],",");
        $imageurl=$data["imageurl"];
        $data["imageurl"] = substr($data["imageurl"],0,strlen($data["imageurl"])-1);
        $imgs=explode(",",$data["imageurl"]);

        $i=0;
        foreach($files as $picFiles){
            $i++;
        }
        if(($i+$counts)>4){
            $status = 0;
            $messages = '图片不能多于四个';
        }else{
            $dir="upload/goods/".$id;// 自定义文件上传路径
            if(!is_dir($dir)){
                mkdir($dir,0777,true);}
            $j=0;
            foreach($files as $picFile){
                $imgnames=time()+$j;
                $info = $picFile->move($dir,$imgnames);
                $j++;
                $imageurl.="/".str_replace("\\","/",$info->getPathname()).",";
            }

            HistoryModel::update(["imageurl"=>$imageurl],["id"=>$id]);
            $status = 1;
            $messages = '修改完成';
        }

        return ['status'=>$status,'message'=>$messages];
    }

    public function delete_domain(Request $request)
    {
        $id=$this->request->param("id");
        HistoryModel::update(["is_delete"=>1],["id"=>$id]);
        HistoryModel::destroy($id);
    }
    public function alldelete(){
        $user_id=Session::get("user_id");
        $ids=input("post.delete_id/a");
        foreach ($ids as $id){
            HistoryModel::update(["is_delete"=>1],["id"=>$id,"user_id"=>$user_id]);
            HistoryModel::destroy(["id"=>$id,"user_id"=>$user_id]);
        }
        return ['status'=>1,'message'=>"删除成功"];
    }
    public function unDelete(){
        $user_id=Session::get("user_id");
        HistoryModel::update(["delete_time"=>NULL,"is_delete"=>0],["is_delete"=>1,"user_id"=>$user_id]);
    }
    public function selects(Request $request){
        $user_id=Session::get("user_id");
        $params=$this->request->param();
        $firstdate=$request->param("firstdate");
        $lastdate=$request->param("lastdate");
        $firstdate=strtotime($firstdate);
        $lastdate=strtotime($lastdate);
        $domainmodel=new HistoryModel();
        $where=[];
        $where2=[];
        if($firstdate!=""){
            $where["create_time"]=[">=",$firstdate];
        }
        if($lastdate!=""){
            $where2["create_time"]=["<=",$lastdate];
        }
        if(isset($params["name"])){
            $where["name"]=["like",'%'.$params["name"].'%'];
        }

        $data=$domainmodel->where(["user_id"=>$user_id])->where($where)->where($where2)->select();
        $counts=count($data);

        $this->view->assign([
            "data"=>$data,
            "count"=>$counts,
        ]);
        return $this->view->fetch("history_list");
    }
        public function pic_show(Request $request){
            $id=$this->request->param("id");
            $data=HistoryModel::get($id);
            $data3["imageurl"] = substr($data["imageurl"],0,strlen($data["imageurl"])-1);
            $imgs=explode(",",$data["imageurl"]);

            $this->view->assign("imgs",$imgs);
            return $this->fetch();
        }

}