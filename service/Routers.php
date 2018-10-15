<?php
    /**
     * Created by PhpStorm.
     * User: hq
     * Date: 2018/10/14
     * Time: 17:34
     */


    /*
    * constant
    */
    define("usrLogin","usrLogin");

    /*
    * import file
    */
    require_once dirname(__FILE__) . "../model/user.php";


    class Routers
    {

    }

    /*
    * action动作
    */
    $action = $_POST['action'];

    switch($action){
    case usrLogin:

    break;
    }


?>