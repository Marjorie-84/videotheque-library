<?php

//CALLING MODEL 

include "../model/admin/dramas/dramas.admin.model.php";

$allDramas = allDramas($db);
$nbTotalDramas = countDramas($db);

//CALLING VIEW
include "../view/admin/dramas/dramas.admin.view.php";


