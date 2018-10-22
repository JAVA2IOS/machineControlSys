<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/20
     * Time: 16:30
     */

    require_once dirname(__FILE__) . "/../dao/softParameterDao.php";
    require_once dirname(__FILE__) . "/../dao/controlPortDao.php";
    require_once dirname(__FILE__) . "/../dao/dbManagerDao.php";
    require_once dirname(__FILE__) . "/../model/controlPort.php";
    require_once dirname(__FILE__) . "/../model/dbManager.php";

    /*
     * 软件参数管理
     * */
    class SoftParameterMan
    {

        /* 新增控制端口 */
        public static function addPort($portJsonStrng)
        {
            $newPort = new  controlPort();
            $newPort->modelWithJson($portJsonStrng);

            $controlPortDao = new controlPortDao();

            echo json_encode($controlPortDao->addNewPort($newPort));
        }

        /* 维护控制端口 */
        public static function editPort($portJsonString)
        {
            $newPort = new  controlPort();
            $newPort->modelWithJson($portJsonString);

            $controlPortDao = new controlPortDao();

            echo json_encode($controlPortDao->editPort($newPort));
        }

        /* 获取数据库列表 */
        public static function dataBaseList($getAll = true)
        {
            $dbManDao = new dbManagerDao();

            echo json_encode($dbManDao->dataList($getAll));
        }

        /* 是否打开数据库，包括维护数据库 */
        public static function checkDataBaseOpened($dbJsonString)
        {
            $dbMan = new dbManager();
            $dbMan->modelWithJson($dbJsonString);
            $dbManDao = new dbManagerDao();

            echo json_encode($dbManDao->editDataBase($dbMan));
        }

        /* 新增数据库 */
        public static function addDataBase($dbJsonString) {
            $dbMan = new dbManager();
            $dbMan->modelWithJson($dbJsonString);
            $dbManDao = new dbManagerDao();

            echo json_encode($dbManDao->addNewDataBase($dbMan));
        }
    }
?>