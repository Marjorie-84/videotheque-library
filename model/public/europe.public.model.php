<?php
function allEurope($db){
    $query = "SELECT * FROM europe ORDER BY nom ASC";
    return mysqli_query($db, $query);
}