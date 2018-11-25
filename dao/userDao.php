<?php
    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
	require_once dirname(__FILE__) . "/../model/user.php";
    require_once dirname(__FILE__) . "/../model/role.php";


	/**
	 * 角色表事物处理
	 */
	class UserDao extends CodeDBTool
	{

		/*
		 * 登录查看
		 * */
		function checkUsr(user $userObject) {
		    $parameters = "userAccount = " . CodeZAddApostrophe($userObject->userAccount) . " AND password = " . CodeZAddApostrophe($userObject->password);
		    $sqlString = $this->CodeZQuerySql(CodeZEnumTable::USER, NULL, $parameters);

		    $result = self::excuteQuery($sqlString);
            if (!$result['success']) {
                return $result;
            }
            if (empty($result['data'])){
                return self::dataEmpty();
            }

            $array = self::getData($result);
            $user = new user();
            $user->tableMappers($array[0]);

            if ($user->deleted) {
                return self::handler(false,null,"该账号已经注销，请切换账号使用");
            }

            $user->lginTime = CodeZNowDateY_M_D_HMS;
            /* 更新登录时间 */
            $this->editUser($user);

            session_start();
            $_SESSION['userId'] = $user->userId;
            $_SESSION['account'] = $user->userAccount;
            $_SESSION['userName'] = $user->userName;
            $_SESSION['dep'] = $user->dep;
            $_SESSION['role'] = $user->role;

            return self::queryUser($user->userId);
        }

        /*
         * 修改用户权限
         * */
        function changeUserPermission(user $userObject) {
            $parameters = "userId = " . $userObject->userId;
            $values = "roleId = " . $userObject->role->roleId;
            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::USER, $values, $parameters);

            $result = self::excuteUpdate($sqlString);

            return $result;
        }

        /*
         * 编辑用户信息(可修改用户的所有信息)
         * */
        function editUser(user $userObject) {

            if (empty($userObject->password)) {
                return self::handler(false,null,"密码不能为空");
            }

            if (empty($userObject->role->roleId)) {
                return self::handler(false,null,"角色不能为空");
            }
            $values = "userName = " . CodeZAddApostrophe($userObject->userName) . ", userAccount = " . CodeZAddApostrophe($userObject->userAccount);
            $values = $values . ", password = " . CodeZAddApostrophe($userObject->password);
            $values = $values . ", roleId = " . $userObject->role->roleId;
            $values = $values . ", loginTime = " . CodeZAddApostrophe($userObject->lginTime);
            $values = $values . ", logoutTime = " . CodeZAddApostrophe($userObject->lgoutTime);
            $values = $values . ", dep = " . CodeZAddApostrophe($userObject->dep);
            $values = $values . ", deleted = " . $userObject->deleted;

            $parameters = "userId = " . $userObject->userId;

            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::USER, $values, $parameters);

            return self::excuteUpdate($sqlString);
        }

        /*
         * 退出登录
         * */
        function logout(user $userObject) {
            $values = "logoutTime = " . CodeZAddApostrophe(CodeZNowDateY_M_D_HMS);
            $parameters = "userId = " . $userObject->userId;
            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::USER, $values, $parameters);

            return self::excuteUpdate($sqlString);
        }

        /*
         * 是否注销用户
         * */
        function userDisable(user $userObject) {
            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::USER, "deleted = " . $userObject->deleted, "userId = " . $userObject->userId);
            return self::excuteUpdate($sqlString);
        }

        /*新增用户*/
        function addNewUser(user $newUser) {
            if (empty($newUser->userAccount)) {
                return self::handler(false,null,"账号不能为空");
            }else {

                $parameter = CodeZEnumTable::USER . ".userAccount = " . CodeZAddApostrophe($newUser->userAccount);
                $sqlString = $this->CodeZQuerySql(CodeZEnumTable::USER,null, $parameter);

                $result = self::excuteQuery($sqlString);

                if (self::dataExisted($result)) {
                    return self::handler(false,null,"账号已经存在，请换个账号");
                }
            }

            if (empty($newUser->password)) {
                return self::handler(false,null,"密码不能为空");
            }

            if (empty($newUser->role->roleId)) {
                return self::handler(false,null,"角色不能为空");
            }

            $columns = "userName, userAccount, password, dep, roleId";
            $valus = CodeZAddApostrophe($newUser->userName) . ", " . CodeZAddApostrophe($newUser->userAccount);
            $valus = $valus . ", " . CodeZAddApostrophe($newUser->password);
            $valus = $valus . ", " . CodeZAddApostrophe($newUser->dep);
            $valus = $valus . ", " . $newUser->role->roleId;
            $sqlString = $this->CodeZInsertSql(CodeZEnumTable::USER, $columns, $valus);

            return self::excuteUpdate($sqlString);
        }

        /* 查找用户 */
        function queryUser($userId) {
            $columns = CodeZEnumTable::USER . ".userId, " . CodeZEnumTable::USER . ".userName, ". CodeZEnumTable::USER . ".userAccount, " . CodeZEnumTable::USER . ".password, " . CodeZEnumTable::USER . ".dep, " . CodeZEnumTable::USER . ".loginTime, " . CodeZEnumTable::USER . ".logoutTime, " . CodeZEnumTable::USER . ".deleted, " . CodeZEnumTable::ROLE . ".roleId, " . CodeZEnumTable::ROLE . ".roleName, " . CodeZEnumTable::ROLE . ".descript";
            $equalColumns = CodeZEnumTable::USER . ".roleId = " .  CodeZEnumTable::ROLE . ".roleId";
            $parameter = CodeZEnumTable::USER . ".userId = " . $userId;
            $sqlString = $this->CodeZQueryLeftJoinSql(CodeZEnumTable::USER, $columns, CodeZEnumTable::ROLE, $equalColumns, $parameter);


            $result = self::excuteQuery($sqlString);

            if (!$result['success']) {
                return $result;
            }
            if (empty($result['data'])){
                return self::dataEmpty();
            }
            $user = new user();
            $user->tableMappers($result['data'][0]);
            $result['data'] = $user;

            return $result;
        }

        /* 用户列表 */
        function userList($getAll) {
            $columns = CodeZEnumTable::USER . ".userId, ";
            $columns = $columns . CodeZEnumTable::USER . ".userName, ";
            $columns = $columns . CodeZEnumTable::USER . ".userAccount, ";
            $columns = $columns . CodeZEnumTable::USER . ".password, ";
            $columns = $columns . CodeZEnumTable::USER . ".dep, ";
            $columns = $columns . CodeZEnumTable::USER . ".loginTime, ";
            $columns = $columns . CodeZEnumTable::USER . ".logoutTime, ";
            $columns = $columns . CodeZEnumTable::USER . ".deleted, ";
            $columns = $columns . CodeZEnumTable::ROLE . ".roleId, ";
            $columns = $columns . CodeZEnumTable::ROLE . ".roleName, ";
            $columns = $columns . CodeZEnumTable::ROLE . ".descript";

            $equalColumns = CodeZEnumTable::USER . ".roleId = " .  CodeZEnumTable::ROLE . ".roleId";

            $parameters = CodeZEnumTable::USER . ".deleted = 0 AND " . CodeZEnumTable::ROLE . ".deleted = 0";
            if (!empty($_SESSION['userId'])) {
                $parameters = CodeZEnumTable::USER . ".userId <> " . $_SESSION['userId'];
            }

            $sqlString = $this->CodeZQueryLeftJoinSql(CodeZEnumTable::USER, $columns, CodeZEnumTable::ROLE, $equalColumns, $getAll ? NULL : $parameters);

            $result = self::excuteQuery($sqlString);

            $userList = array();
            foreach ($result['data'] as $row) {
                $user = new user();
                $user->tableMappers($row);
                array_push($userList, $user);
            }

            $result['data'] = $userList;

            if (self::dataExisted($result)) {
                $result['error'] = $sqlString;
            }

            return $result;
        }
	}
?>