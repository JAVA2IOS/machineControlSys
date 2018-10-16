<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 22:04
     */

    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once dirname(__FILE__) . "/../model/role.php";

    /*
     * 角色权限管理
     * */
    class roleDao extends CodeDBTool
    {

        /*
         * 插入角色
         * */
        function insertRole(role $createdRole) {
            $columns = "roleName, descript";
            $values = CodeZAddApostrophe($createdRole->roleName) . "," . CodeZAddApostrophe($createdRole->descript);
            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::ROLE, $columns,$values);
            $result = self::excuteUpdate($sqlString);
            if (self::dataExisted($result)){
                echo "插入成功";
            }else {
                echo "插入失败";
            }
        }
    }


   /* $role = new role();
    $role->roleId = 2;
    $role->roleName = CodeZEnumRole::Normal;
    $role->descript = "只能使用一般查询权限，权限范围较少";


    $roleDao = new roleDao();
    $roleDao->insertRole($role);*/
?>