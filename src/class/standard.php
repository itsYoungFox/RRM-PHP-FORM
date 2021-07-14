<?php
class Standard
{
    // filter post data
    public static function filter_post_data($postObject) {
        $postData = array();
        foreach ($postObject as $key => $value) {
            $postData[$key] = filter_var($value, FILTER_SANITIZE_STRING);
        }
        return $postData;
    }

    // Replicate string
    public static function replicate_string($value, $length) {
        $replicated_str = '';
        for ($i = 0; $i < $length; $i++) $replicated_str .= $value;
        return $replicated_str;
    }

    // Get object length
    public static function get_object_length($object) {
        return count(get_object_vars($object));
    }

    // Reference Value
    public static function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }
}
?>