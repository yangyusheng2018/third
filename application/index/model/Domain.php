<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 16:35
 */

namespace app\index\model;
use think\Model;
use think\Db;
use think\Session;
use traits\model\SoftDelete;

class Domain extends Model
{
    use SoftDelete;
    protected $deleteTime="delete_time";
    protected $auto=[

    ];
    protected $insert=[
        "ax"=>0,"bx"=>0,"cx"=>0,"c1x"=>0,
    ];
    protected $update=[];
    protected $autoWriteTimestamp=true;
    protected $createTime="create_time";
    protected $updateTime="update_time";
    protected $dateFormat="Y-m-d";
    public function getByUserId(){
        $user_id=Session::get("user_id");
        $data=Domain::all(["user_id"=>$user_id]);
        return $data;
    }
    public function getaddTimeAttr($valus){
        return date("Y-m-d",$valus);
    }

    public function pieChart($data,$filed){

        $fields=[];
        foreach ($data as $value){
            $fields[]=$value[$filed];
        }
          $res=array_count_values($fields);
        return $res;

    }

}


