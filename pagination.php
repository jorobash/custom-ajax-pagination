<?php

require_once 'mysqli_connect.php';
echo ceil(3/10);die;
$q = 'SELECT COUNT(customerNumber) from customers';

$result = mysqli_query($conn,$q);


$allCustomers = mysqli_fetch_row($result);

$totalRow = $allCustomers[0];
$perpage = 10;
$last = ceil($totalRow/$perpage);

// sure that last can't be less than one
if($last < 1){
    $last = 1;
}
//Establish the $pagenum variable
$pagenum = 1;

// Get pagenum variables from url if it present if it is not present we set it to one

if(isset($_GET['pn'])){
    $pagenum = preg_replace('#[^0-9]#','',$_GET['pn']);
}

if($pagenum > $last){
    $pagenum = $last;
} else if($pagenum < 1){
    $pagenum = 1;
}

$limit = 'LIMIT '. ($pagenum - 1) * $perpage .',' .$perpage;

$query = "select * from customers $limit";

$pages = "";

if($last != 1){

    $previous = $pagenum - 1;
    if($previous > 1){
        $pages .= '<a href="'. $_SERVER['PHP_SELF'].'?pn='.$previous. '">previous</a> &nbsp; &nbsp; ';
    }

    for($i = $pagenum - 4; $i < $pagenum; $i++){
        if($i > 0){
             $pages .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; &nbsp; ';
        }
    }

    $pages .= ''. $pagenum . ' &nbsp; ';

    for($i = $pagenum + 1; $i <= $last; $i++){
        $pages .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
        if($i >= $pagenum + 4){
            break;
        }
    }

    if($pagenum < $last){
        $pages .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='. ($pagenum + 1) .'">Next </a>';
    }

}

$res = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($res)){
    echo $row['customerNumber']." " .$row['customerName']."</br>";
}



echo '<br>';
echo '<br>';
echo $pages;
//This shows the user what page they are on, and the total number of pages
echo "<br><br>";
echo $textline1 = "Testimonials (<b>$totalRow</b>)";
echo $textline2 = "Page <b>$pagenum</b> of <b>$last</b>";

