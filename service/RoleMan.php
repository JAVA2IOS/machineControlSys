<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/20
     * Time: 16:29
     */

    require_once dirname(__FILE__) . "/../dao/roleDao.php";
    require_once dirname(__FILE__) . "/../model/role.php";

    class RoleMan
    {

        /* 获取角色列表数据 */
        public static function roleList()
        {
            $roleDao = new roleDao();
            echo json_encode($roleDao->roleList());
        }

        public static function addRole($roleJsonString)
        {
            $roleDao = new roleDao();
            $role = new role();
            $role->modelWithJson($roleJsonString);
            echo json_encode($roleDao->insertRole($role));
        }

        public static function editRole($roleJsonString)
        {
            $roleDao = new roleDao();
            $role = new role();
            $role->modelWithJson($roleJsonString);
            echo json_encode($roleDao->editRole($role));
        }
    }

?>