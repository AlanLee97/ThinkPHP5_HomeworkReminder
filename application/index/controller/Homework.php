<?php
/**
 * Created by PhpStorm.
 * User: AlanLee
 * Date: 2019/9/10
 * Time: 21:01
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class Homework extends Controller
{
    public function index(){
        return "Homework控制器";
    }

    public function addHomework(){
        return view();
    }

    public function addHomeworkDoWith(){
        $data = input("get.");
        //dump($data);

        $db_data = [
            "date" => date("Y-m-d H:i:s"),
            "title" => $data["title"],
            "content" => $data["content"],
            "remind_date" => $data["remind_date"],
            "remind_time" => $data["remind_time"],
            "tag" => $data["tag"]
        ];

        $result = Db::table("t_homework")->insert($db_data);

        if ($result){
            $success = [
                "code" => "200",
                "message" => "ok",
            ];

            return json_encode($success);
        }else{
            $fail = [
                "code" => "400",
                "message" => "error"
            ];
            return json_encode($fail);
        }

    }

    public function getHomework(){
        $db_data = Db::table("t_homework")->select();
        //$db_user = Db::table("t_user")->where();
        //dump($db_data);

        //$test = array_column($db_data, "id");
        //dump($test);


        if ($db_data){
            $this->toJson("200", "ok", $db_data);

        }else{
            $this->toJson("400", "error", null);

        }

    }

    public function toJson($code, $message, $data = array()){
        $result = [
            "code" => $code,
            "message" =>$message,
            "data" => $data
        ];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}