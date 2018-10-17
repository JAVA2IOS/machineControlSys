<?php
    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
	require_once dirname(__FILE__) . "/../model/user.php";


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
            $statusObj = new StatusObject();
            $statusObj = json_decode(json_encode($result));
            if (empty($statusObj->data)){
                return self::dataEmpty();
            }
		    $user = new user();
		    $user = $statusObj->data;

		    return self::queryUser($user->userId);
        }

        /*
         * 修改用户权限
         * */
        function changeUserPermission(user $userObject) {
            $parameters = "userId = " . $userObject->userId;
            echo  "parameters" . $parameters;
            $values = "roleId = " . $userObject->role->roleId;
            $sqlString = $this->CodeZUpdateSql(CodeZEnumTable::USER, $values, $parameters);
            $result = self::excuteUpdate($sqlString);
            echo $sqlString;
            if (self::dataExisted($result)) {
                echo self::getData($result);
            }else {
                echo self::getError($result);
            }
        }

        /*
         * 编辑用户信息(可修改用户的所有信息)
         * */
        function editUser(user $userObject) {

        }

        /*
         * 退出登录
         * */
        function logout(user $userObject) {

        }

        /*
         * 是否注销用户
         * */
        function userDisable(user $userObject) {

        }

        function queryUser($userId) {
            $columns = CodeZEnumTable::USER . ".userId, " . CodeZEnumTable::USER . ".userName, ". CodeZEnumTable::USER . ".userAccount, " . CodeZEnumTable::USER . ".password, " . CodeZEnumTable::USER . ".dep, " . CodeZEnumTable::USER . ".loginTime, " . CodeZEnumTable::USER . ".logoutTime, " . CodeZEnumTable::USER . ".deleted, " . CodeZEnumTable::ROLE . ".roleId, " . CodeZEnumTable::ROLE . ".roleName, " . CodeZEnumTable::ROLE . ".descript";
            $equalColumns = CodeZEnumTable::USER . ".roleId = " .  CodeZEnumTable::ROLE . ".roleId";
            $parameter = CodeZEnumTable::USER . ".userId = " . $userId;
            $sqlString = $this->CodeZQueryLeftJoinSql(CodeZEnumTable::USER, $columns, CodeZEnumTable::ROLE, $equalColumns, $parameter);
            return self::excuteQuery($sqlString);
        }
	}

/*    $usrDao = new UserDao();
	$user = $usrDao->queryUser("1");

	$jsonString = json_encode($user);
	$newUser = new user();
	$newUser = json_decode($jsonString);
	echo $newUser->role->roleName;*/


?>