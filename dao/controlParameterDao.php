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
        public function parametersList($getAll = true)
        {
            $parameters = "deleted = 0";
            $sqlString  = $this->CodeZQuerySql(CodeZEnumTable::PARAMETER, NULL, $getAll ? NULL : $parameters);
            $result     = self::excuteQuery($sqlString);

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
        public function addParameters(controlParameter $controlParameter)
        {
            $emptyData = self::emptyDataObj($controlParameter);
            if (!empty($emptyData)) {
                return $emptyData;
            }

            $parameters = "ctrlNo = " . CodeZAddApostrophe($controlParameter->ctrlNo);
            $sqlString  = $this->CodeZQuerySql(CodeZEnumTable::PARAMETER, NULL, $parameters);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                return self::handler(false, null, "压铸单号已经存在，请使用其他单号");
            }

            $columns = "ctrlNo,  rollWeight, material, rollNumber, rollIntervals, rollPressure, rollName, rollTimes";
            $values  = CodeZAddApostrophe($controlParameter->ctrlNo);
            $values  = $values . ", " . CodeZAddApostrophe($controlParameter->rollWeight);
            $values  = $values . ", " . CodeZAddApostrophe($controlParameter->material);
            $values  = $values . ", " . $controlParameter->rollNumber;
            $values  = $values . ", " . CodeZAddApostrophe($controlParameter->rollIntervals);
            $values  = $values . ", " . CodeZAddApostrophe($controlParameter->rollPressure);
            $values  = $values . ", " . CodeZAddApostrophe($controlParameter->rollName);
            $values  = $values . ", " . $controlParameter->rollTimes;

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::PARAMETER, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 修改控制参数 */
        public function editParameters(controlParameter $controlParameter)
        {
            $emptyData = self::emptyDataObj($controlParameter);
            if (!empty($emptyData)) {
                return $emptyData;
            }
            $columns = "rollName = " . CodeZAddApostrophe($controlParameter->rollName);
            $columns = $columns . ", ctrlNo = " . CodeZAddApostrophe($controlParameter->ctrlNo);
            $columns = $columns . ", rollWeight = " . CodeZAddApostrophe($controlParameter->rollWeight);
            $columns = $columns . ", material = " . CodeZAddApostrophe($controlParameter->material);
            $columns = $columns . ", rollNumber = " . $controlParameter->rollNumber;
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
        public function searchParametersList($searchString)
        {
            $parameters = "deleted = 0 " . "AND ctrlNo like '%" . $searchString . "%'";
            $sqlString  = $this->CodeZQuerySql(CodeZEnumTable::PARAMETER, NULL, $parameters);
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

        public static function emptyDataObj(controlParameter $controlParameter)
        {
            if (empty($controlParameter->ctrlNo)) {
                return CodeDBTool::handler(false, null, "压铸单号不能为空");
            }
            if (empty($controlParameter->rollName)) {
                return CodeDBTool::handler(false, null, "连铸连轧名称不能为空");
            }
            if (empty($controlParameter->rollWeight)) {
                return CodeDBTool::handler(false, null, "连轧重量不能为空");
            }
            if (empty($controlParameter->material)) {
                return CodeDBTool::handler(false, null, "材质不能为空");
            }
            if (empty($controlParameter->rollNumber)) {
                return CodeDBTool::handler(false, null, "连轧个数不能为空");
            }
            if (empty($controlParameter->rollIntervals)) {
                return CodeDBTool::handler(false, null, "间隔时间不能为空");
            }
            if (empty($controlParameter->rollPressure)) {
                return CodeDBTool::handler(false, null, "压铸压力不能为空");
            }
            if (empty($controlParameter->rollTimes)) {
                return CodeDBTool::handler(false, null, "连铸连轧次数不能为空");
            }


            return null;
        }
    }

?>