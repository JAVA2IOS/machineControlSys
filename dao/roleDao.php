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
        function insertRole(role $createdRole)
        {
            $columns   = "roleName, descript";
            $values    = CodeZAddApostrophe($createdRole->roleName) . "," . CodeZAddApostrophe($createdRole->descript);
            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::ROLE, $columns, $values);
            return self::excuteUpdate($sqlString);
        }/*
         * 插入角色
         * */
        function editRole(role $createdRole)
        {
            $columns = "roleName = " . CodeZAddApostrophe($createdRole->roleName);
            $columns = $columns . ", descript = " . CodeZAddApostrophe($createdRole->descript);
            $columns = $columns . ", deleted = " . $createdRole->deleted;

            $parameters = "roleId = " . $createdRole->roleId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::ROLE, $columns, $parameters);
            return self::excuteUpdate($sqlString);
        }

        /* 角色列表 */
        function roleList($getAll = true)
        {
            $parameters = "deleted = 0";
            $sqlString = $this->CodeZQuerySql(CodeZEnumTable::ROLE, NULL, $getAll ? NULL : $parameters);
            $result    = self::excuteQuery($sqlString);

            if (self::dataExisted($result)) {
                $rowArray = array();
                foreach ($result['data'] as $row) {
                    $role = new role();
                    $role->tableMappers($row);
                    array_push($rowArray, $role);
                }

                $result['data'] = $rowArray;
            }

            return $result;
        }
    }

?>