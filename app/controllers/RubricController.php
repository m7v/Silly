<?php

    use Core\Controller;
    use Core\Request;
    use Core\Response;

    class RubricController extends Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->model = new RubricModel();
        }

        public function IndexAction(Request $request, Response $response)
        {
            $rubrics = $this->model->getData();
            $output = "<ul>
                <li><a href=\"/\">Home</a></li>
                <li><a href=\"/rubrics\">Rubrics</a></li>
                <li><a href=\"/vacancies\">Vacancies</a></li>
            </ul>";
            $output .= '<table><tbody>';
            foreach ($rubrics as $rubric) {
                $output .= "<tr><td>". $rubric['title'] ."</td><td>". $rubric['count'] ."</td></tr>";
            }
            $output .= '</tbody></table>';

            $this->view->html($response, $output);
        }
    }