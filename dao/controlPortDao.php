<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/21
     * Time: 22:01
     */

    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once dirname(__FILE__) . "/../model/controlPort.php";

    class controlPortDao extends CodeDBTool
    {

        function addNewPort(controlPort $port) {
            if (empty($port->portName)) {
                return self::handler(false, null, "端口名称不能为空");
            }
            if (empty($port->remoteProtocol)) {
                return self::handler(false, null, "请设置协议");
            }
            if (empty($port->remotePort)) {
                return self::handler(false, null, "请设置端口号");
            }
            if (empty($port->remoteHost)) {
                return self::handler(false, null, "请设置远程主机");
            }
            if (empty($port->controlMethod)) {
                return self::handler(false, null, "请设置控制方式");
            }
            if (empty($port->remoteUsr)) {
                return self::handler(false, null, "请输入用户名");
            }
            if (empty($port->remotePwd)) {
                return self::handler(false, null, "请输入密码");
            }
            $columns = "portName,  remoteIp, remoteProtocol, remotePort, remoteHost,  controlMethod, remoteUsr, remotePwd, updateTime";
            $values = CodeZAddApostrophe($port->portName);
            $values = $values . ", " . CodeZAddApostrophe($port->remoteIp);
            $values = $values . ", " . CodeZAddApostrophe($port->remoteProtocol);
            $values = $values . ", " . CodeZAddApostrophe($port->remotePort);
            $values = $values . ", " . CodeZAddApostrophe($port->remoteHost);
            $values = $values . ", " . CodeZAddApostrophe($port->controlMethod);
            $values = $values . ", " . CodeZAddApostrophe($port->remoteUsr);
            $values = $values . ", " . CodeZAddApostrophe($port->remotePwd);
            $values = $values . ", " . CodeZAddApostrophe(CodeZNowDateY_M_D_HMS);

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::CTRLPORT, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        function editPort(controlPort $editedPort) {
            if (empty($editedPort->portName)) {
                return self::handler(false, null, "端口名称不能为空");
            }
            if (empty($editedPort->remoteProtocol)) {
                return self::handler(false, null, "请设置协议");
            }
            if (empty($editedPort->remotePort)) {
                return self::handler(false, null, "请设置端口号");
            }
            if (empty($editedPort->remoteHost)) {
                return self::handler(false, null, "请设置远程主机");
            }
            if (empty($editedPort->controlMethod)) {
                return self::handler(false, null, "请设置控制方式");
            }
            if (empty($editedPort->remoteUsr)) {
                return self::handler(false, null, "请输入用户名");
            }
            if (empty($editedPort->remotePwd)) {
                return self::handler(false, null, "请输入密码");
            }
            $columns = "portName = " . CodeZAddApostrophe($editedPort->portName);
            $columns = $columns . ", remoteIp = " . CodeZAddApostrophe($editedPort->remoteIp);
            $columns = $columns . ", remoteProtocol = " . CodeZAddApostrophe($editedPort->remoteProtocol);
            $columns = $columns . ", remotePort = " . CodeZAddApostrophe($editedPort->remotePort);
            $columns = $columns . ", remoteHost = " . CodeZAddApostrophe($editedPort->remoteHost);
            $columns = $columns . ", controlMethod = " . CodeZAddApostrophe($editedPort->controlMethod);
            $columns = $columns . ", remoteUsr = " . CodeZAddApostrophe($editedPort->remoteUsr);
            $columns = $columns . ", remotePwd = " . CodeZAddApostrophe($editedPort->remotePwd);
            $columns = $columns . ", updateTime = " . CodeZAddApostrophe(CodeZNowDateY_M_D_HMS);
            $columns = $columns . ", deleted = " . $editedPort->deleted;

            $parameters = "portId = " . $editedPort->portId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::CTRLPORT, $columns, $parameters);

            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        function portList($getAll = true) {
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::CTRLPORT, NULL, NULL);
            $result = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $ctrlPort = new controlPort();
                    $ctrlPort->tableMappers($row);
                    array_push($rowArray, $ctrlPort);
                }

                $result['data'] = $rowArray;
            }

            return $result;
        }
    }
?>