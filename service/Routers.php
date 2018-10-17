<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/14
     * Time: 17:34
     */


    /*
    * import file
    */
    require_once "UserMan.php";


    /*
     路由重定向
     */
    abstract class RoutersEnumUri
    {
        const login = "usrLogin";   // 登录
    }


    /* 重定位 */
    class Routers
    {

    }

    /*
    * action动作
    */
    $action = $_POST['action'];

    switch($action){
    case RoutersEnumUri::login:
        {
            UserMan::userLogin($_POST['user'], $_POST['pwd']);
        }
    break;
    }
/*
    UserMan::userLogin("", "");*/

?>