<?php

// Helper Functions
use function Helpers\expectsJson;
use function Helpers\saveSubmission;

include 'inc/helpers.php';

// Response object
$response = [];

// Fetch Form ID & Form fields
$formId = strip_tags($_GET['form']);
$details = $_POST;

// Verify form id & details
if(empty($formId) || strlen($formId) == 0) {
    $response = [
        'status' => 'error',
        'message' => 'We\'re sorry, but the form you submitted is invalid. If you are the owner of this form, please ensure that you use the complete integration link to start receiving submissions.'
    ];
} else if(!is_array($details) || count($details) === 0) {
    $response = [
        'status' => 'error',
        'message' => 'The form that you tried to submit does not contain any fields.'
    ];
} else {
    $response = saveSubmission($formId, $details);
}

// If request is expecting JSON, return the response array
if(expectsJson()) {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }

    header('Content-Type: application/json');

    if($response['status'] == 'error') {
        http_response_code(400);
    }

    echo json_encode($response);
    die();
}
?>
<html lang="en">
<head>
    <title><?php echo ($response['status'] === 'success' ? 'Thank you' : 'Oopps..') ?> | FormFlow</title>
    <link rel="icon" href="../img/favicon.png">
    <style>
        html, body {
            background: #f2f3f4;
            padding: 0;
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: #171738;
        }
        * {
            box-sizing: border-box;
        }
        .page-wrapper {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            padding: 0 15px;
            text-align: center;
        }
        .page-wrapper h1 {
            font-weight: bold;
            margin: 30px 0 15px 0;
            font-size: 24px;
        }
        .page-wrapper p {
            font-size: 14px;
            color: rgba(23, 23, 56, 0.5);
            margin: 0;
        }
        .page-wrapper .btn.btn-light {
            display: inline-flex;
            align-content: center;
            padding: 10px 25px;
            text-decoration: none;
            background: rgba(23,23,56,0.1);
            border-radius: 5px;
            margin-top: 25px;
            font-weight: bold;
            color: #171738;
            font-size: 14px;
        }
        .page-wrapper .btn.btn-light:hover,
        .page-wrapper .btn.btn-light:focus {
            background: rgba(23,23,56,0.15);
        }
        .page-wrapper .btn.btn-light:active {
            transform-origin: center;
            transform: scale(0.95);
            background: rgba(23,23,56,0.2);
        }
        .powered-by {
            position: fixed;
            bottom: 1rem;
            left: 0;
            right: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            align-content: center;
            font-size: 12px;
            color: #999;
            z-index: 1;
        }
        .powered-by a {
            display: block;
            line-height: 1;
            margin-left: 10px;
        }
        .powered-by a img {
            display: block;
            height: 15px;
            filter: grayscale(1);
            opacity: 0.5;
        }
        #check-group {
            animation: 0.32s ease-in-out 1.03s check-group;
            transform-origin: center;
        }
        #check-group #check {
            animation: 0.34s cubic-bezier(0.65, 0, 1, 1) 0.8s forwards check;
            stroke-dasharray: 0, 75px;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        #check-group #check-2 {
            animation: 0.34s cubic-bezier(0.65, 0, 1, 1) 0.8s forwards check;
            stroke-dasharray: 0, 75px;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        #check-group #outline {
            animation: 0.38s ease-in outline;
            transform: rotate(0deg);
            transform-origin: center;
        }
        #check-group #white-circle {
            animation: 0.35s ease-in 0.35s forwards circle;
            transform: none;
            transform-origin: center;
        }
        @keyframes outline {
            from {
                stroke-dasharray: 0, 345.576px;
            }
            to {
                stroke-dasharray: 345.576px, 345.576px;
            }
        }
        @keyframes circle {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(0);
            }
        }
        @keyframes check {
            from {
                stroke-dasharray: 0, 75px;
            }
            to {
                stroke-dasharray: 75px, 75px;
            }
        }
        @keyframes check-group {
            from {
                transform: scale(1);
            }
            50% {
                transform: scale(1.09);
            }
            to {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <?php if($response['status'] === 'success') { ?>
        <svg
            width="115px"
            height="115px"
            viewBox="0 0 133 133"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
        >
            <g
                id="check-group"
                stroke="none"
                stroke-width="1"
                fill="none"
                fill-rule="evenodd"
            >
                <circle
                    id="filled-circle"
                    fill="#07b481"
                    cx="66.5"
                    cy="66.5"
                    r="54.5"
                />
                <circle
                    id="white-circle"
                    fill="#FFFFFF"
                    cx="66.5"
                    cy="66.5"
                    r="55.5"
                />
                <circle
                    id="outline"
                    stroke="#07b481"
                    stroke-width="4"
                    cx="66.5"
                    cy="66.5"
                    r="54.5"
                />
                <polyline
                    id="check"
                    stroke="#FFFFFF"
                    stroke-width="5.5"
                    points="41 70 56 85 92 49"
                />
            </g>
        </svg>
    <?php } else { ?>
        <svg
                width="115px"
                height="115px"
                viewBox="0 0 133 133"
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
        >
            <g
                    id="check-group"
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd"
            >
                <circle
                        id="filled-circle"
                        fill="#E71D36"
                        cx="66.5"
                        cy="66.5"
                        r="54.5"
                />
                <circle
                        id="white-circle"
                        fill="#FFFFFF"
                        cx="66.5"
                        cy="66.5"
                        r="55.5"
                />
                <circle
                        id="outline"
                        stroke="#E71D36"
                        stroke-width="4"
                        cx="66.5"
                        cy="66.5"
                        r="54.5"
                />
                <polyline
                        id="check"
                        stroke="#FFFFFF"
                        stroke-width="5.5"
                        points="40 90 92 40"
                />
                <polyline
                        id="check-2"
                        stroke="#FFFFFF"
                        stroke-width="5.5"
                        points="90 90 40 40"
                />
            </g>
        </svg>
    <?php } ?>
    <h1><?php echo ($response['status'] === 'success' ? 'Thank you!' : 'Oopps..') ?></h1>
    <p><?php echo $response['message'] ; ?></p>
</div>
</body>
</html>
