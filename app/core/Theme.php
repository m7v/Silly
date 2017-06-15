<?php

    namespace Core;

    class Theme
    {
        static public function check_plain($text) {
            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        }

        static public function attributes(array $attributes = []) {
            foreach ($attributes as $attribute => &$data) {
                $data = implode(' ', (array) $data);
                $data = $attribute . '="' . self::check_plain($data) . '"';
            }
            return $attributes ? ' ' . implode(' ', $attributes) : '';
        }

        static public function table($variables) {
            $header = $variables['header'];
            $rows = $variables['rows'];
            $attributes = $variables['attributes'];
            $caption = $variables['caption'];
            $colgroups = $variables['colgroups'];
            $empty = $variables['empty'];
            $cols = [];

            $output = '<table' . self::attributes($attributes) . ">\n";

            if (isset($caption)) {
                $output .= '<caption>' . $caption . "</caption>\n";
            }

            // Format the table columns:
            if (count($colgroups)) {
                foreach ($colgroups as $number => $colgroup) {
                    $attributes = array();

                    // Check if we're dealing with a simple or complex column
                    if (isset($colgroup['data'])) {
                        foreach ($colgroup as $key => $value) {
                            if ($key == 'data') {
                                $cols = $value;
                            }
                            else {
                                $attributes[$key] = $value;
                            }
                        }
                    }
                    else {
                        $cols = $colgroup;
                    }

                    // Build colgroup
                    if (is_array($cols) && count($cols)) {
                        $output .= ' <colgroup' . self::attributes($attributes) . '>';
                        $i = 0;
                        foreach ($cols as $col) {
                            $output .= ' <col' . self::attributes($col) . ' />';
                        }
                        $output .= " </colgroup>\n";
                    }
                    else {
                        $output .= ' <colgroup' . self::attributes($attributes) . " />\n";
                    }
                }
            }

            // Add the 'empty' row message if available.
            if (!count($rows) && $empty) {
                $header_count = 0;
                foreach ($header as $header_cell) {
                    if (is_array($header_cell)) {
                        $header_count += isset($header_cell['colspan']) ? $header_cell['colspan'] : 1;
                    }
                    else {
                        $header_count++;
                    }
                }
                $rows[] = array(array('data' => $empty, 'colspan' => $header_count, 'class' => array('empty', 'message')));
            }

            // Format the table header:
            if (count($header)) {
                // HTML requires that the thead tag has tr tags in it followed by tbody
                // tags. Using ternary operator to check and see if we have any rows.
                $output .= (count($rows) ? ' <thead><tr>' : ' <tr>');
                foreach ($header as $cell) {
                    $output = "<th>$cell</th>";
                }
                // Using ternary operator to close the tags based on whether or not there are rows
                $output .= (count($rows) ? " </tr></thead>\n" : "</tr>\n");
            }

            // Format the table rows:
            if (count($rows)) {
                $output .= "<tbody>\n";
                $flip = array('even' => 'odd', 'odd' => 'even');
                $class = 'even';
                foreach ($rows as $number => $row) {
                    // Check if we're dealing with a simple or complex row
                    if (isset($row['data'])) {
                        $cells = $row['data'];
                        $no_striping = isset($row['no_striping']) ? $row['no_striping'] : FALSE;

                        // Set the attributes array and exclude 'data' and 'no_striping'.
                        $attributes = $row;
                        unset($attributes['data']);
                        unset($attributes['no_striping']);
                    }
                    else {
                        $cells = $row;
                        $attributes = array();
                        $no_striping = FALSE;
                    }
                    if (count($cells)) {
                        // Add odd/even class
                        if (!$no_striping) {
                            $class = $flip[$class];
                            $attributes['class'][] = $class;
                        }

                        // Build row
                        $output .= ' <tr' . self::attributes($attributes) . '>';
                        $i = 0;
                        foreach ($cells as $cell) {
                            $output .= "<td$attributes>$cell</td>";
                        }
                        $output .= " </tr>\n";
                    }
                }
                $output .= "</tbody>\n";
            }

            $output .= "</table>\n";

            return $output;
        }
    }