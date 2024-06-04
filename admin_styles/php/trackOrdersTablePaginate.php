<?php
include ("connection.php");
include ("trackOrdersTable.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


    function pagination($currentPage, $totalPages){
    echo "<div style='display:flex; justify-content:flex-end; margin-top: 20px;'>";
    echo "<ul class='pagination'>";
    if ($currentPage > 1) {
        echo "<li class='page-item'><a class='page-link' href='?page=".($currentPage-1)."'>Previous</a></li>";
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo "<li class='page-item active'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
            } else {
                echo "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
            }
        }
        if ($currentPage < $totalPages) {
            echo "<li class='page-item'><a class='page-link' href='?page=".($currentPage+1)."'>Next</a></li>";
        }
        echo "</ul>";
        echo "</div>";
    }

        // $pagination = "<div style='display:flex; justify-content:flex-end; margin-top: 20px;'>";
        // $pagination .= "<ul class='pagination'>";
        // if ($currentPage > 1) {
        //     $pagination .= "<li class='page-item'><a class='page-link' href='?page=".($currentPage-1)."'>Previous</a></li>";
        //     }
        //     for ($i = 1; $i <= $totalPages; $i++) {
        //         if ($i == $currentPage) {
        //             $pagination .= "<li class='page-item active'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
        //         } else {
        //             $pagination .= "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
        //         }
        //     }
        //     if ($currentPage < $totalPages) {
        //         $pagination .= "<li class='page-item'><a class='page-link' href='?page=".($currentPage+1)."'>Next</a></li>";
        //     }
        //     $pagination .= "</ul>";
        //     $pagination .= "</div>";
        
        // return json_encode(array("pagination" => $pagination));

        // function paginationToJson($currentPage, $totalPages) {
        //     $pagination = "<div style='display:flex; justify-content:flex-end; margin-top: 20px;'>";
        //     $pagination .= "<ul class='pagination'>";
        //     if ($currentPage > 1) {
        //         $pagination .= "<li class='page-item'><a class='page-link' href='?page=".($currentPage-1)."'>Previous</a></li>";
        //     }
        //     for ($i = 1; $i <= $totalPages; $i++) {
        //         if ($i == $currentPage) {
        //             $pagination .= "<li class='page-item active'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
        //         } else {
        //             $pagination .= "<li class='page-item'><a class='page-link' href='?page=".$i."'>".$i."</a></li>";
        //         }
        //     }
        //     if ($currentPage < $totalPages) {
        //         $pagination .= "<li class='page-item'><a class='page-link' href='?page=".($currentPage+1)."'>Next</a></li>";
        //     }
        //     $pagination .= "</ul>";
        //     $pagination .= "</div>";
            
        //     return json_encode(array("paginationHtml" => $pagination, "totalPages" => $totalPages));
        // }
        
    
    ?>