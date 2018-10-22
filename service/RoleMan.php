<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/20
     * Time: 16:29
     */

    require_once dirname(__FILE__) . "/../dao/roleDao.php";

    class RoleMan
    {

        /* 获取角色列表数据 */
        public static function roleList()
        {
            $roleDao = new roleDao();
            echo json_encode($roleDao->roleList());
        }
    }
?>