<?php
    require_once dirname(__FILE__) . "/../tool/DB.php";
    require_once dirname(__FILE__) . "/../tool/Common.php";
	require_once dirname(__FILE__) . "/../model/user.php";


	/**
	 * 角色表事物处理
	 */
	class UserDao extends CodeDBTool
	{
		
		
		/*function __construct(argument)
		{
			# code...
		}*/

		/*
		 * 登录查看
		 * */
		function checkUsr(user $userObject) {
		    $parameters = "userAccount = " . CodeZAddApostrophe($userObject->userAccount) . " AND password = " . CodeZAddApostrophe($userObject->password);
		    $sqlString = $this->CodeZQuerySql(CodeZEnumTable::USER, NULL, $parameters);
		    echo $sqlString;
		    return self::excuteQuery($sqlString);
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
            if ($result === true) {
                echo "更新权限成功";
            }else {
                echo "更新权限失败";
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
            $columns = CodeZEnumTable::USER . ".userId, " . CodeZEnumTable::USER . ".userName, ". CodeZEnumTable::USER . ".userAccount, " . CodeZEnumTable::USER . ".password, " . CodeZEnumTable::USER . ".roleId as SecondRoleId, " . CodeZEnumTable::USER . ".dep, " . CodeZEnumTable::USER . ".loginTime, " . CodeZEnumTable::USER . ".logoutTime, " . CodeZEnumTable::USER . ".deleted, " . CodeZEnumTable::ROLE . ".roleId, " . CodeZEnumTable::ROLE . ".roleName, " . CodeZEnumTable::ROLE . ".descript, " . CodeZEnumTable::ROLE . ".deleted as roleDeleted";
            $equalColumns = CodeZEnumTable::USER . ".roleId = " .  CodeZEnumTable::ROLE . ".roleId";
            $parameter = CodeZEnumTable::USER . ".userId = " . $userId;
            $sqlString = $this->CodeZQueryLeftJoinSql(CodeZEnumTable::USER, $columns, CodeZEnumTable::ROLE, $equalColumns, $parameter);
            echo $sqlString;
            $result = self::excuteQuery($sqlString);
            if (empty($result)) {
                return NULL;
            } else {
                // 输出数据
                while ($row = mysqli_fetch_assoc($result)) {
                    $role = new role();
                    $role->roleId = $row['SecondRoleId'];
                    $role->roleName = $row['roleName'];
                    $role->descript = $row['descript'];
                    $role->deleted = $row['roleDeleted'];
                    $user = new user($row['userId'], $row['userName'], $row['userAccount'], $row['password'], $role, $row['dep'], $row['loginTime'], $row['logoutTime'], $row['deleted']);
                    return $user;
                }
            }
        }
	}

    $usrDao = new UserDao();
	$user = $usrDao->queryUser("1");
	if (empty($user)) {
	    echo "没有用户数据";
    }else {
	    echo "有数据哦";


	    $user->role->roleId = "2";
	    $usrDao->changeUserPermission($user);
    }

    /*$columns = "userName, userAccount, password, roleId, dep";
    $values = "'admin', 'admin', 'admin', '1', '行政部'";

    $usrDao = new UserDao();
    $sqlString = $usrDao->CodeZInsertSql("user", $columns, $values);
    echo $sqlString;
    UserDao::excuteUpdate($sqlString);
    $result = $usrDao->checkUsr("admin", "admin");
    if (empty($result)) {
        echo "没有数据";
    } else {
        // 输出数据
        while($row = mysqli_fetch_assoc($result)) {
            echo "有数据 :" . $row['userName'] . " dep :" . $row['dep']. "<br>";
        }
    }*/



?>