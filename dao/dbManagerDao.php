<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/22
     * Time: 23:01
     */
    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once dirname(__FILE__) . "/../model/dbManager.php";

    class dbManagerDao extends CodeDBTool
    {

        /* 数据库列表 */
        public function dataList($getAll = true) {
            $paramaters= "deleted = 0";

            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::DBMAN, NULL, $getAll ? NULL : $paramaters);

            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach (self::getData($result) as $row) {
                    $db = new dbManager();
                    $db->tableMappers($row);
                    array_push($rowArray, $db);
                }

                self::replaceData($result, $rowArray);
            }

            return $result;

        }

        public function editDataBase(dbManager $db) {
            $values = "dbName = " . CodeZAddApostrophe($db->dbName);
            $values = $values . ", opened = " . $db->opened;
            $values = $values . ", deleted = " . $db->deleted;

            $parameters = "dbId = " . $db->dbId;

            $updateSql = $this->CodeZUpdateSql(CodeZEnumTable::DBMAN, $values, $parameters);
            CodeZPrintData($updateSql);
            $result = self::excuteUpdate($updateSql);

            return $result;
        }

        /* 新增数据库 */
        public function addNewDataBase(dbManager $db) {
            $columns = "dbName, opened";
            $values = CodeZAddApostrophe($db->dbName);
            $values = $values . ", opened = " . $db->opened;

            $insertSql = $this->CodeZInsertSql(CodeZEnumTable::DBMAN, $columns, $values);

            $result = self::excuteUpdate($insertSql);

            return $result;
        }
    }
?>