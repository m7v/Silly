<?php

require_once 'app/bootstrap.php';

use Core\App;

$app = new App();

//$app->get('/rubrics', 'NotFoundController');
//$app->get('/vacancies', 'VacanciesController', ['VacanciesModel']);

$app->run();