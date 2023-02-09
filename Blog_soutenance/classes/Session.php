<?php


class Session
{
    public static function init(){
            session_start();
    }
    public static function set($key, $val){
        $_SESSION[$key] = $val;
    }
    public static function get($key){
        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return false;
        }
    }
    public static function checkSessionUser(){
        self::init();
        if (self::get('login') == false){
            self::destroy();
            header('location:login_user.php');
        }
    }
    public static function checkSessionAdmin(){
        self::init();
        if (self::get('login') == false){
            self::destroy();
            header('location:login_admin.php');
        }
    }
    public static function checkLogin(){
        self::init();
        if (self::get('login') == true){
            header('location:index.php');
        }
    }
    public static function destroy(){
        session_destroy();
        header('location:index.php');
    }
}