<?php
    require_once dirname(__FILE__) . "/../tool/Common.php";
    require_once"role.php";
    /*
     * 角色类
     * */
    class user {
        /*用户Id*/
        public $userId;
        /*
         * 用户姓名
         * */
        public $userName;
        /*
         * 登录账号
         * */
        public $userAccount;
        /*
         * 密码
         * */
        public $password;
        /*
         * 角色
         * */
        public $role;
        /*
         * 部门
         * */
        public $dep;
        /*
         * 登录时间
         * */
        public $lginTime;
        /*
         * 注销时间
         * */
        public $lgoutTime;
        /*
         * 是否删除
         */
        public $deleted;

        /*
         * setter & getter
         * */
        function setUserId($identifier){
            $this->userId = $identifier;
        }

        function getUserId(){
            return $this->userId . PHP_EOL;
        }

        function setUserName($valueString){
            $this->userName = $valueString;
        }

        function getUserName(){
            return $this->userName . PHP_EOL;
        }

        function setUserAccount($valueString){
            $this->userAccount = $valueString;
        }

        function getUserAccount(){
            return $this->userAccount . PHP_EOL;
        }

        function setPassword($valueString){
            $this->password = $valueString;
        }

        function getPassword(){
            return $this->password . PHP_EOL;
        }

        function setRole(role $setRole){
            $this->role = $setRole;
        }

        function getRole(){
            return $this->role;
        }

        function setDep($valueString){
            $this->dep = $valueString;
        }

        function getDep(){
            return $this->dep . PHP_EOL;
        }

        function setLginTime($valueString){
            $this->lginTime = $valueString;
        }

        function getLginTime(){
            return $this->lginTime . PHP_EOL;
        }

        function setLgoutTime($valueString){
            $this->lgoutTime = $valueString;
        }

        function getLgoutTime(){
            return $this->lgoutTime . PHP_EOL;
        }

        function setDeleted($valueString){
            $this->deleted = $valueString;
        }

        function getDeleted(){
            return $this->deleted . PHP_EOL;
        }

        /**
         * @return mixed
         */
        public function __construct($identifier = -1, $name = NULl, $account = NULl, $pwd = NULl, role $role = NULl, $dp = NULl, $inTime = NULL, $outTime = NULL, $del = CodeZ_false)
        {
            $this->userId = $identifier;
            $this->userName = $name;
            $this->userAccount = $account;
            $this->password = $pwd;
            $this->role = $role;
            $this->dep = $dp;
            $this->lginTime = $inTime;
            $this->lgoutTime = $outTime;
            $this->deleted = $del;

            return $this;
        }
    }
?>