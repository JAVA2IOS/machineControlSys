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
    }
?>