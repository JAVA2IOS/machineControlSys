<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/24
     * Time: 22:57
     */

    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once dirname(__FILE__) . "/../model/counter.php";

    class counterDao extends CodeDBTool
    {
        /* 计数器列表 */
        public function counterList($getAll = true) {
            $parameters = "deleted = 0";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::COUNTER, NULL, $getAll ? NULL : $parameters);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $counter = new counter();
                    $counter->tableMappers($row);
                    array_push($rowArray, $counter);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }

        /* 新增计数器 */
        public function addCounter(counter $counter)
        {
            $columns = "counterName,  counterModel, counterType, counterPort, counterDecimal, address, connectable";
            $values = CodeZAddApostrophe($counter->counterName);
            $values = $values . ", " . CodeZAddApostrophe($counter->counterModel);
            $values = $values . ", " . CodeZAddApostrophe($counter->counterType);
            $values = $values . ", " . CodeZAddApostrophe($counter->counterPort);
            $values = $values . ", " . CodeZAddApostrophe($counter->counterDecimal);
            $values = $values . ", " . CodeZAddApostrophe($counter->address);
            $values = $values . ", " . $counter->connectable;

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::COUNTER, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 修改计数器 */
        public function editCounter(counter $counter)
        {
            $columns = "counterName = " . CodeZAddApostrophe($counter->counterName);
            $columns = $columns . ", counterModel = " . CodeZAddApostrophe($counter->counterModel);
            $columns = $columns . ", counterType = " . CodeZAddApostrophe($counter->counterType);
            $columns = $columns . ", counterPort = " . CodeZAddApostrophe($counter->counterPort);
            $columns = $columns . ", counterDecimal = " . CodeZAddApostrophe($counter->counterDecimal);
            $columns = $columns . ", address = " . CodeZAddApostrophe($counter->address);
            $columns = $columns . ", connectable = " . $counter->connectable;
            $columns = $columns . ", deleted = " . $counter->deleted;

            $parameters = "counterId = " . $counter->counterId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::COUNTER, $columns, $parameters);

            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        /* 查询数据 */
        public function searchCounterList($searchString)
        {
            $parameters = "deleted = 0 " . "AND counterName like '%" . $searchString . "%'";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::COUNTER, NULL, $parameters);
            CodeZPrintData($sqlString);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $counter = new counter();
                    $counter->tableMappers($row);
                    array_push($rowArray, $counter);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;
        }
    }