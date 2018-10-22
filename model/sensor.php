<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 21:48
     */

    require_once dirname(__FILE__) . "/../tool/CodeZObject.php";

    class sensor implements CodeZObject
    {
        public $sensorId;
        public $sensorName;
        public $sensorModel;
        public $sensorType;
        public $location;
        public $address;
        public $connected;
        public $deleted;

        public function tableMappers($tableArray)
        {
            if (is_array($tableArray)) {
                if (isset($tableArray['sensorId'])) {
                    $this->sensorId = $tableArray['sensorId'];
                }
                if (isset($tableArray['sensorName'])) {
                    $this->sensorName = $tableArray['sensorName'];
                }
                if (isset($tableArray['sensorModel'])) {
                    $this->sensorModel = $tableArray['sensorModel'];
                }
                if (isset($tableArray['sensorType'])) {
                    $this->sensorType = $tableArray['sensorType'];
                }
                if (isset($tableArray['location'])) {
                    $this->location = $tableArray['location'];
                }
                if (isset($tableArray['address'])) {
                    $this->address = $tableArray['address'];
                }
                if (isset($tableArray['connected'])) {
                    $this->connected = $tableArray['connected'];
                }
                if (isset($tableArray['deleted'])) {
                    $this->deleted = $tableArray['deleted'];
                }
            }
        }

        public function modelWithJson($jsonString)
        {
            $tableArray = json_decode($jsonString, true);
            $this->tableMappers($tableArray);
        }
    }
?>