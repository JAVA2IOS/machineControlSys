<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/20
     * Time: 13:06
     */

    interface CodeZObject {
        /* 数据库数据转模型对象 */
        public function tableMappers($tableArray);

        /* json 转对象 */
        public function modelWithJson($jsonString);
    }
?>