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
    require_once "SoftParameterMan.php";
    require_once "RoleMan.php";
    require_once "MachineMan.php";


    /*
     路由重定向
     */
    abstract class RoutersEnumUri
    {
        const login = "usrLogin";   // 登录
        const logout = "usrLogout";   // 退出登录
        const userEdit = "usrEdit"; // 用户权限管理
        const userRegist = "usrRegist"; // 用户注册
        const userList = "usrList"; // 用户列表
    }


    /* 重定位 */
    class Routers
    {

    }

    if (CodeZ_DEBUG) {

//        UserMan::userLogin("admin", "admin123");

/*        $jsonString = "{ 		\"userId\": \"1\", 		\"userName\": \"admin\", 		\"userAccount\": \"admin\", 		\"password\": \"admin\", 		\"role\": { 			\"roleId\": \"2\", 			\"roleName\": \"一般用户\", 			\"descript\": \"只能使用一般查询权限，权限范围较少\", 			\"deleted\": \"0\" 		}, 		\"dep\": \"行政部\", 		\"lginTime\": \"2018-10-21 00:21:39\", 		\"lgoutTime\": \"2018-10-18 23:22:10\", 		\"deleted\": \"0\" 	}";
        UserMan::userLogout($jsonString);*/

        //新增用户
/*        $newUserJson = "{\"userName\":\"普通操作员02\",\"userAccount\":\"normalAccount02\",\"password\":\"123456\",\"role\":{\"roleId\":\"1\",\"roleName\":\"一般用户\",\"descript\":\"只能使用一般查询权限，权限范围较少\",\"deleted\":\"0\"},\"dep\":\"行政部\"}";
        UserMan::addNewUser($newUserJson);*/

        // 修改权限,或者密码
/*        $editedJson = "{\"userId\":\"1\",\"userName\":\"admin\",\"userAccount\":\"admin\",\"password\":\"admin123\",\"role\":{\"roleId\":\"2\",\"roleName\":\"一般用户\",\"descript\":\"只能使用一般查询权限，权限范围较少\",\"deleted\":\"0\"},\"dep\":\"人事部\",\"deleted\":\"1\"}";
        UserMan::editUser($editedJson);*/
        // 用户列表

//        UserMan::userList(true);

//        RoleMan::roleList();

        // 新增控制端口
//        $portJson = "{\"portName\":\"压铸机控制端口01\",\"remoteIp\":\"10.35.0.22\",\"remoteProtocol\":\"tcp/ip\",\"remotePort\":1008,\"remoteHost\":\"zbdbz\",\"controlMethod\":\"消息\",\"remoteUsr\":\"admin\",\"remotePwd\":\"admin\"}";
 //        SoftParameterMan::addPort($portJson);

       /* $portJson = "{\"portName\":\"压铸机控制端口01\",\"remoteIp\":\"10.35.0.22\",\"remoteProtocol\":\"tcp/ip\",\"remotePort\":1008,\"remoteHost\":\"zbdbz\",\"controlMethod\":\"消息\",\"remoteUsr\":\"admin\",\"remotePwd\":\"admin\",\"portId\":1,\"deleted\":1}";
        // 修改控制端口
        SoftParameterMan::editPort($portJson);*/

       /*$insertSql = "{\"dbName\":\"卧式冷室压铸机数据库0124\"}";
       SoftParameterMan::addDataBase($insertSql);*/


        $updateSql = "{\"dbId\":\"2\",\"dbName\":\"卧式冷室压铸机更新后的数据库03\",\"opened\":\"1\",\"deleted\":\"1\"}";
        SoftParameterMan::checkDataBaseOpened($updateSql);
        SoftParameterMan::dataBaseList(false);
    }else {

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

    }
?>