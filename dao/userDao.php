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
                return self::getError($result);
            }
            if (empty($result['data'])){
                return self::dataEmpty();
            }

            $array = self::getData($result);
            $user = new user();
            $user->tableMappers($array);
            $user->lginTime = CodeZNowDateY_M_D_HMS;
            /* 更新登录时间 */
            $this->editUser($user);
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
                return self::getError($result);
            }
            if (empty($result['data'])){
                return self::dataEmpty();
            }
            $user = new user();
            $user->tableMappers($result['data']);
            $result['data'] = $user;
            return $result;
        }
	}

/*    $usrDao = new UserDao();
	$user = $usrDao->queryUser("1");

	$jsonString = json_encode($user);
	$newUser = new user();
	$newUser = json_decode($jsonString);
	echo $newUser->role->roleName;*/


?>