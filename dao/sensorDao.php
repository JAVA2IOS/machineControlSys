<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/23
     * Time: 22:44
     */

    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once dirname(__FILE__) . "/../model/sensor.php";

    class sensorDao extends CodeDBTool
    {

        /* 传感器注册 */
        function addSensor(sensor $sensor) {
            $emptyData = self::emptyDataObj($sensor);
            if (!empty($emptyData)) {
                return $emptyData;
            }

            $columns = "sensorName,  sensorModel, sensorType, location, address, sensorPort,  connected";
            $values = CodeZAddApostrophe($sensor->sensorName);
            $values = $values . ", " . CodeZAddApostrophe($sensor->sensorModel);
            $values = $values . ", " . CodeZAddApostrophe($sensor->sensorType);
            $values = $values . ", " . CodeZAddApostrophe($sensor->location);
            $values = $values . ", " . CodeZAddApostrophe($sensor->address);
            $values = $values . ", " . CodeZAddApostrophe($sensor->sensorPort);
            if (empty($sensor->connected)) {
                $sensor->connected = 0;
            }
            $values = $values . ", " . $sensor->connected;

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::SENSOR, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 修改传感器(维护、注销、测试链接) */
        function editSensor(sensor $sensor) {
            $emptyData = self::emptyDataObj($sensor);
            if (!empty($emptyData)) {
                return $emptyData;
            }
            if (empty($sensor->connected)) {
                $sensor->connected = 0;
            }
            $columns = "sensorName = " . CodeZAddApostrophe($sensor->sensorName);
            $columns = $columns . ", sensorModel = " . CodeZAddApostrophe($sensor->sensorModel);
            $columns = $columns . ", sensorType = " . CodeZAddApostrophe($sensor->sensorType);
            $columns = $columns . ", location = " . CodeZAddApostrophe($sensor->location);
            $columns = $columns . ", address = " . CodeZAddApostrophe($sensor->address);
            $columns = $columns . ", sensorPort = " . CodeZAddApostrophe($sensor->sensorPort);
            $columns = $columns . ", connected = " . $sensor->connected;
            $columns = $columns . ", deleted = " . $sensor->deleted;

            $parameters = "sensorId = " . $sensor->sensorId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::SENSOR, $columns, $parameters);

            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        function sensorList($getAll = true) {
            $parameters = "deleted = 0";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::SENSOR, NULL, $getAll ? NULL : $parameters);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $sensor = new sensor();
                    $sensor->tableMappers($row);
                    array_push($rowArray, $sensor);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }

        public static function emptyDataObj(sensor $empitedData)
        {
            if (empty($empitedData->sensorName)) {
                return CodeDBTool::handler(false, null, "传感器名称不能为空");
            }
            if (empty($empitedData->sensorType)) {
                return CodeDBTool::handler(false, null, "请设置型号");
            }
            if (empty($empitedData->sensorModel)) {
                return CodeDBTool::handler(false, null, "请设置类型");
            }
            if (empty($empitedData->location)) {
                return CodeDBTool::handler(false, null, "请输入安装位置");
            }
            if (empty($empitedData->sensorPort)) {
                return CodeDBTool::handler(false, null, "请输入端口号");
            }
            if (empty($empitedData->address)) {
                return CodeDBTool::handler(false, null, "请输入地址编号");
            }

            return null;
        }
    }