<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/21
     * Time: 15:36
     */

    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once dirname(__FILE__) . "/../model/operator.php";

    /* 自动化控制 */
    class softParameterDao extends CodeDBTool
    {

        public function addOperator(operator $operator)
        {
            $columns = "totalTime,  ctrlId, rollWeight, material, rollNumber, rollIntervals,  rollPressure, rollTimes, openedSensor, openedCounter, openedMachine, startTime, stopTime";
            $values = CodeZAddApostrophe($operator->totalTime);
            $values = $values . ", " . $operator->ctrlId;
            $values = $values . ", " . CodeZAddApostrophe($operator->rollWeight);
            $values = $values . ", " . CodeZAddApostrophe($operator->material);
            $values = $values . ", " . $operator->rollNumber;
            $values = $values . ", " . CodeZAddApostrophe($operator->rollIntervals);
            $values = $values . ", " . CodeZAddApostrophe($operator->rollPressure);
            $values = $values . ", " . $operator->rollTimes;
            $values = $values . ", " . $operator->openedSensor;
            $values = $values . ", " . $operator->openedCounter;
            $values = $values . ", " . $operator->openedMachine;
            $values = $values . ", " . CodeZAddApostrophe($operator->startTime);
            $values = $values . ", " . CodeZAddApostrophe($operator->stopTime);

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::OPERATOR, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 修改传感器(维护、注销、测试链接) */
        function editOperator(operator $operator) {
            $columns = "totalTime = " . CodeZAddApostrophe($operator->totalTime);
            $columns = $columns . ", ctrlId = " . $operator->ctrlId;
            $columns = $columns . ", rollNumber = " . $operator->rollNumber;
            $columns = $columns . ", rollTimes = " . $operator->rollTimes;
            $columns = $columns . ", openedSensor = " . $operator->openedSensor;
            $columns = $columns . ", openedCounter = " . $operator->openedCounter;
            $columns = $columns . ", openedMachine = " . $operator->openedMachine;
            $columns = $columns . ", rollWeight = " . CodeZAddApostrophe($operator->rollWeight);
            $columns = $columns . ", material = " . CodeZAddApostrophe($operator->material);
            $columns = $columns . ", rollIntervals = " . CodeZAddApostrophe($operator->rollIntervals);
            $columns = $columns . ", rollPressure = " . CodeZAddApostrophe($operator->rollPressure);
            $columns = $columns . ", startTime = " . CodeZAddApostrophe($operator->startTime);
            $columns = $columns . ", stopTime = " . CodeZAddApostrophe($operator->stopTime);


            $parameters = "operateId = " . $operator->operateId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::OPERATOR, $columns, $parameters);

            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        function operatorList($getAll = true) {
            $parameters = "deleted = 0";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::OPERATOR, NULL, $getAll ? NULL : $parameters);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $operator = new operator();
                    $operator->tableMappers($row);
                    array_push($rowArray, $operator);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }

        /* 查询数据 */
        public function searchOperatorList($searchString)
        {
            $parameters = "deleted = 0 " . "AND ctrlId like '%" . $searchString . "%'";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::MACHINE, NULL, $parameters);
            CodeZPrintData($sqlString);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $operator = new operator();
                    $operator->tableMappers($row);
                    array_push($rowArray, $operator);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }
    }

?>