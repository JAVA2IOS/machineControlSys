<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/20
     * Time: 16:35
     */

    require_once dirname(__FILE__) . "/../dao/sensorDao.php";

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
            $sensor = new sensor();
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
        public static function editSensor($sensorJson) {
            $sensorDao = new sensorDao();
            $sensor = new sensor();
            $sensor->modelWithJson($sensorJson);
            CodeZPrintData($sensor);

            echo json_encode($sensorDao->editSensor($sensor));
        }


        /*
         * 压铸机配置
         * */

        /* 压铸机列表 */

        /* 新增传感器 */

        /* 查询传感器 */

        /*
         * 计数器配置
         * */

        /* 计数器列表 */

        /* 新增计数器 */

        /* 计数器配置 */

        /* 计数器查询 */
    }
?>