<?php
    require_once  'db.php';
    $perpage = "";
    $pageNumber = "";
    $totalPage = "";

    if(isset($_POST['pp'])){
        $perpage = $_POST['pp'];
    }

    if(isset($_POST['tp'])){
        $totalPage = $_POST['tp'];
    }

    if(isset($_POST['pn'])){
        $pageNumber = $_POST['pn'];
    }

    if($pageNumber < 1){
        $pageNumber = 1;
    }

    if($pageNumber > $totalPage){
        $pageNumber = $totalPage;
    }

    if($perpage && $totalPage && $pageNumber){
        $limit = "LIMIT ". ($pageNumber - 1) * $perpage.",".$perpage;
        $q = "SELECT * FROM customers $limit";
        $result = mysqli_query($conn,$q);
        $response = "";
        while($row = mysqli_fetch_assoc($result)){
            $response .= $row['customerNumber']. "|".$row['customerName'] ."||";
        }
    }

    mysqli_close($conn);
    echo $response;
exit();
?>