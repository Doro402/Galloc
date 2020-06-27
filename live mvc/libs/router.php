<?php
class router{
    private $ctrl;
    function route(){

        try{
            spl_autoload_register(function($class){
                $pathModels="./models/".$class.".php;
                $pathDao="./dao/".$class.".php";
                $path.ibs="./libs/".$class.".php";
                if(file_exists($pathModels)){
                    require_once "$pathModels";
                }elseif(file_exist($pathDao)){
                    require_once "$pathDao";
                }
                elseif(file_exist($pathDlibs)){
                    require_once "$pathlibs";
                }

            });



            
        }
    }
}