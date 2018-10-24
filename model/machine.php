<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 21:52
     */

    require_once dirname(__FILE__) . "/../tool/CodeZObject.php";

    class machine implements CodeZObject
    {
        public $machineId;
        public $machineName;
        public $machineModel;
        public $machineType;
        public $port;
        public $location;
        public $address;
        public $connectable;
        public $deleted;

        public function tableMappers($tableArray)
        {
            // TODO: Implement tableMappers() method.
            if (is_array($tableArray)) {
                if (isset($tableArray['machineId'])) {
                    $this->machineId = $tableArray['machineId'];
                }
                if (isset($tableArray['machineName'])) {
                    $this->machineName = $tableArray['machineName'];
                }
                if (isset($tableArray['machineModel'])) {
                    $this->machineModel = $tableArray['machineModel'];
                }
                if (isset($tableArray['machineType'])) {
                    $this->machineType = $tableArray['machineType'];
                }
                if (isset($tableArray['port'])) {
                    $this->port = $tableArray['port'];
                }
                if (isset($tableArray['location'])) {
                    $this->location = $tableArray['location'];
                }
                if (isset($tableArray['address'])) {
                    $this->address = $tableArray['address'];
                }
                if (isset($tableArray['connectable'])) {
                    $this->connectable = $tableArray['connectable'];
                }
                if (isset($tableArray['deleted'])) {
                    $this->deleted = $tableArray['deleted'];
                }
            }
        }

        public function modelWithJson($jsonString)
        {
            // TODO: Implement modelWithJson() method.
            $tableArray = json_decode($jsonString, true);
            $this->tableMappers($tableArray);
        }
    }
?>