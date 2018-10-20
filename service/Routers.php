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
        const logout = "usrLogout";   // 退出登录
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
        case RoutersEnumUri::logout:
            {
                UserMan::userLogout($_POST['user']);
            }
            break;
    }

//    UserMan::userLogin("admin", "admin");
//    $jsonString = "{\"userId\": \"1\", 	\"userName\": \"admin\", 	\"userAccount\": \"admin\", 	\"password\": \"admin\", 	\"dep\": \"行政部\", 	\"loginTime\": \"2018-10-18 14:58:22\", 	\"logoutTime\": \"\", 	\"deleted\": \"0\", 	\"roleId\": \"2\", 	\"roleName\": \"一般用户\", 	\"descript\": \"只能使用一般查询权限，权限范围较少\" }";
/*    UserMan::userLogout($jsonString);*/
?>