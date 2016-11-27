<?php

require_once 'app/bootstrap.php';

use Core\App;

$app = new App();

$app->get('/rubrics', 'RubricController');
$app->get('/vacancies', 'VacancyController');

$app->run();