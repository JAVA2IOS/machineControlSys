<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/17
     * Time: 22:26
     */

    require_once dirname(__FILE__) . "/../dao/userDao.php";

    /* 用户管理 */
    class UserMan
    {
        /*登录*/
        public static function userLogin($userAccount, $password)
        {
            $userDao = new UserDao();
            $user = new user();
            $user->userAccount = $userAccount;
            $user->password = $password;
            $data = $userDao->checkUsr($user);

            echo json_encode($data);
        }

        /*退出*/
        public static function userLogout($userJsonString)
        {
            $userDao = new UserDao();
            $obj = json_decode($userJsonString);
            $user = new user($obj->userId, $obj->userName, $obj->userAccount, $obj->password, NULL, $obj->dep, $obj->loginTime, $obj->logoutTime, $obj->deleted);

            $data = $userDao->logout($user);
            echo json_encode($data);
        }

        /*修改权限*/
        public static function userChangePermission($userJsonString)
        {
            $userDao = new UserDao();
//            $userDao->changeUserPermission()
        }

        /* 修改密码 */
        public static function changeUserPassword($userJsonString)
        {
            $obj = json_decode($userJsonString);
            $userDao = new UserDao();
            $userDao->editUser($obj);
        }

        /*新增用户*/
        public static function addNewUser($userJsonString)
        {
            
        }
    }
?>