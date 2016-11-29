<?php

    use Core\Model;

    class RubricModel extends Model
    {
        private $http = "https://api.zp.ru/v1/vacancies/?geo_id=1219&limit=200";

        /**
         * @return array
         */
        public function getData()
        {
            $data = file_get_contents($this->http);
            $data = json_decode($data);

            $rubrics = [];
            foreach ($data->vacancies as $vacancy) {
                foreach ($vacancy->rubrics as $rubric) {
                    if (empty($rubrics[$rubric->id]['count'])) {
                        $rubrics[$rubric->id]['title'] = $rubric->title;
                        $rubrics[$rubric->id]['count'] = 1;
                    }
                    else {
                        $rubrics[$rubric->id]['count']++;
                    }
                }
            }
            uasort($rubrics, function ($a, $b) {
                if ($a['count'] === $b['count']) {
                    return 0;
                }
                return ($a['count'] > $b['count']) ? -1 : 1;
            });

            return $rubrics;
        }

    }
