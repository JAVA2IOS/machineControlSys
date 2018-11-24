<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/20
     * Time: 16:35
     */

    require_once dirname(__FILE__) . "/../dao/sensorDao.php";
    require_once dirname(__FILE__) . "/../dao/machineDao.php";
    require_once dirname(__FILE__) . "/../dao/counterDao.php";
    require_once dirname(__FILE__) . "/../dao/controlParameterDao.php";
    require_once dirname(__FILE__) . "/../dao/dbManagerDao.php";

    /*
     * 压铸机配置
     * */

    class MachineMan
    {

        /*
         * 控制传感器
         * */

        /* 新增传感器 */
        public static function addNewSensor($sensorJson)
        {
            $sensorDao = new sensorDao();
            $sensor    = new sensor();
            $sensor->modelWithJson($sensorJson);

            CodeZPrintData($sensor);

            echo json_encode($sensorDao->addSensor($sensor));
        }

        /* 传感器列表 */
        public static function sensorList($getAll = true)
        {
            $sensorDao = new sensorDao();
            echo json_encode($sensorDao->sensorList($getAll));
        }

        /* 修改传感器 */
        public static function editSensor($sensorJson)
        {
            $sensorDao = new sensorDao();
            $sensor    = new sensor();
            $sensor->modelWithJson($sensorJson);

            echo json_encode($sensorDao->editSensor($sensor));
        }


        /*
         * 压铸机配置
         * */

        /* 压铸机列表 */
        public static function machineList($getAll = true)
        {
            $machineDao = new machineDao();
            echo json_encode($machineDao->machineList($getAll));
        }

        /* 新增压铸机 */
        public static function addMachine($machineJson)
        {
            $machineDao = new machineDao();
            $machine    = new machine();
            $machine->modelWithJson($machineJson);
            CodeZPrintData($machine);

            echo json_encode($machineDao->addMachine($machine));
        }

        /* 修改压铸机 */
        public static function editMachine($machineJson)
        {
            $machineDao = new machineDao();
            $machine    = new machine();
            $machine->modelWithJson($machineJson);
            CodeZPrintData($machine);

            echo json_encode($machineDao->editMachine($machine));
        }

        /* 查询压铸机 */
        public static function searchMachine($searchString)
        {
            $machineDao = new machineDao();

            echo json_encode($machineDao->searchMachineList($searchString));
        }

        /*
         * 计数器配置
         * */

        /* 计数器列表 */
        public static function counterList($getAll = true)
        {
            $counterDao = new counterDao();
            echo json_encode($counterDao->counterList($getAll));
        }

        /* 新增计数器 */
        public static function addCounter($counterJson)
        {
            $counterDao = new counterDao();
            $counter    = new counter();
            $counter->modelWithJson($counterJson);
            CodeZPrintData($counter);

            echo json_encode($counterDao->addCounter($counter));
        }

        /* 计数器配置 */
        public static function editCounter($counterJson)
        {
            $counterDao = new counterDao();
            $counter    = new counter();
            $counter->modelWithJson($counterJson);
            CodeZPrintData($counter);

            echo json_encode($counterDao->editCounter($counter));
        }

        /* 计数器查询 */
        public static function searchCounter($searchString)
        {
            $counterDao = new counterDao();

            echo json_encode($counterDao->searchCounterList($searchString));
        }


        /* 控制参数列表 */
        public static function controlParametersList($getAll = true)
        {
            $parametersDao = new controlParameterDao();
            echo json_encode($parametersDao->parametersList($getAll));
        }

        /* 更新控制参数 */
        public static function editControlParameters($parametersJsonString)
        {
            $parametersDao = new controlParameterDao();
            $parameters    = new controlParameter();
            $parameters->modelWithJson($parametersJsonString);
            CodeZPrintData($parameters);

            echo json_encode($parametersDao->editParameters($parameters));
        }


        /* 新增控制参数 */
        public static function addControlParameters($parametersJsonString)
        {
            $parametersDao = new controlParameterDao();
            $parameters    = new controlParameter();
            $parameters->modelWithJson($parametersJsonString);

            echo json_encode($parametersDao->addParameters($parameters));
        }


        /* 数据库列表 */
        public static function dataBaseList($getAll = true)
        {
            $dbDao = new dbManagerDao();
            echo json_encode($dbDao->dataList($getAll));
        }
        /* 新增数据库 */
        public static function addDataBase($dataBaseJsonString)
        {
            $dbDao = new dbManagerDao();
            $dataBase = new dbManager();
            $dataBase->modelWithJson($dataBaseJsonString);

            echo json_encode($dbDao->addNewDataBase($dataBase));
        }
        /* 修改数据库 */
        public static function editDataBase($dataBaseJsonString)
        {
            $dbDao = new dbManagerDao();
            $dataBase = new dbManager();
            $dataBase->modelWithJson($dataBaseJsonString);

            echo json_encode($dbDao->editDataBase($dataBase));
        }
    }

?>