<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['q']) || $_GET['q'] == "") {
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
            $tld = str_replace("\n", '', $tld);
            if (strcmp($tld, $top_two) == 0) {
                $possible_two[] = $word_w_two . "." . $tld;
            }
            if (strcmp($tld, $top_three) == 0) {
                $possible_three[] = $word_w_three . "." . $tld;
            }
            if (strcmp($tld, $top_four) == 0) {
                $possible_four[] = $word_w_four . "." . $tld;
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
} else {
    http_response_code(405);
    exit(json_encode([
        'error' => 'Invalid method, please use GET.'
    ]));
}
