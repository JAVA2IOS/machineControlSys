<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 21:50
     */

    require_once dirname(__FILE__) . "/../tool/CodeZObject.php";

    class dbManager implements CodeZObject
    {
        public $dbId;
        public $dbName;
        public $opened;
        public $deleted;

        public function tableMappers($tableArray)
        {
            // TODO: Implement tableMappers() method.
            if (is_array($tableArray)) {
                if (isset($tableArray['dbId'])) {
                    $this->dbId = $tableArray['dbId'];
                }
                if (isset($tableArray['dbName'])) {
                    $this->dbName = $tableArray['dbName'];
                }
                if (isset($tableArray['opened'])) {
                    $this->opened = $tableArray['opened'];
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