<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/15
     * Time: 21:27
     */

    require_once dirname(__FILE__) . "/../tool/CodeZObject.php";

    class role implements CodeZObject
    {
        public $roleId;
        public $roleName;
        public $descript;
        public $deleted;

        public function tableMappers($tableArray)
        {
            // TODO: Implement tableMappers() method.
            if (is_array($tableArray)) {
                if (isset($tableArray['roleId'])) {
                    $this->roleId = $tableArray['roleId'];
                }
                if (isset($tableArray['roleName'])) {
                    $this->roleName = $tableArray['roleName'];
                }
                if (isset($tableArray['descript'])) {
                    $this->descript = $tableArray['descript'];
                }
                if (isset($tableArray['deleted'])) {
                    $this->deleted = $tableArray['deleted'];
                }
            }
        }
    }