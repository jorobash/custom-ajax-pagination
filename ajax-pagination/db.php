<?php

$conn = mysqli_connect('localhost','root','','classicmodels');

if(!$conn){
    echo 'Something went wrong '. mysqli_errno($conn);
}