<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/14
     * Time: 14:50
     */

    /* 时间戳 */
    define("CodeZNowTimeStamp", date('Y-m-d', time()));
    define("CodeZNowDate", date('Y-m-d'));
    define("CodeZNowDateYM", date('Y-m'));
    define("CodeZNowDateY_M_D_HMS", date('Y-m-d H:i:s'));

    define("CodeZ_defaults_Number", 0);
    define("CodeZ_true", 1);
    define("CodeZ_false", 0);

    /* 进制枚举 */
    abstract class CodeZEnumDecimal
    {
        const Normal = "十进制";
        const Binary = "二进制";
        const Hex = "十六进制";
    }

    /* 角色枚举 */
    abstract class CodeZEnumRole
    {
        const System = "系统管理员";
        const Normal = "一般用户";
    }

    /* 数据库表名 */
    abstract class CodeZEnumTable
    {
        const USER = "user";
        const ROLE = "role";
        const SENSOR = "ctrlsensor";
        const CTRLPORT = "ctrlport";
        const PARAMETER = "ctrlparameter";
        const COUNTER = "counter";
        const MACHINE = "machine";
        const OPERATOR = "machineoperate";
        const DBMAN = "dbmanager";
    }

    /* 将字符前后添加单引号 */
    function CodeZAddApostrophe($apostraopedString) {
        return "'" . $apostraopedString . "'";
    }
?>