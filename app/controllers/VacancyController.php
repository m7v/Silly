<?php

use Core\Controller;
use Core\Request;
use Core\Response;

class VacancyController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new VacancyModel();
    }

    public function IndexAction(Request $request, Response $response)
    {
        $vacancies = $this->model->getData();
        $output = "<ul>
            <li><a href=\"/\">Home</a></li>
            <li><a href=\"/rubrics\">Rubrics</a></li>
            <li><a href=\"/vacancies\">Vacancies</a></li>
        </ul>";

        $output .= '<table><tbody>';
        foreach ($vacancies as $vacancy) {
            $output .= "<tr><td>". $vacancy['title'] ."</td><td>". $vacancy['count'] ."</td></tr>";
        }
        $output .= '</tbody></table>';

        $this->view->html($response, $output);
    }
}