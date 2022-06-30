<?php

//CALLING MODEL 
include "../model/admin/series/series.admin.model.php";

$allSeries = allSeries($db);
$nbTotalSeries = countSeries($db);


//CALLING VIEW
include "../view/admin/series/series.admin.view.php";
