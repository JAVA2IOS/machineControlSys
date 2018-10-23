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
            $columns = "sensorName,  sensorModel, sensorType, location, address, sensorPort,  connected";
            $values = CodeZAddApostrophe($sensor->sensorName);
            $values = $values . ", " . CodeZAddApostrophe($sensor->sensorModel);
            $values = $values . ", " . CodeZAddApostrophe($sensor->sensorType);
            $values = $values . ", " . CodeZAddApostrophe($sensor->location);
            $values = $values . ", " . CodeZAddApostrophe($sensor->address);
            $values = $values . ", " . CodeZAddApostrophe($sensor->sensorPort);
            $values = $values . ", " . $sensor->connected;

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::SENSOR, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 修改传感器(维护、注销、测试链接) */
        function editSensor(sensor $sensor) {
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
    }