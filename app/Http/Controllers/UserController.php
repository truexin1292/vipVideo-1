<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\1\13 0013
 * Time: 15:31
 */
namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller{
    public function captcha(){
        $builder= new CaptchaBuilder();
        $builder->build($width = 100, $height = 40, $font = null);
        $builder->setBackgroundColor(255, 251, 240);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        Session::flash('captcha', $phrase);
        //生成图片
        ob_clean(); //清除缓存
        return response($builder->output())->header('Content-type','image/jpeg'); //把验证码数据以jpeg图片的格式输出

        $builder->output();
    }
    public function register(Request $request){
        if($request->isMethod('POST')){
            $username=$request->input("username");
            $password=$request->input("password");
            if($username =="" || $password==""){
                $data=["status"=>0,"errmsg"=>"用户名或密码不能为空"];
            }else{
                if(Session::get("captcha") != $request->input("code")){
                    $data=["status"=>0,"errmsg"=>"验证码错误"];
                }else{
                    $user = DB::table("members")->where("username",$username)->get();
                    if($user->isEmpty()){
                        $salt=randStr(6,0);
                        $password=pEncrypt($password,$salt);
                        $result=DB::table("members")->insert([
                            "username"=>$username,
                            "password"=>$password,
                            "salt"=>$salt,
                            "createtime"=>time(),
                            "createip"=>$request->getClientIp()
                        ]);
                        if($result){
                            $data=["status"=>1,"errmsg"=>"注册成功,请登录"];
                        }else{
                            $data=["status"=>1,"errmsg"=>"注册失败"];
                        }
                    }else{
                        $data=["status"=>0,"errmsg"=>"此用户名已存在"];
                    }
                }

            }
            return response()->json($data);
        }
    }
    public function login(Request $request){
        if($request->isMethod('POST')){
            $username=$request->input("username");
            $password=$request->input("password");
            if($username =="" || $password==""){
                $data=["status"=>0,"errmsg"=>"用户名或密码不能为空"];
            }else{
                $user = DB::table("members")->where("username",$username)->first();

                if($user==null){
                    $data=["status"=>0,"errmsg"=>"不存在此用户"];
                }else{

                   $password=pEncrypt($password,$user->salt);
                    if($password==$user->password){
                        session(["uid"=>$user->id]);
                        session(["user"=>$user->username]);
                        $info =DB::table('watchhistory')->where("uid",$user->id)->orderBy("time","desc")->limit(1)->first();
                        if($info){
                            session(["lastWatch"=>$info->title."-".$info->drama]);
                            session(["lastLink"=>$info->link]);
                        }else{
                            $request->session()->forget("lastWatch");
                            $request->session()->forget("lastLink");
                        }

                        $data=["status"=>1,"errmsg"=>"登录成功"];
                    }else{
                        $data=["status"=>0,"errmsg"=>"用户名或密码错误"];
                    }
                }
            }
            return response()->json($data);
        }
    }
}