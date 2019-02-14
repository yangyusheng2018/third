<?php
namespace app\index\model;

use think\Model;
use think\Db;
use traits\model\SoftDelete;

class User extends Model
{
    use SoftDelete;
    protected $deleteTime="delete_time";
    protected $auto=[


    ];
    protected $insert=[
        "login_time"=>null,
        "status"=>1,
        "login_count"=>0,
        "is_delete"=>0,
    ];
    protected $update=[];
    protected $autoWriteTimestamp=true;
    protected $createTime="create_time";
    protected $updateTime="update_time";
    protected $dateFormat="Y-m-d";
    public function getRoleAttr($value){
        $role=[
            1=>'超级管理员',
            0=>'普通管理员',
        ];
        return $role[$value];
    }
    public function getStatusAttr($value)
    {
        $status=[
            1=>"启用",
            0=>"禁用",
        ];
        return $status[$value];
    }

    public function getLoginTimeAttr($valus){
        return date("Y-m-d h:i:s",$valus);
    }

}


