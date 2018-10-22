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
            $columns = "portName,  remoteIp, remoteProtocol, remotePort, remoteHost,  controlMethod, remoteUsr, remotePwd";
            $values = CodeZAddApostrophe($port->portName);
            $values = $values . ", " . CodeZAddApostrophe($port->remoteIp);
            $values = $values . ", " . CodeZAddApostrophe($port->remoteProtocol);
            $values = $values . ", " . CodeZAddApostrophe($port->remotePort);
            $values = $values . ", " . CodeZAddApostrophe($port->remoteHost);
            $values = $values . ", " . CodeZAddApostrophe($port->controlMethod);
            $values = $values . ", " . CodeZAddApostrophe($port->remoteUsr);
            $values = $values . ", " . CodeZAddApostrophe($port->remotePwd);

            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::CTRLPORT, $columns, $values);
            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }

        function editPort(controlPort $editedPort) {
            $columns = "portName = " . CodeZAddApostrophe($editedPort->portName);
            $columns = $columns . ", remoteIp = " . CodeZAddApostrophe($editedPort->remoteIp);
            $columns = $columns . ", remoteProtocol = " . CodeZAddApostrophe($editedPort->remoteProtocol);
            $columns = $columns . ", remotePort = " . CodeZAddApostrophe($editedPort->remotePort);
            $columns = $columns . ", remoteHost = " . CodeZAddApostrophe($editedPort->remoteHost);
            $columns = $columns . ", controlMethod = " . CodeZAddApostrophe($editedPort->controlMethod);
            $columns = $columns . ", remoteUsr = " . CodeZAddApostrophe($editedPort->remoteUsr);
            $columns = $columns . ", remotePwd = " . CodeZAddApostrophe($editedPort->remotePwd);
            $columns = $columns . ", deleted = " . $editedPort->deleted;

            $parameters = "portId = " . $editedPort->portId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::CTRLPORT, $columns, $parameters);

            CodeZPrintData($sqlString);

            return self::excuteUpdate($sqlString);
        }
    }
?>