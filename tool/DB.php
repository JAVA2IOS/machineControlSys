<?php

/**
 * Created by PhpStorm.
 * User: codez
 * Date: 2018年10月13日
 * Time: 21点15分
 */


    define("CodeZUpdate", "update");
    define("CodeZInsert", "insert");
    define("CodeZDeleted", "delete");
    define("SQLERROR_SYNTAX", "SQL_SYNTAX_ERROR");
    define("DATABASE_CONNECT_FAILED", "database connected failed !");
    define("SQLERROR_EXCUTE_FAILED", "SQL_EXCUTE_FAILED");
    define("SQLERROR_DATA_EMPTY", "SQL_DATA_EMPTY");
    define("SQLERROR_SQL_SCENTENCE_EMPTY", "sql is empty !");

    class CodeDBTool
    {

        const insertAction = "insert into";
        const updateAction = "update";
        const deleteAction = "delete from";
        const sqlSentenceSelect = "SELECT";
        const sqlSentenceFrom = "FROM";
        const sqlSentenceWhere = "WHERE";
        const sqlSentenceLeftJoin = "LEFT JOIN";
        const sqlSentenceRightJoin = "RIGHT JOIN";

        /*
         * sql 查询 字符串拼写
         * */
        function CodeZQuerySql($tableName = NULL, $queryColumns = NULL, $parameters = NULL) {
            if (empty($tableName)) {
                return NULL;
            }
            $sqlString = "SELECT ";
            if (empty($queryColumns)) {
                $sqlString = $sqlString . " * FROM " . $tableName;
            }else {
                $sqlString = $sqlString . $queryColumns . " FROM " . $tableName;
            }

            if (empty($parameters)) {
                return $sqlString . ";";
            }

            return $sqlString . " where " . $parameters . ";";
        }

        function CodeZQueryLeftJoinSql($tableName = NULL, $queryColumns = NULL, $leftJoinTable = NULL, $equalColumns = NULL, $parameters = NULL) {
            if (empty($tableName)) {
                return NULL;
            }
            $sqlString = self::sqlSentenceSelect . " ";

            if (empty($queryColumns)) {
                $sqlString = $sqlString . $tableName . ".* " . self::sqlSentenceFrom . " " . $tableName;
            }else {
                $sqlString = $sqlString . $queryColumns . " " . self::sqlSentenceFrom . " " . $tableName;
            }
            if (empty($leftJoinTable)) {
                return NULL;
            }else {
                $sqlString = $sqlString . " " . self::sqlSentenceLeftJoin . " " . $leftJoinTable;
            }

            if (empty($equalColumns)) {
                return NULL;
            }else {
                $sqlString = $sqlString . " ON " . $equalColumns;
            }

            if (empty($parameters)) {
                return $sqlString . ";";
            }

            return $sqlString . " " . self::sqlSentenceWhere . " " . $parameters . ";";
        }

        /*
         * 关于 更新 字符串的拼写
         * */
        function CodeZCommitUpdateSql($commitAction, $tableName = NULL, $queryColumn = NULL, $values = NULL, $parameters = NULL) {
            if (empty($commitAction)) {
                return NULL;
            }

            switch ($commitAction) {
                case CodeZUpdate:
                    return $this->CodeZUpdateSql($tableName, $values, $parameters);
                    break;
                case CodeZInsert:
                    return $this->CodeZInsertSql($tableName, $queryColumn, $values);
                    break;
                case CodeZDeleted:
                    return $this->CodeZDeletedSql($tableName, $parameters);
                    break;
            }

            return NULL;
        }

        /* sql insert */
        function CodeZInsertSql($tableName = NULL, $columns = NULL, $values = NULL) {
            if (empty($tableName)) {
                return NULL;
            }

            $sqlString = self::insertAction . " " . $tableName;

            if (empty($columns)) {

            }else {
                $sqlString = $sqlString . " (" . $columns . ")";
            }

            if (empty($values)) {
                return NULL;
            }else {
                return $sqlString . " VALUES (" . $values . ");";
            }
        }

        /* sql update  */
        function CodeZUpdateSql($tableName = NULL, $values = NULL, $parameters = NULL) {
            if (empty($tableName)) {
                return NULL;
            }

            $sqlString = self::updateAction . " " . $tableName;

            if (empty($values)) {
                return NULL;
            }else {
                $sqlString = $sqlString . " SET " . $values . " ";
            }

            if (empty($parameters)) {
                return $sqlString . ";";
            }else {
                return $sqlString . " WHERE " . $parameters . ";";
            }
        }

        /* sql delete  */
        function CodeZDeletedSql($tableName = NULL, $parameters = NULL) {
            if (empty($tableName)) {
                return NULL;
            }

            $sqlString = self::deleteAction . " " . $tableName;

            if (empty($parameters)) {
                return $sqlString . ";";
            }else {
                return $sqlString . " WHERE " . $parameters . ";";
            }
        }

        /*
        连接数据库
        */
        public static function getConn()
        {
            /* 配置文件数据 */
            $config = parse_ini_file(realpath(dirname(__FILE__).'/../').'/config/cfg.ini');
            $host = $config['databasepath'];
            $username = $config['account'];
            $password = $config['passport'];
            $dbname = $config['database'];

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if ($conn->connect_errno)
            {
                return self::handler(false, NULL, DATABASE_CONNECT_FAILED . " " . $conn->connect_error);
            }

            /* 设置字符串编码，防止乱码问题 */
            $conn->set_charset("utf8");

            return $conn;
        }


        /* excute query data */
        public static function excuteQuery($sqlString)
        {
            // 创建连接
            $conn = self::getConn();
            if (empty($sqlString)) {
                return self::handler(false, NULL,SQLERROR_SQL_SCENTENCE_EMPTY);
            }

            $result = mysqli_query($conn, $sqlString);

            if (empty(mysqli_error($conn))) {
                if (mysqli_num_rows($result) >0) {
                    $rowArray = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        array_push($rowArray, $row);
                    }
                    return self::handler(true, $rowArray, NULL);
                }
                return self::dataEmpty();
            }else {
                return self::handler(false, NULL,SQLERROR_EXCUTE_FAILED . ", reason :" . mysqli_error($conn));
            }
        }

        /* excute update, insert, delete data */
        public static function excuteUpdate($sqlString)
        {
            // 创建连接
            $conn = self::getConn();
            if (empty($sqlString)) {
                return self::handler(false, NULL,SQLERROR_SQL_SCENTENCE_EMPTY);
            }

            if (mysqli_query($conn, $sqlString)) {
                return self::handler(true, "更新成功", NULL);
            } else {
                return self::handler(false, NULL,SQLERROR_EXCUTE_FAILED . ", reason :" . mysqli_error($conn));
            }
        }

        /* 错误信息处理 */
        public static function handler($success = false, $data = NULL, $error = "错误信息未知") {
            return ["success" => $success,
                    "data" => $data,
                    "error" => $error];
        }

        /* 返回状态信息 */
        public static function dataExisted($data)
        {
            return $data['success'];
        }

        /* 返回错误信息 */
        public static function getError($data)
        {
            return $data['error'];
        }

        /* 返回数据 */
        public static function getData($data)
        {
            return $data['data'];
        }

        /* 找不到数据提示 */
        public static function dataEmpty()
        {
            return self::handler(false, NULL, "找不到数据");
        }

        /* 替换数据源 */
        public static function replaceData($result, $datas) {
            $result['data'] = $datas;
        }
    }
?>