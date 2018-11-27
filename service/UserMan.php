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
            CodeZPrintData($userAccount . ' ' . $password);
            $userDao = new UserDao();
            $user = new user();
            $user->userAccount = $userAccount;
            $user->password = $password;
            $data = $userDao->checkUsr($user);

            echo json_encode($data);
        }

        /*退出*/
        public static function userLogout()
        {
            $userDao = new UserDao();
            $user = new user();

            session_start();
            $user->userId = $_SESSION['userId'];
            session_destroy();

            $data = $userDao->logout($user);
            echo json_encode($data);
        }

        /*修改权限*/
        public static function userChangePermission($userJsonString)
        {
            self::editUser($userJsonString);
        }

        /* 修改密码 */
        public static function changeUserPassword($userJsonString)
        {
            self::editUser($userJsonString);
        }

        /*新增用户*/
        public static function addNewUser($userJsonString)
        {
            $userDao = new UserDao();
            $user = new user();
            $user->modelWithJson($userJsonString);
            CodeZPrintData($user);

            echo json_encode($userDao->addNewUser($user));
        }

        /* 更新用户信息，修改密码，更新权限，删除用户等 */
        public static function editUser($userJsonString)
        {
            $userDao = new UserDao();
            $user = new user();
            $user->modelWithJson($userJsonString);
            CodeZPrintData($user);

            echo json_encode($userDao->editUser($user));
        }

        public static function userList($getAll)
        {
            $userDao = new UserDao();

            echo json_encode($userDao->userList($getAll));
        }
    }
?>