<?php
$ok = false;
if (!isset($_GET['q']) || $_GET['q'] == '') {
    echo '<script>alert("Invalid form submission.")</script>';
} else {
    $top_two = substr($_GET['q'], -2);
    $top_three = substr($_GET['q'], -3);
    $top_four = substr($_GET['q'], -4);

    $word_w_two = substr($_GET['q'], 0, -2);
    $word_w_three = substr($_GET['q'], 0, -3);
    $word_w_four = substr($_GET['q'], 0, -4);

    $tld_list = fopen("domains.txt", "r");
    $ok = true;
}


?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>WTD</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-md bg-body">
        <div class="container-fluid"><a class="navbar-brand" href="#">What The Domain?</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="api.html">API</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://github.com/ISaiDPower/WhatTheDomain">Github</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Enter Your Query</h1>
        <form action="index.php" method="get">
            <div class="row">
                <div class="col-9 col-sm-9 col-md-10 col-lg-10 col-xl-10 col-xxl-11"><input class="form-control" type="text" name="q"></div>
                <div class="col"><button class="btn btn-primary" type="submit">Send</button></div>
            </div>
        </form>
        <h4 class="text-center" style="margin-top: 8px;">Total number of domains: 0</h4>
    </div>
    <div class="container" style="margin-top: 23px;">
        <ul class="list-group">
            <?php
            if (!$ok) {
                echo '<li class="list-group-item"><span>None</span></li>';
            } else {
                if ($tld_list) {
                    while (($line = fgets($tld_list)) !== false) {
                        $tld = strtolower($line);
                        $tld = str_replace("\n", '', $tld);
                        if (strcmp($tld, $top_two) == 0) {
                            $temp = $word_w_two . '.' . $tld;
                            echo '<li class="list-group-item"><span>' . $temp .'<a class="btn btn-primary btn-sm" role="button" style="margin-left: 9px;" href="https://whois.com/whois/' . $temp . '">WHOIS</a></span></li>';
                        }
                        if (strcmp($tld, $top_three) == 0) {
                            $temp = $word_w_three . '.' . $tld;
                            echo '<li class="list-group-item"><span>' . $temp .'<a class="btn btn-primary btn-sm" role="button" style="margin-left: 9px;" href="https://whois.com/whois/' . $temp . '">WHOIS</a></span></li>';
                        }
                        if (strcmp($tld, $top_four) == 0) {
                            $temp = $word_w_four . '.' . $tld;
                            echo '<li class="list-group-item"><span>' . $temp .'<a class="btn btn-primary btn-sm" role="button" style="margin-left: 9px;" href="https://whois.com/whois/' . $temp . '">WHOIS</a></span></li>';
                        }
                    }
                    fclose($tld_list);
                }
            }

            ?>
        </ul>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>