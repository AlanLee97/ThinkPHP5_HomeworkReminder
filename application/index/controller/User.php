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
use think\Session;

/**
 * Class User
 * 用户控制器
 */
class User extends Controller
{
    public $uid;

    /**
     * @return mixed
     */
    public function getUid()
    {
        if (Session::has("t_user_id")){
            return $this->uid = Session::get("t_user_id");
        }else{
            return null;
        }
    }

    public function index(){
        $data = Db::table("t_user")->select();
        $this->assign("data", $data);
        return view();
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
     * 网页端使用：注册处理
     * @return false|string json数据
     */
    public function registerDoWith(){
        //接收前端传过来的数据
        $data = input("post.");
        //dump($data);

        $insert_data = [
            "id" => null,
            "username" => $data["username"],
            "password" => $data["password"],
            "nickname" => "用户_".$data["username"],
            "school" => null,
            "major" => null,
            "class" => null,
            "create_time" => date("Y-m-d H:i:s")
        ];

        //将数据插入到数据库中
        $db_insert = Db::table("t_user")->insert($insert_data);

        //如果插入成功，则算注册成功，返回json数据
        if ($db_insert){
            //$this->toJson("200", "ok", null);
            return "<script>alert('注册成功');</script>";
        }
        else{
            //$this->toJson("400", "error", null);
            return "<script>alert('注册失败');</script>";
        }

    }

    /**
     * APP端的接口：注册处理
     * @return false|string json数据
     */
    public function api_registerDoWith(){
        //接收前端传过来的数据
        $data = input("post.");
        //dump($data);

        $insert_data = [
            "id" => null,
            "username" => $data["username"],
            "password" => $data["password"],
            "nickname" => "用户_".$data["username"],
            "school" => null,
            "major" => null,
            "class" => null,
            "create_time" => date("Y-m-d H:i:s")
        ];

        //将数据插入到数据库中
        $db_insert = Db::table("t_user")->insert($insert_data);

        //如果插入成功，则算注册成功，返回json数据
        if ($db_insert){
            $this->toJson("200", "ok", null);
        }
        else{
            $this->toJson("400", "error", null);
        }

    }

    /**
     * --------------------------------- 注册 end ---------------------------------
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
        if (Session::has("username") && Session::has("t_user_id")){
            Session::delete("username");
            Session::delete("t_user_id");
        }



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
            //$this->toJson("200", "ok", $db_data);


            Session::set("username", $db_data[0]["username"]);
            Session::set("t_user_id", $db_data[0]["id"]);

            return $this->fetch("/index/index");


        }else{  //返回错误的json数据
            //$this->toJson("400", "error", null);
            $this->error("登录失败");
        }

    }

    public function api_loginDoWith(){
        if (Session::has("username") && Session::has("t_user_id")){
            Session::delete("username");
            Session::delete("t_user_id");
        }



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
            $this->toJson("200", "ok", $db_data);


            Session::set("username", $db_data[0]["username"]);
            Session::set("t_user_id", $db_data[0]["id"]);


        }else{  //返回错误的json数据
            $this->toJson("400", "error", null);
        }

    }

    /**
     * --------------------------------- 登录 end ---------------------------------
     */


    /**
     * ================================ 退出登录 start ============================
     */



    /**
     * 网页端使用：登录处理
     */
    public function logoutDoWith(){
        if (Session::has("username") && Session::has("t_user_id")){
            Session::delete("username");
            Session::delete("t_user_id");
            return $this->fetch("/index/index");
        }
    }



    /**
     * --------------------------------- 退出登录 end ---------------------------------
     */




    /**
     * ================================ 个人中心 start ============================
     */

    /**
     * 所有用户
     */
    public function users(){

    }

    /**
     * 查询所有用户信息，返回json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserInfo(){
        $data = Db::table("t_user")->select();
        if ($data){
            $this->toJson("200", "ok", $data);
        }else{
            $this->toJson("400", "error", null);
        }

    }

    /**
     * APP端使用：查询所有用户信息，返回json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function api_getUserInfo(){
        $data = Db::table("t_user")->select();
        if ($data){
            $this->toJson("200", "ok", $data);
        }else{
            $this->toJson("400", "error", null);
        }

    }

    /**
     * --------------------------------- 个人中心 end ---------------------------------
     */




    /**
     * ================================ 编辑用户信息 start ============================
     */

    public function editUserInfo($id){
        //在数据库中查询被修改的数据
        $data = Db::query('select * from t_user where id=?',[$id]);
        //dump($data);
        $this->assign('data',$data[0]);
        return view();
    }


    /**
     * APP端使用：编辑用户信息处理
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function api_editUserInfoDoWith(){

        $data = input("get.");

        //将数据更新到数据库中
        //$rs = Db::execute('update t_user set username=:username,password=:password where id=:id',$data);
        $rs2 = Db::table("t_user")->update($data);


        if ($rs2){
            $this->toJson("200", "ok", null);
        }else{
            $this->toJson("400", "error", null);
        }

    }

    /**
     * --------------------------------- 编辑用户信息 end ---------------------------------
     */




    /**
     * 将结果转成json
     * @param $code 请求码
     * @param $message 请求信息
     * @param array $data 请求的数据
     */
    public function toJson($code, $message, $data = array()){
        $result = [
            "code" => $code,
            "message" =>$message,
            "data" => $data
        ];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }



    /**
     * 检查登录状态
     * @return mixed
     */
    public function checkLoginState(){
        $t_user_id = Session::get("t_user_id");
        if ($t_user_id == null){
            echo "<script>alert('请先登录'); location.href='/index.php/index/index/index';</script>";
            //return $this->fetch("/index/index");


        }
    }

}