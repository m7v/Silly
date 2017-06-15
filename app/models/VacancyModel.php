<?php

    use Core\Model;

    class VacancyModel extends Model
    {
        private $http = "https://api.zp.ru/v1/vacancies/?geo_id=1219&limit=200";

        public function getData()
        {
            $data = file_get_contents($this->http);
            $data = json_decode($data);

            $specialities = [];
            foreach ($data->vacancies as $vacancy) {
                foreach ($vacancy->rubrics as $rubric) {
                    foreach ($rubric->specialities as $speciality) {
                        if (empty($specialities[$speciality->id]['count'])) {
                            $specialities[$speciality->id]['title'] = $speciality->title;
                            $specialities[$speciality->id]['count'] = 1;
                        }
                        else {
                            $specialities[$speciality->id]['count']++;
                        }
                    }
                }
            }
            uasort($specialities, function ($a, $b) {
                if ($a['count'] === $b['count']) {
                    return 0;
                }
                return ($a['count'] > $b['count']) ? -1 : 1;
            });

            return $specialities;
        }

    }
