<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/24
     * Time: 22:01
     */

    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once dirname(__FILE__) . "/../model/machine.php";

    class machineDao extends CodeDBTool
    {

        /* 压铸机列表 */
        public function machineList($getAll = true) {
            $parameters = "deleted = 0";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::MACHINE, NULL, $getAll ? NULL : $parameters);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $machine = new machine();
                    $machine->tableMappers($row);
                    array_push($rowArray, $machine);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }

        /* 新增压铸机 */
        public function addMachine(machine $machine)
        {
            $columns = "machineName,  machineModel, machineType, port, location, address, connectable";
            $values = CodeZAddApostrophe($machine->machineName);
            $values = $values . ", " . CodeZAddApostrophe($machine->machineModel);
            $values = $values . ", " . CodeZAddApostrophe($machine->machineType);
            $values = $values . ", " . CodeZAddApostrophe($machine->port);
            $values = $values . ", " . CodeZAddApostrophe($machine->location);
            $values = $values . ", " . CodeZAddApostrophe($machine->address);
            $values = $values . ", " . $machine->connectable;

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::MACHINE, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 修改压铸机 */
        public function editMachine(machine $machine)
        {
            $columns = "machineName = " . CodeZAddApostrophe($machine->machineName);
            $columns = $columns . ", machineModel = " . CodeZAddApostrophe($machine->machineModel);
            $columns = $columns . ", machineType = " . CodeZAddApostrophe($machine->machineType);
            $columns = $columns . ", port = " . CodeZAddApostrophe($machine->port);
            $columns = $columns . ", location = " . CodeZAddApostrophe($machine->location);
            $columns = $columns . ", address = " . CodeZAddApostrophe($machine->address);
            $columns = $columns . ", connectable = " . $machine->connectable;
            $columns = $columns . ", deleted = " . $machine->deleted;

            $parameters = "machineId = " . $machine->machineId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::MACHINE, $columns, $parameters);

            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 查询数据 */
        public function searchMachineList($searchString)
        {
            $parameters = "deleted = 0 " . "AND machineName like '%" . $searchString . "%'";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::MACHINE, NULL, $parameters);
            CodeZPrintData($sqlString);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $machine = new machine();
                    $machine->tableMappers($row);
                    array_push($rowArray, $machine);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }
    }