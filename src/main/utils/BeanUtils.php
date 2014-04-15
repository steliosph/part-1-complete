<?php
class BeanUtils {

    public static function isBeanValid($bean) {
        if ($bean == null) 
            return false;
		
        if (!$bean instanceof TaskInterface) 
            return false;
		
        return true;
    }

    public static function isBeanInvalid($bean) {
        return !self::isBeanValid($bean);
    }
}