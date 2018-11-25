<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/14
     * Time: 14:50
     */

    /* import 导入文件 */
    require_once "StatusObject.php";

    /* 是否是调试模式，在调试模式下可以在控制台打印结果 */
    define("CodeZ_DEBUG", false);

    /*修改时区*/
    date_default_timezone_set('Asia/Shanghai');

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

    /* 压铸机查询类型 */
    abstract class CodeZOperatorSearchType
    {
        const SearchByNo = "SearchNo";
        const SearchByTime = "SearchDate";
    }

    /* 将字符前后添加单引号 */
    function CodeZAddApostrophe($apostraopedString) {
        return "'" . $apostraopedString . "'";
    }

    function CodeZGetDateFormatterFromTimeStamp($timeStamp) {
        return date('Y-m-d H:i:s', $timeStamp);
    }

    function CodeZPrintData($printedValue) {
        if (CodeZ_DEBUG) {
            echo  "打印结果: ";
            print_r($printedValue);
        }
    }
?>
