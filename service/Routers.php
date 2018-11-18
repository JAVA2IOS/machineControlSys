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
        const roleList = "roleList"; // 角色列表
        const newRole = "addRole"; // 新增角色
        const portAdd = "portAdd"; // 新增端口
        const portList = "portList"; // 端口列表
        const portEdit = "portEdit"; // 修改端口
        const sensorList = "sensorList"; // 传感器列表
        const sensorAdd = "sensorAdd"; // 新增传感器
        const sensorEdit = "sensorEdit"; // 修改传感器
        const machineAdd = "machineAdd"; // 新增压铸机
        const machineList = "machineList"; // 压铸机列表
        const machineEdit = "machineEdit"; // 修改压铸机
        const machineSrch = "machineSearch"; // 搜索压铸机
        const counterList = "counterList"; // 计数器列表
        const counterAdd = "counterAdd"; // 新增计数器
        const counterEdit = "counterEdit"; // 修改计数器
        const counterSrch = "counterSearch"; // 搜索计数器
        const parameterList = "parameterList"; // 控制参数列表
        const parameterAdd = "parameterAdd"; // 新增控制参数
        const parameterEdit = "parameterEdit"; // 修改控制参数
        const parameterSrch = "parameterSearch"; // 搜索控制参数


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


/*        $updateSql = "{\"dbId\":\"2\",\"dbName\":\"卧式冷室压铸机更新后的数据库03\",\"opened\":\"1\",\"deleted\":\"1\"}";
        SoftParameterMan::checkDataBaseOpened($updateSql);
        SoftParameterMan::dataBaseList(false);*/

        // 传感器
/*        $insertSql = "{\"sensorName\":\"温控传感器01\",\"sensorModel\":\"数字型\",\"sensorType\":\"在线式\",\"location\":\"压铸线高架式270压铸\",\"address\":10230,\"sensorPort\":2008,\"connected\":0}";
        MachineMan::addNewSensor($insertSql);*/
//        MachineMan::sensorList(false);
//        $updateJson = "{\"sensorId\":\"1\",\"sensorName\":\"温控传感器01修改后\",\"sensorModel\":\"数字型\",\"sensorType\":\"在线式\",\"sensorPort\":\"2008\",\"location\":\"压铸线高架式270压铸\",\"address\":\"10230\",\"connected\":\"1\",\"deleted\":\"1\"}";
//        MachineMan::editSensor($updateJson);

        // 新增压铸机
/*        $newMachineJson = "{\"machineName\":\"自动快速卧式冷室压铸机01\",\"machineModel\":\"库卡2010\",\"machineType\":\"自动\",\"port\":2008,\"location\":\"自动压铸机控制车间01\",\"address\":\"10.1.1.1\",\"connectable\":1}";
        MachineMan::addMachine($newMachineJson);*/

        // 编辑压铸机
//        $editedMachineJson = "{\"machineId\":\"1\",\"machineName\":\"自动快速卧式冷室修改后压铸机01\",\"machineModel\":\"库卡2011\",\"machineType\":\"自动\",\"port\":\"20008\",\"location\":\"自动压铸机控制车间02\",\"address\":\"10.1.1.02\",\"connectable\":\"1\",\"deleted\":\"1\"}";
//        MachineMan::editMachine($editedMachineJson);

        // 压铸机列表
//        MachineMan::machineList(true);
//        MachineMan::searchMachine("压铸机");

        // 新增计数器
        $newCounterJson = "{\"counterName\":\"数量计数器01\",\"counterModel\":\"数字型\",\"counterType\":\"十进制\",\"counterPort\":9008,\"counterDecimal\":\"十进制\",\"address\":\"10.1.1.1\",\"connectable\":1}";
//        MachineMan::addCounter($newCounterJson);

        // 编辑计数器
        $editedCounterJson = "{\"counterId\":\"1\",\"counterName\":\"数量计数器修改后02\",\"counterModel\":\"数字型\",\"counterType\":\"二进制\",\"counterPort\":\"900801\",\"counterDecimal\":\"二进制\",\"address\":\"10.1.1.102\",\"connectable\":\"1\",\"deleted\":\"0\"}";
        MachineMan::editCounter($editedCounterJson);

        MachineMan::counterList(true);
        MachineMan::searchCounter("计数器01");
    }else {


        /*
        * action动作
        */
        $action = $_POST['action'];

        if ($action != RoutersEnumUri::login) {
            session_start();
            if (empty($_SESSION["userId"]) || ((int)$_SESSION["userId"]) < 0) {
                $errorCode = ["code" => "-10000"];
                echo json_encode(CodeDBTool::handler(false,$errorCode, "未登录，请重新登录"));
                return;
            }
        }


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
            case RoutersEnumUri::userList:
                {
                    UserMan::userList(true);
                }
                break;
            case RoutersEnumUri::userEdit:
                {
                    UserMan::editUser($_POST['user']);
                }
                break;
            case RoutersEnumUri::userRegist:
                {
                    UserMan::addNewUser($_POST['user']);
                }
                break;
            case RoutersEnumUri::portList:
                {
                    SoftParameterMan::portList(true);
                }
                break;
            case RoutersEnumUri::portEdit:
                {
                    SoftParameterMan::editPort($_POST['port']);
                }
                break;
            case RoutersEnumUri::portAdd:
                {
                    SoftParameterMan::addPort($_POST['port']);
                }
                break;
            case RoutersEnumUri::sensorList:
                {
                    MachineMan::sensorList();
                }
                break;
            case RoutersEnumUri::sensorAdd:
                {
                    MachineMan::addNewSensor($_POST['data']);
                }
                break;
            case RoutersEnumUri::sensorEdit:
                {
                    MachineMan::editSensor($_POST['data']);
                }
                break;
            case RoutersEnumUri::machineList:
                {
                    MachineMan::machineList();
                }
                break;
            case RoutersEnumUri::machineAdd:
                {
                    MachineMan::addMachine($_POST['data']);
                }
                break;
            case RoutersEnumUri::machineEdit:
                {
                    MachineMan::editMachine($_POST['data']);
                }
                break;
            case RoutersEnumUri::counterList:
                {
                    MachineMan::counterList();
                }
                break;
            case RoutersEnumUri::counterAdd:
                {
                    MachineMan::addCounter($_POST['data']);
                }
                break;
            case RoutersEnumUri::counterEdit:
                {
                    MachineMan::editCounter($_POST['data']);
                }
                break;
        }

    }
?>