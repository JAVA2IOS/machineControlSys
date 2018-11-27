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
    require_once dirname(__FILE__) . "/../dao/userDao.php";
    require_once dirname(__FILE__) . "/../dao/sensorDao.php";
    require_once dirname(__FILE__) . "/../dao/counterDao.php";
    require_once dirname(__FILE__) . "/../model/controlPort.php";
    require_once dirname(__FILE__) . "/../model/dbManager.php";
    require_once dirname(__FILE__) . "/../dao/machineDao.php";

    /*
     * 软件参数管理
     * */

    class SoftParameterMan
    {

        public static function dataIndex()
        {
            $machineDao = new machineDao();
            $dbDao      = new dbManagerDao();
            $usrDao     = new userDao();
            $sensorDao  = new sensorDao();
            $counterDao = new counterDao();

            $dataArray = array();

            $machineListResult = $machineDao->machineList(false);
            if (machineDao::dataExisted($machineListResult)) {
                $dataArray['machine'] = count(machineDao::getData($machineListResult));
            } else {
                $dataArray['machine'] = 0;
            }

            $dbResult = $dbDao->dataList(false);
            if (dbManagerDao::dataExisted($dbResult)) {
                $dataArray['dataBase'] = count(dbManagerDao::getData($dbResult));
            } else {
                $dataArray['dataBase'] = 0;
            }

            $sensorResult = $sensorDao->sensorList(false);
            if (sensorDao::dataExisted($sensorResult)) {
                $dataArray['sensor'] = count(sensorDao::getData($sensorResult));
            } else {
                $dataArray['sensor'] = 0;
            }

            $counterResult = $counterDao->counterList(false);

            if (counterDao::dataExisted($counterResult)) {
                $dataArray['counter'] = count(counterDao::getData($counterResult));
            } else {
                $dataArray['counter'] = 0;
            }

            $usrResult = $usrDao->userList(false);
            if (userDao::dataExisted($usrResult)) {
                $dataArray['users'] = count(userDao::getData($usrResult));
            } else {
                $dataArray['users'] = 0;
            }

            echo json_encode($usrDao::handler(true, $dataArray, null));
        }

        /* 新增控制端口 */
        public static function addPort($portJsonStrng)
        {
            $newPort = new controlPort();
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

        public static function portList($getall = true)
        {
            $portDao = new controlPortDao();

            echo json_encode($portDao->portList($getall));
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
        public static function addDataBase($dbJsonString)
        {
            $dbMan = new dbManager();
            $dbMan->modelWithJson($dbJsonString);
            $dbManDao = new dbManagerDao();

            echo json_encode($dbManDao->addNewDataBase($dbMan));
        }


        public static function addNewOperator($operatorJson)
        {
            $operator = new operator();
            $operator->modelWithJson($operatorJson);

            $manDao = new softParameterDao();

            echo json_encode($manDao->addOperator($operator));
        }

        public static function editOperator($operatorJson)
        {
            $operator = new operator();
            $operator->modelWithJson($operatorJson);

            $manDao = new softParameterDao();

            echo json_encode($manDao->editOperator($operator));
        }

        public static function operatorList($getAll = true)
        {
            $manDao = new softParameterDao();

            echo json_encode($manDao->operatorList($getAll));
        }

        public static function searchOperator($serachJson)
        {
            $manDao = new softParameterDao();

            echo json_encode($manDao->searchParametersList($serachJson));
        }

        public static function searchMachine($searchJson)
        {
            $manDao = new softParameterDao();

            echo json_encode($manDao->searchOperatorList($searchJson));
        }
    }

?>