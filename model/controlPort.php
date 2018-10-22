<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 21:44
     */

    require_once dirname(__FILE__) . "/../tool/CodeZObject.php";

    class controlPort implements CodeZObject
    {
        public $portId;
        public $portName;
        public $remoteIp;
        public $remoteProtocol;
        public $remotePort;
        public $remoteHost;
        public $controlMethod;
        public $remoteUsr;
        public $remotePwd;
        public $deleted;

        public function tableMappers($tableArray)
        {
            // TODO: Implement tableMappers() method.
            if (is_array($tableArray)) {
                if (isset($tableArray['portId'])) {
                    $this->portId = $tableArray['portId'];
                }
                if (isset($tableArray['portName'])) {
                    $this->portName = $tableArray['portName'];
                }
                if (isset($tableArray['remoteIp'])) {
                    $this->remoteIp = $tableArray['remoteIp'];
                }
                if (isset($tableArray['remoteProtocol'])) {
                    $this->remoteProtocol = $tableArray['remoteProtocol'];
                }
                if (isset($tableArray['remotePort'])) {
                    $this->remotePort = $tableArray['remotePort'];
                }
                if (isset($tableArray['remoteHost'])) {
                    $this->remoteHost = $tableArray['remoteHost'];
                }
                if (isset($tableArray['controlMethod'])) {
                    $this->controlMethod = $tableArray['controlMethod'];
                }
                if (isset($tableArray['remoteUsr'])) {
                    $this->remoteUsr = $tableArray['remoteUsr'];
                }
                if (isset($tableArray['remotePwd'])) {
                    $this->remotePwd = $tableArray['remotePwd'];
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