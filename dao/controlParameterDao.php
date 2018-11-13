<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/25
     * Time: 22:19
     */
    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once dirname(__FILE__) . "/../model/controlParameter.php";

    class controlParameterDao extends CodeDBTool
    {
        /* 控制参数列表 */
        public function counterList($getAll = true) {
            $parameters = "deleted = 0";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::PARAMETER, NULL, $getAll ? NULL : $parameters);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $paras = new controlParameter();
                    $paras->tableMappers($row);
                    array_push($rowArray, $paras);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }

        /* 新增控制参数 */
        public function addCounter(controlParameter $controlParameter)
        {
            $columns = "ctrlNo,  rollWeight, material, rollNumber, rollIntervals, rollPressure, rollName, rollTimes";
            $values = CodeZAddApostrophe($controlParameter->ctrlNo);
            $values = $values . ", " . CodeZAddApostrophe($controlParameter->rollWeight);
            $values = $values . ", " . CodeZAddApostrophe($controlParameter->material);
            $values = $values . ", " . $controlParameter->rollNumber;
            $values = $values . ", " . CodeZAddApostrophe($controlParameter->rollIntervals);
            $values = $values . ", " . CodeZAddApostrophe($controlParameter->rollPressure);
            $values = $values . ", " . CodeZAddApostrophe($controlParameter->rollName);
            $values = $values . ", " . $controlParameter->rollTimes;

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::PARAMETER, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 修改控制参数 */
        public function editCounter(controlParameter $controlParameter)
        {
            $columns = "rollName = " . CodeZAddApostrophe($controlParameter->rollName);
            $columns = $columns . ", ctrlNo = " . CodeZAddApostrophe($controlParameter->ctrlNo);
            $columns = $columns . ", rollWeight = " . CodeZAddApostrophe($controlParameter->rollWeight);
            $columns = $columns . ", material = " . CodeZAddApostrophe($controlParameter->material);
            $columns = $columns . ", rollNumber = " .  $controlParameter->rollNumber;
            $columns = $columns . ", rollIntervals = " . CodeZAddApostrophe($controlParameter->rollIntervals);
            $columns = $columns . ", rollPressure = " . CodeZAddApostrophe($controlParameter->rollPressure);
            $columns = $columns . ", rollTimes = " . $controlParameter->rollTimes;
            $columns = $columns . ", deleted = " . $controlParameter->deleted;

            $parameters = "ctrlId = " . $controlParameter->ctrlId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::PARAMETER, $columns, $parameters);

            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 查询控制参数 */
        public function searchCounterList($searchString)
        {
            $parameters = "deleted = 0 " . "AND ctrlNo like '%" . $searchString . "%'";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::PARAMETER, NULL, $parameters);
            CodeZPrintData($sqlString);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $paras = new controlParameter();
                    $paras->tableMappers($row);
                    array_push($rowArray, $paras);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }
    }
?>