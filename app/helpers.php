<?php

// 系统方法
include_once __DIR__ . '/helpers_common.php';



function trans_arr_global(...$arr){
    $newArr = [];
    foreach ($arr as $item) {
        $newArr[] = 'global.' . $item;
    }

    return trans_arr(...$newArr);
}
