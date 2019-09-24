<?php
/**
 * Created by PhpStorm.
 * User: AlanLee
 * Date: 2019/9/19
 * Time: 12:50
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class Upload extends Controller
{
    public function uploadFile(){


        return view();
    }


    public function uploadDoWith(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');

        echo "<br>";

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                echo "<br>";
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $saveName = $info->getSaveName();
                echo $saveName;
                echo "<br>";
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
                echo "<br>";

                $filepath = $info->getPathname();
                echo $filepath;
                echo "<br>";

                $user = new User();
                $uid = $user->getUid();





                $result = Db::table("t_image")->insert(["user_img" => $saveName, "uid" => $uid]);
                if ($result){
                    echo "插入成功";
                    echo "<br>";

                    $sql = "
                        select t_user.username, t_image.user_img
                        from t_user, t_image
                        where t_user.id = t_image.uid and t_user.id = $uid
                    ";

                    $result2 = Db::query($sql);
                    if ($result2){
                        echo "<img src='/uploads/$saveName' />";
                    }else{
                        echo "没有查询到图片路径";
                    }



                }else{
                    echo "插入失败";
                }





            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }


    public function uploadTouxiang(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');


        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){

                $saveName = $info->getSaveName();

                $userObj = new User();
                $uid = $userObj->getUid();

                Db::table("t_image")->insert(["user_img" => $saveName, "uid" => $uid]);

                return "<script>location.href='/index.php/index/user/personal';</script>";
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }

}