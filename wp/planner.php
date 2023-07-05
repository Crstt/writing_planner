<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$title = "Writing Planner";
require_once("head.php");
require_once("body.php");

?>

<button id="printButton">Print This Page</button>
<script src="./js/printbutton.js"></script>

<?php

$startDate = $_POST['startDate'];
$dueDate = $_POST['dueDate'];
$to = $_POST['studentEmail'];
?>

<p class="hide">Thank you for your submission! Please see the steps below for your personal writing plan including due
    dates for each step of the process. Use this plan to stay on track and create a great paper.</p>

<?php
$startDateTime = strtotime($startDate);
$dueDateTime = strtotime($dueDate);
$days = ($dueDateTime - $startDateTime) / (24 * 60 * 60);

$stepsArray = array(0, 3, 1, 4, 7, 7, 7, 4);
$stepsSum = array_sum($stepsArray);
$acStepsArray = array(0);
for ($i = 1; $i < count($stepsArray); $i++) {
    $acStepsArray[$i] = $acStepsArray[$i - 1] + $stepsArray[$i];
}

$datesArray = array($startDateTime);

for ($i = 0; $i < count($stepsArray); $i++) {
    $tempTime = round($acStepsArray[$i] * $days / $stepsSum) * 24 * 60 * 60 + $startDateTime;
    $datesArray[$i] = date("M d Y", $tempTime);
}

// Function to read the content of a file
function readStepFromFile($stepNumber)
{
    $filename = "plannerTexts/step" . $stepNumber . ".txt";
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    
    $content = "<p><strong><em>" . $lines[0] . "</em></strong></p>";
    $content .= "<p>" . $lines[1] . "</p>";
    
    if (isset($lines[2])) {
        if($lines[2] != ""){
            $parts = explode('|', $lines[2]);
            $text = trim($parts[0]);
            $link = trim($parts[1]);
            $content .= "<a href='" . $link . "' target='_blank'>" . $text . "</a> ";
        }       
    }

    // Loop for embedding YouTube videos
    for ($i = 3; $i < count($lines); $i++) {
        $parts = explode('|', $lines[$i]);
        $title = trim($parts[0]);
        $videoLink = trim($parts[1]);
        $content .= "<div class='video'>
            <br>
            <p><strong><em>" . $title . "</em></strong></p>
            <iframe width='560' height='315' src='" . $videoLink . "' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
        </div>";
    }
    
    return $content;
}

// Build the body variable
$body = "";

// Iterate through the steps
for ($i = 1; $i <= 8; $i++) {
    $stepContent = readStepFromFile($i);
    $body .= "<h3>Step " . $i . " By " . $datesArray[$i-1] . ":</h3>";
    $body .= $stepContent;
}

echo $body;

if ($to != "") {

    $head = <<<HEREDOC
        <html>
        <head>
        <title>$title</title>
        </head>
        <body>
        <header>
        <div id="headingArea">
            <h1>$title</h1>
        </div><div style="clear: both;"></div>
        </header>
        <article>
        HEREDOC;


    $foot = <<<HEREDOC
            </article>
            </body>
            </html>
            HEREDOC;

    $message = $head . $body . $foot;
    $subject = "Writing Planner - Tutoring Services";

    // https://stackoverflow.com/questions/16048347/unable-to-send-email-using-gmail-smtp-server-through-phpmailer-getting-error-s
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    //$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //$mail->Host = "smtp.gmail.com";
    $mail->Host = "smtp-mail.outlook.com";
    //$mail->Port = 465; // or 587
    $mail->Port = 587; // or 587
    //$mail->Username = "caetutoring@gmail.com";
    $mail->Username = "fortwayne-tutoring@ivytech.edu";
    $mail->Password = "Greenteaicecreamcone1.";
    $mail->SetFrom("fortwayne-tutoring@ivytech.edu");
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->IsHTML(true);
    $mail->AddAddress($to);
    $mail->SMTPDebug = true;
    //$mail->do_debug = 0;
    $mail->Encoding = 'base64';
    $mail->CharSet = 'UTF-8';



    if (!$mail->Send()) {
        echo "<script>(()=>{
                console.log('Error - " . $mail->ErrorInfo . "')
            })()</script>";
    } else {
        echo "<p class=\"hide\"><strong>Email Status: </strong>";
        echo "Message has been sent.";
        echo "</p>\n";
    }


}

echo "  <p class=\"hide\"><a href=\"index.php\">Fill Out the Form Again</a></p>\n";
require_once("footer.php");
?>