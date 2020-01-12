<?php
    require_once 'db.php';

    $query = 'SELECT COUNT(customerNumber) FROM customers';
    $res = mysqli_query($conn,$query);
    $result = mysqli_fetch_row($res);
    $totalRows = $result[0];

    $perpage = 10;
    $totalPage = ceil($totalRows/$perpage);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pagination</title>
    <div id="ajax-pagination">

    </div>
    <div id="ajax-result">

    </div>
</head>
<body>


<script>
    paginate(1);
    function paginate(pn){
        let perpage = <?= $perpage; ?>;
        let totalPage = <?= $totalPage; ?>;

        let pagination =  document.getElementById('ajax-pagination');
        let htmlResult =  document.getElementById('ajax-result');
        htmlResult.innerHTML = "Loading...";
        var xhr = new XMLHttpRequest();
        xhr.open('POST','parser-pagination.php',true);
        xhr.setRequestHeader('Content-type',"application/x-www-form-urlencoded");
        let htmlOtput = "";
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                let dataArray = xhr.responseText.split("||");
                for(let i = 0; i < dataArray.length - 1; i++){
                    let itemArray = dataArray[i].split("|");
                    htmlOtput += "ID:" + itemArray[0] + "Name: " + itemArray[1] + "<br>";
                }
                htmlResult.innerHTML = htmlOtput;
            }
        };
        xhr.send("pp="+perpage+"&tp="+totalPage+"&pn="+pn);

        let paginationControl = "";

        if(totalPage != 1){
            if(pn > 1){
                paginationControl += '<button onclick="paginate('+(pn-1)+')">&lt;</button>';
            }

            paginationControl += ' &nbsp; &nbsp; <b>Page '+pn+' of ' +totalPage+'</b>'

            if(pn < totalPage){
                paginationControl += '<button onclick="paginate('+(pn+1)+')">&gt;</button>';
            }
        }

        pagination.innerHTML = paginationControl;
    }
</script>
</body>
</html>