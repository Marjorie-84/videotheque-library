<?php
function allFilms($db){
    $query = "SELECT * FROM films ORDER BY nom ASC";
    return mysqli_query($db, $query);
}