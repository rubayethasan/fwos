<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 04.07.18
 * Time: 06:48
 */

function arrayRecursiveDiff($aArray1, $aArray2) {
    $aReturn = array();

    foreach ($aArray1 as $mKey => $mValue) {
        if (array_key_exists($mKey, $aArray2)) {
            if (is_array($mValue)) {
                $aRecursiveDiff = arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
            } else {
                if ($mValue != $aArray2[$mKey]) {
                    $aReturn[$mKey] = $mValue;
                }
            }
        } else {
            $aReturn[$mKey] = $mValue;
        }
    }

    return $aReturn;
}

//print_r(array_diff($qn_set,$data));
//print_r($qn_set);
//print_r(json_encode($data));
print_r(arrayRecursiveDiff($data,$qn_set));