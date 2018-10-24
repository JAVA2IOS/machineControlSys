<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 21:30
     */

    require_once dirname(__FILE__) . "/../tool/CodeZObject.php";

    class counter implements CodeZObject
    {

        public $counterId;
        /*计数器名称*/
        public $counterName;
        /*型号*/
        public $counterModel;
        /*类型*/
        public $counterType;
        /*端口号*/
        public $counterPort;
        /*进制*/
        public $counterDecimal;
        /*地址*/
        public $address;
        /*是否可链接*/
        public $connectable;

        public $deleted;

        public function tableMappers($tableArray)
        {
            // TODO: Implement tableMappers() method.
            if (is_array($tableArray)) {
                if (isset($tableArray['counterId'])) {
                    $this->counterId = $tableArray['counterId'];
                }
                if (isset($tableArray['counterName'])) {
                    $this->counterName = $tableArray['counterName'];
                }
                if (isset($tableArray['counterModel'])) {
                    $this->counterModel = $tableArray['counterModel'];
                }
                if (isset($tableArray['counterType'])) {
                    $this->counterType = $tableArray['counterType'];
                }
                if (isset($tableArray['counterPort'])) {
                    $this->counterPort = $tableArray['counterPort'];
                }
                if (isset($tableArray['counterDecimal'])) {
                    $this->counterDecimal = $tableArray['counterDecimal'];
                }
                if (isset($tableArray['address'])) {
                    $this->address = $tableArray['address'];
                }
                if (isset($tableArray['connectable'])) {
                    $this->connectable = $tableArray['connectable'];
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