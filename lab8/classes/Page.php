<?php

class Page {
    public static function includePath($path){
        if (file_exists($path)) {
            include $path;
            return true;
        } 
        return false;
    }
    public static function part($component) {
        $componentPath = "./views/components/{$component}.php";
        if(self::includePath($componentPath)) return;
        $componentPath = "./handlers/{$component}.php";
        if(self::includePath($componentPath)) return;
        echo "Component {$component} not found";
    }

}

?>
