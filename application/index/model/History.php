<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/5
 * Time: 19:24
 */

namespace app\index\model;

use think\Model;
use think\Db;
use think\Session;
use traits\model\SoftDelete;
use app\index\model\Domain;
class History extends Model
{
    use SoftDelete;
    protected $deleteTime="delete_time";
    protected $auto=[


    ];
    protected $insert=[
    ];
    protected $update=[];
    protected $autoWriteTimestamp=true;
    protected $createTime="create_time";
    protected $updateTime="update_time";
    protected $dateFormat="Y-m-d";
    public function getByUserId(){
        $user_id=Session::get("user_id");
        $data=History::all(["user_id"=>$user_id]);
        return $data;
    }
    public function getcreateTimeAttr($valus){
        return date("Y-m-d",$valus);
    }

    public function pieChart($data,$filed){

        $fields=[];
        $res=[];
        $bili=[];
        $count=count($data);
        foreach ($data as $value){
            $fields[]=$value[$filed];
        }
//        foreach ($fields as $value){
//            if(isset($res[$value])){
//                $res["$value"]++;
//            }else{
//                $res["$value"]=1;
//            }
//        }
        $res=array_count_values($fields);
        return $res;

    }

    public function data_list($data){
        foreach ($data as &$values){
            $name=$values["name"];
            $id_set=Domain::get(["name"=>$name]);
            if($id_set){
                $ax=$id_set["ax"];
                $bx=$id_set["bx"];
                $cx=$id_set["cx"];
                $c1x=$id_set["c1x"];
               if($ax>0|$bx>0|$cx>0|$c1x>0){
                   $values->is_xunp="有";
               }else{
                   $values->is_xunp="无";
               }
            }else{
                $values->is_xunp="没有数据";
            }

        }
        return $data;
    }


}


