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
use think\Session;

class Homework extends Controller
{

    public $user;
    public function index(){
        return "Homework控制器";
    }






    /**
     * ================================ 查询作业 start ============================
     */

    /**
     * 网页端展示数据：所有作业
     */
    public function queryHomework(){
        $sql = "
                select t_homework.id, t_homework.date, t_homework.title, t_homework.content,
                        t_homework.tag, t_homework.remind_date, t_homework.remind_time,
                        t_user.username 
                from t_homework, t_user
                where t_user.id = t_homework.uid
              ";
        $db_data = Db::query($sql);
        $this->assign("data", $db_data);

        return view();
    }

    /**
     * 网页端展示数据：当前登录用户下的作业数据
     */
    public function queryHomeworkByUid(){
        $user = new User();
        $user->checkLoginState();


        $t_user_id = Session::get("t_user_id");


        //dump($t_user_id);

        $sql = "
                select t_homework.id, t_homework.date, t_homework.title, t_homework.content,
                        t_homework.tag, t_homework.remind_date, t_homework.remind_time,
                        t_user.username 
                from t_homework, t_user
                where t_user.id = t_homework.uid and t_user.id = $t_user_id
              ";
        $db_data = Db::query($sql);

        //dump($db_data);
        $this->assign("data", $db_data);

        return view();
    }

    /**
     * 网页端展示数据：当前登录用户下的未完成作业数据
     */
    public function queryUndoHomework(){
        $user = new User();
        $user->checkLoginState();

        $t_user_id = Session::get("t_user_id");


        //dump($t_user_id);

        $sql = "
                select t_homework.*, t_user.username
                
                from t_homework, t_user, t_homework_state
                
                where t_user.id = t_homework.uid 
                and t_user.id = t_homework_state.t_uid 
                and t_homework.id = t_homework_state.t_hid 
                and t_homework_state.t_uid = $t_user_id 
                and t_homework_state.t_done = 0;
              ";
        $db_data = Db::query($sql);

        //dump($db_data);
        $this->assign("data", $db_data);

        return view();


    }

    /**
     * 网页端展示数据：当前登录用户下的已完成作业数据
     */
    public function queryDoneHomework(){
        $user = new User();
        $user->checkLoginState();

        $t_user_id = Session::get("t_user_id");


        //dump($t_user_id);

        $sql = "
                select t_homework.*, t_user.username
                
                from t_homework, t_user, t_homework_state
                
                where t_user.id = t_homework.uid 
                and t_user.id = t_homework_state.t_uid 
                and t_homework.id = t_homework_state.t_hid 
                and t_homework_state.t_uid = $t_user_id 
                and t_homework_state.t_done = 1;
              ";
        $db_data = Db::query($sql);

        //dump($db_data);
        $this->assign("data", $db_data);

        return view();


    }


    //************************   api   **********************

    /**
     * 给APP端使用的接口：当前登录用户下的未完成作业数据
     */
    public function api_queryUndoHomework($t_user_id){


        //dump($t_user_id);

        $sql = "
                select t_homework.*, t_user.username
                
                from t_homework, t_user, t_homework_state
                
                where t_user.id = t_homework.uid 
                and t_user.id = t_homework_state.t_uid 
                and t_homework.id = t_homework_state.t_hid 
                and t_homework_state.t_uid = $t_user_id 
                and t_homework_state.t_done = 0;
              ";
        $db_data = Db::query($sql);

        if ($db_data){
            $this->toJson("200", "ok", $db_data);
        }else{
            $this->toJson("400", "error", null);
        }


    }

    /**
     * 给APP端使用的接口：当前登录用户下的已完成作业数据
     */
    public function api_queryDoneHomework($t_user_id){
        $sql = "
                select t_homework.*, t_user.username
                
                from t_homework, t_user, t_homework_state
                
                where t_user.id = t_homework.uid 
                and t_user.id = t_homework_state.t_uid 
                and t_homework.id = t_homework_state.t_hid 
                and t_homework_state.t_uid = $t_user_id 
                and t_homework_state.t_done = 1;
              ";
        $db_data = Db::query($sql);

        if ($db_data){
            $this->toJson("200", "ok", $db_data);
        }else{
            $this->toJson("400", "error", null);
        }


    }


    /**
     * 给APP端使用的接口：查询当前用户id下的作业数据
     * @param $t_user_id
     */
    public function api_queryHomeworkByUidDoWith($t_user_id){

        $sql = "
                select t_homework.id, t_homework.date, t_homework.title, t_homework.content,
                        t_homework.tag, t_homework.remind_date, t_homework.remind_time,
                        t_user.username 
                from t_homework, t_user
                where t_user.id = t_homework.uid and t_user.id = $t_user_id
              ";
        $db_data = Db::query($sql);

        if ($db_data){
            $this->toJson("200", "ok", $db_data);
        }else{
            $this->toJson("400", "error", null);
        }
    }

    /**
     * 给APP端使用的接口：返回所有作业数据
     */
    public function api_queryHomeworkDoWith(){
        $sql = "
                select t_homework.id, t_homework.date, t_homework.title, t_homework.content,
                        t_homework.tag, t_homework.remind_date, t_homework.remind_time,
                        t_user.username 
                from t_homework, t_user
                where t_user.id = t_homework.uid
              ";
        $db_data = Db::query($sql);

        if ($db_data){
            $this->toJson("200", "ok", $db_data);

        }else{
            $this->toJson("400", "error", null);

        }

    }

    /**
     * --------------------------------- 查询作业 end ---------------------------------
     */









    /**
     * ================================ 添加作业 start ============================
     */

    /**
     * 网页端界面
     */
    public function addHomework(){
        $user = new User();
        $uid = $user->getUid();

        //dump(Session::get("username"));
        //dump($uid);
        $this->assign("uid", $uid);
        return view();
    }

    /**
     * 网页端使用：添加作业处理
     */
    public function addHomeworkDoWith(){
        $data = input("get.");
        //dump($data);

        $db_data = [
            "date" => date("Y-m-d H:i:s"),
            "title" => $data["title"],
            "content" => $data["content"],
            "remind_date" => $data["remind_date"],
            "remind_time" => $data["remind_time"],
            "tag" => $data["tag"],
            "uid" => $data["uid"]
        ];

        $result = Db::table("t_homework")->insert($db_data);

        if ($result){
            //$this->toJson("200", "ok", null);
            //$this->queryHomeworkByUid();
            return $this->fetch("/index/index");
        }else{
            //$this->toJson("400", "error", null);
            return "<script>alert('添加失败');</script>";
        }

    }


    //************************   api   **********************


    /**
     * APP端使用的接口：添加作业处理
     */
    public function api_addHomeworkDoWith(){
        $data = input("get.");
        //dump($data);

        $db_data = [
            "date" => date("Y-m-d H:i:s"),
            "title" => $data["title"],
            "content" => $data["content"],
            "remind_date" => $data["remind_date"],
            "remind_time" => $data["remind_time"],
            "tag" => $data["tag"],
            "uid" => $data["uid"]
        ];

        $result = Db::table("t_homework")->insert($db_data);

        if ($result){
            $this->toJson("200", "ok", null);
        }else{
            $this->toJson("400", "error", null);
        }

    }

    /**
     * --------------------------------- 添加作业 end ---------------------------------
     */










    /**
     * ================================ 修改作业 start ============================
     */

    /**
     * 网页端界面
     */
    public function editHomework($id){
        //在数据库中查询被修改的数据
        $data = Db::query('select * from t_homework where id=?',[$id]);
        //dump($data);
        $this->assign('data',$data[0]);
        return view();
    }



    //************************   api   **********************



    /**
     * APP端使用的接口：编辑作业处理
     */
    public function api_editHomeworkDoWith(){
        $data = input("get.");
        dump($data);

        //将数据更新到数据库中

        $rs = Db::table("t_homework")->update($data);


        if ($rs){
            $this->toJson("200", "ok", null);
        }else{
            $this->toJson("400", "error", null);
        }

    }

    /**
     * --------------------------------- 修改作业 end ---------------------------------
     */










    /**
     * ================================ 删除作业 start ============================
     */
    //未用到这个方法
    public function deleteHomework(){
        return view();
    }



    //************************   api   **********************

    /**
     * 网页端/APP端使用的接口：删除作业处理
     */
    public function api_deleteHomeworkDoWith($id){
        $data = input("get.");
        //dump($data);

        //根据id删除数据
        $rs = Db::execute('delete from t_homework where id=:id',[$id]);

        if ($rs){
            $this->toJson("200", "ok", null);
        }else{
            $this->toJson("400", "error", null);
        }

    }

    /**
     * --------------------------------- 删除作业 end ---------------------------------
     */









    /**
     * 将结果转成json
     * @param $code
     * @param $message
     * @param array $data
     */
    public function toJson($code, $message, $data = array()){
        $result = [
            "code" => $code,
            "message" =>$message,
            "data" => $data
        ];

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }



}