<?php
/**
 * Created by PhpStorm.
 * User: AlanLee
 * Date: 2019/9/9
 * Time: 9:18
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

/**
 * Class User
 * 用户控制器
 */
class User extends Controller
{
    public function index(){
//        return view();
        return "我是User控制器";
    }

    /**
     * ================================ 注册 start ============================
     */
    /**
     * 网页注册界面
     */
    public function register(){
        return view();
    }

    /**
     * 注册处理
     * @return false|string json数据
     */
    public function registerDoWith(){
        //接收前端传过来的数据
        $data = input("post.");
        //dump($data);

        //将数据插入到数据库中
        $db_insert = Db::table("t_user")->insert($data);

        //如果插入成功，则算注册成功，返回json数据
        if ($db_insert){
            $success_result = [
                "code" => "200",
                "message" => "ok",
                "data" => [
                    "username" => $data["username"],
                    "password" => $data["password"]
                ]
            ];

            //dump($success_result);
            return json_encode($success_result);
        }
        else{
            $success_result["code"] = "400";
            $success_result["message"] = "error";
            return json_encode($success_result);
        }

    }

    /**
     * ================================ 注册 end ============================
     */


    /**
     * ================================ 登录 start ============================
     */

    /**
     * 网页登录界面
     */
    public function login(){
        return view();
    }

    /**
     * 登录处理
     */
    public function loginDoWith(){
        //接收前端传过来的数据
        $data = input("post.");
        //dump($data);

        //获取账号密码
        $inp_username = $data["username"];
        $inp_password = $data["password"];


        //从数据库中查询账号密码，进行验证
        $db_data = Db::table("t_user")
            ->where("username", "=", $inp_username)
            ->where("password", "=", $inp_password)->select();

        //dump($db_data);

        //如果查询成功
        if ($db_data){  //返回正确的json数据
            $showData = [
                "code" => "200",
                "message" => "ok",
                "data" => [
                    "username" => $data["username"],
                    "password" => $data["password"],
                ]
            ];

            return json_encode($showData);
        }else{  //返回错误的json数据
            $showData = [
                "code" => "400",
                "message" => "error",
            ];

            return json_encode($showData);
        }

    }

    /**
     * ================================ 登录 end ============================
     */

}