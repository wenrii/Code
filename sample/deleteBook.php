<?php

    $id = '';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    require_once 'class/book.class.php';

    $obj = new Product();

    if ($obj->delete($id)){
        echo 'Success';
    }else{
        echo "Failed";
    }