<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 21:42
     */

    require_once dirname(__FILE__) . "/../tool/CodeZObject.php";

    class controlParameter implements CodeZObject
    {
        public $ctrlId;
        public $ctrlNo;
        public $rollWeight;
        public $material;
        public $rollNumber;
        public $rollIntervals;
        public $rollPressure;
        public $rollName;
        public $rollTimes;
        public $deleted;

        public function tableMappers($tableArray)
        {
            // TODO: Implement tableMappers() method.
            if (is_array($tableArray)) {
                if (isset($tableArray['ctrlId'])) {
                    $this->ctrlId = $tableArray['ctrlId'];
                }
                if (isset($tableArray['ctrlNo'])) {
                    $this->ctrlNo = $tableArray['ctrlNo'];
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
                if (isset($tableArray['rollIntervals'])) {
                    $this->rollIntervals = $tableArray['rollIntervals'];
                }
                if (isset($tableArray['rollPressure'])) {
                    $this->rollPressure = $tableArray['rollPressure'];
                }
                if (isset($tableArray['rollName'])) {
                    $this->rollName = $tableArray['rollName'];
                }
                if (isset($tableArray['rollTimes'])) {
                    $this->rollTimes = $tableArray['rollTimes'];
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