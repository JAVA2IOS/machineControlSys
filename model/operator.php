<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 21:54
     */
    require_once dirname(__FILE__) . "/../tool/CodeZObject.php";

    /* 全自动压铸机控制 */
    class operator implements CodeZObject
    {
        public $operateId;
        public $totalTime;
        public $ctrlId;
        public $rollWeight;
        public $material;
        public $rollNumber;
        public $rollIntervals;
        public $rollPressure;
        public $rollTimes;
        public $openedSensor;
        public $openedCounter;
        public $openedMachine;
        public $startTime;
        public $stopTime;

        public function tableMappers($tableArray)
        {
            // TODO: Implement tableMappers() method.
            if (is_array($tableArray)) {
                if (isset($tableArray['operateId'])) {
                    $this->operateId = $tableArray['operateId'];
                }
                if (isset($tableArray['totalTime'])) {
                    $this->totalTime = $tableArray['totalTime'];
                }
                if (isset($tableArray['ctrlId'])) {
                    $this->ctrlId = $tableArray['ctrlId'];
                }
                if (isset($tableArray['rollWeight'])) {
                    $this->rollWeight = $tableArray['rollWeight'];
                }
                if (isset($tableArray['material'])) {
                    $this->material = $tableArray['material'];
                }
                if (isset($tableArray['rollNumber'])) {
                    $this->rollNumber = $tableArray['rollNumber'];
                }
                if (isset($tableArray['rollPressure'])) {
                    $this->rollPressure = $tableArray['rollPressure'];
                }
                if (isset($tableArray['rollIntervals'])) {
                    $this->rollIntervals = $tableArray['rollIntervals'];
                }
                if (isset($tableArray['rollTimes'])) {
                    $this->rollTimes = $tableArray['rollTimes'];
                }
                if (isset($tableArray['openedSensor'])) {
                    $this->openedSensor = $tableArray['openedSensor'];
                }
                if (isset($tableArray['openedCounter'])) {
                    $this->openedCounter = $tableArray['openedCounter'];
                }
                if (isset($tableArray['openedMachine'])) {
                    $this->openedMachine = $tableArray['openedMachine'];
                }
                if (isset($tableArray['startTime'])) {
                    $this->startTime = $tableArray['startTime'];
                }
                if (isset($tableArray['stopTime'])) {
                    $this->stopTime = $tableArray['stopTime'];
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