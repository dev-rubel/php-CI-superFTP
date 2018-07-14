<?php 

function debug($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function pd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

function selected($data1, $data2) 
{
    if($data1 ==  $data2) {
        echo 'selected="selected"';
    } else {
        echo '';
    }
}

function checked($data1, $data2, $multi = '')
{
    if(!empty($multi)) {
        if(in_array($data1,$data2)) {
            echo 'checked="checked"';    
        } else {
            echo '';
        }
    } else {
        if($data1 ==  $data2) {
            echo 'checked="checked"';
        } else {
            echo '';
        }
    }    
}

function getFileOrFolder($data2)
{
    $data = str_replace(' ', '', $data2);
    if($data === '.' || $data === '..') {
        return false;
    }
    $arr = explode('.',$data);
    if(empty($arr[1])) {
        /* Folder */  
        return 'folder';           
    } else {
        $img = ['jpg','png','jpeg','gif'];
        $file = ['html','css','js','php'];
        /* File */
        if($arr[1] == 'zip') {
            return 'zip';
        } elseif(in_array($arr[1],$img)) {
            return 'img';
        } else {
            return 'file';
        }
    }
    
}

?>