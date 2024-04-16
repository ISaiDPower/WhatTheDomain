<?php
header("Content-Type: application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['q'])) {
        http_response_code(400);
        die(json_encode([
            'error' => 'No query string provided.'
        ]));
    }
    $top_two = substr($_GET['q'], -2);
    $top_three = substr($_GET['q'], -3);
    $top_four = substr($_GET['q'], -4);

    $word_w_two = substr($_GET['q'], 0, -2);
    $word_w_three = substr($_GET['q'], 0, -3);
    $word_w_four = substr($_GET['q'], 0, -4);

    $possible_two = array();
    $possible_three = array();
    $possible_four = array();

    $tld_list = fopen("domains.txt", "r");
    if ($tld_list) {
        while (($line = fgets($tld_list)) !== false) {
            $tld = strtolower($line);
            switch (strlen($tld)) {
                case 2:
                    if ($top_two == $tld) {
                        $possible_two[] = $word_w_two . "." . $tld;
                    }
                    break;
                case 3:
                    if ($top_three == $tld) {
                        $possible_three[] = $word_w_three . "." . $tld;
                    }
                    break;
                case 4:
                    if ($top_four == $tld) {
                        $possible_four[] = $word_w_four . "." . $tld;
                    }
            }
        }
        fclose($tld_list);
    }

    exit(json_encode([
        'total_combinations' => count($possible_two) + count($possible_three) + count($possible_four),
        'two_letter_tld' => $possible_two,
        'three_letter_tld' => $possible_three,
        'four_letter_tld' => $possible_four,
    ]));
}