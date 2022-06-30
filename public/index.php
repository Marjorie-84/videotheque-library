<?php
// front controller

// session for all
session_start();


// dependencies
require_once "../bin/config.php";
require_once "../model/DB.model.php";

// DB connection
$db = connectDBModel();


// DEFAULT PAGE
if (!isset($_GET['page']) && !isset($_GET['admin'])) {

    require_once "../view/public/header.php";

    include "../controller/public/home.public.controller.php";

    require_once "../view/public/footer.php";
} //SWITCH
else {

    if (isset($_GET['page'])) {

        require_once "../view/public/header.php";

        switch ($_GET['page']) {
                // crud films
            case 'films':
                include "../controller/public/films.public.controller.php";
                break;
            case 'series':
                include "../controller/public/series.public.controller.php";
                break;
            case 'afrique':
                include "../controller/public/afrique.public.controller.php";
                break;
            case 'connect':
                include "../controller/public/connect.public.controller.php";
                break;
            default:
                include "../controller/public/home.public.controller.php";
        }
        require_once "../view/public/footer.php";

        // SWITCH ADMIN
    } else if (isset($_GET['admin'])) {
        require_once "../view/admin/header.admin.view.php";

        switch ($_GET['admin']) {
                // ADMIN HOME PAGE
            case 'home':
                include "../controller/admin/home.admin.controller.php";
                break;
            case 'films':
                include "../controller/admin/films/films.admin.controller.php";
                break;
            case 'detailFilms':
                include "../controller/admin/films/detailFilms.admin.controller.php";
                break;
            case 'insertFilms':
                include "../controller/admin/films/insert.films.admin.controller.php";
                break;
            case 'series':
                include "../controller/admin/series/series.admin.controller.php";
                break;
            case 'insertSeries':
                include "../controller/admin/series/insert.series.admin.controller.php";
                break;
            case 'dramas':
                include "../controller/admin/dramas/dramas.admin.controller.php";
                break;  
            case 'insertDramas':
                include "../controller/admin/dramas/insert.dramas.admin.controller.php";
                break;
            case 'deleteDramas':
                include "../controller/admin/dramas/delete.dramas.admin.controller.php";
                break;
            case 'detailCategories':
                include "../controller/admin/categories/read.categories.admin.controller.php";
                break;
            case 'insertCategories':
                include "../controller/admin/categories/insert.categories.admin.controller.php";
                break;
            case 'updateCategories':
                include "../controller/admin/categories/update.categories.admin.controller.php";
                break;
            case 'deleteCategories':
                include "../controller/admin/categories/delete.categories.admin.controller.php";
                break;
            case 'deconnect':
                include "../controller/admin/deconnexion.admin.controller.php";
        }
    }
}
