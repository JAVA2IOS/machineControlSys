<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/16
     * Time: 23:03
     */

    class StatusObject
    {
        public $success;
        public $data;
        public $error;

        public function __construct($status = false, $datas = NULL, $error = "没有数据")
        {
            $this->success = $status;
            $this->data = $datas;
            $this->error = $error;
        }
    }
?>