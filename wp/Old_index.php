<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/*
  Author:       Jeremy A. Nally 
  Program:      Writing Planner
  Created:  	December 2, 2021
  Last Update:  January 4, 2022
  Description:  Estimate dates for writing assignment milestones based on input
  Optionally email user the writing plan
  Printing the web page yields a printer-friendly version

  ------------------------------------------------------------------
  UPDATE to Tutoring Services
  Author:       Matteo Catalano 
  Last Update:  June 22, 2023
*/
$title = "Writing Planner";
$thisScript = $_SERVER['PHP_SELF'];
//$submit		= $_POST['submit'];



// Include files
require 'vendor/autoload.php';
require_once("head.php");
require_once("body.php");

// Check if $_POST['submit'] is set, generate planner if it's set
if (!isset($_POST['submit'])) {
  echo <<<HEREDOC
  <h2>Writing is a process! Use this writing planner to save yourself time and create a better paper.</h2>
  <p class="hide"><strong>Please enter a start date and a due date for your writing assignment, then complete the rest of the form and click submit.</strong></p>
  <form action="$thisScript" method="post">
    <label><strong>Start Date:</strong>
      <input id="startDate" name="startDate" type="text" placeholder="yyyy-mm-dd" required />
    </label><br />
    <label><strong>Due Date:</strong>
      <input id="dueDate" name="dueDate" type="text" placeholder="yyyy-mm-dd" required />
    </label><br />
    <label id="optionalEmailLbl"><strong>Optional-Email: get your writing plan sent to your inbox</strong></label><br />
    <input id="studentEmail" name="studentEmail" type="text" placeholder="username@domain.com" />
    <br />
    <p>
      <input type="reset"    name="reset"  value="Reset" />
      <input type="submit"   name="submit"  value="Submit" />
    </p>
  </form>\n
  HEREDOC;
  echo "  <script src=\"./js/datePickers.js\"></script>\n";
} else {
  echo "<button id=\"printButton\">Print This Page</button>\n";
  echo "<script src=\"./js/printbutton.js\"></script>\n";

  $startDate = $_POST['startDate'];
  $dueDate = $_POST['dueDate'];
  $to = $_POST['studentEmail'];
  echo "  <p class=\"hide\">Thank you for your submission! Please see the steps below for your personal writing plan including due dates for each step of the process.  Use this plan to stay on track and create a great paper.</p>\n";
  //  echo "  <p>Start Date: $startDate Due Date: $dueDate</p>\n";
  $startDateTime = strtotime($startDate);
  $dueDateTime = strtotime($dueDate);
  $days = ($dueDateTime - $startDateTime) / (24 * 60 * 60);
  //  echo "  <p>$days days</p>\n";

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
    //    echo $datesArray[$i];
//    echo "<br>\n";
  }

  $body = <<<HEREDOC
<h3>Step One By $datesArray[0]:</h3>

<p><strong><em>Getting started is often the toughest part of writing a paper!</em></strong> Call the Center for Academic Excellence (CAE) to book your live Zoom appointment with a professional writing tutor.</p>

<ul><li>Call today because appointments book quickly: 260-480-4262.</li></ul>

<h3>Step Two By $datesArray[1]:</h3>

<p><strong><em>This step can help you decide the topic of your paper.</em></strong> Attend your first CAE tutoring session where you can identify and discuss the essay topic, the type of essay, discover who your audience is, and learn what type of sources you will need (if any).</p>

<h3>Step Three By $datesArray[2]:</h3>

<p><strong><em>Working with a resource expert can help you save time during your search for sources.</em></strong> Your goal in this step is to gather a collection of potential sources for your paper. Email, call, or virtually chat with a friendly librarian today: <a href="https://library.ivytech.edu/fortwayne/ask-a-librarian" target="_blank">https://library.ivytech.edu/fortwayne/ask-a-librarian</a></p>

<h3>Step Four By $datesArray[3]:</h3>

<p><strong><em>To keep things moving in the right direction, attend a second CAE tutoring session.</em></strong> Bring the sources you found with the librarian to this appointment. Today during tutoring, you will discuss how to understand and summarize your sources, pick quotes to support your argument, use in-text citations, and build a works cited or reference page.</p>

<h3>Step Five By $datesArray[4]:</h3>

<p><strong><em>Get this right, and you’ll make your job a lot easier; so, attend another tutoring session.</em></strong> In this step, you need to write your thesis statement. It can be difficult to create one that is not too narrow or too broad. Before your meeting, write a working thesis and a rough draft outline of the main supporting claims for your essay. Today, you will discuss how to best develop and organize your working outline.</p>

<h3>Step Six By $datesArray[5]:</h3>

<p><strong><em>It can be easy to lose your focus at this point in the writing process; so, see your tutor again.</em></strong> Bring a draft of your paper for your meeting. It’s ok if your draft is not finished; you will brainstorm ideas with your tutor.</p>

<h3>Step Seven By $datesArray[6]:</h3>

<p><strong><em>You are almost there! It’s time to finish strong. After working on revisions to the draft of your essay, meet with your tutor to review your paper.</em></strong> During your session you will discuss any peer or professor feedback to revise your essay. You will also learn how to submit your draft to the CAE Write Smart essay review site, on Ivy Learn, for a plagiarism check and a grammar review.</p>

<h3>Step Eight By $datesArray[7]:</h3>

<p><strong><em>It’s the last step! Time to do some final editing and submit your essay to your professor.</em></strong> Today, you will use the Write Smart feedback to proofread the paper with a word-by-word grammar, spelling, and punctuation check. Congratulations!</p>

<p>Remember the more you practice writing as a process, the stronger of a writer you will become, and it all starts with a plan.</p>

HEREDOC;

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
    $subject = "Writing Planner - CAE";

    // https://stackoverflow.com/questions/16048347/unable-to-send-email-using-gmail-smtp-server-through-phpmailer-getting-error-s
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->Username = "caetutoring@gmail.com";
    $mail->Password = "Greenteaicecreamcone1.";
    $mail->SetFrom("caetutoring@gmail.com");
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->IsHTML(true);
    $mail->AddAddress($to);
    $mail->SMTPDebug = false;
    $mail->do_debug = 0;
    $mail->Encoding = 'base64';
    $mail->CharSet = 'UTF-8';


    echo "<p class=\"hide\"><strong>Email Status: </strong>";
    if (!$mail->Send()) {
      echo "Error - " . $mail->ErrorInfo;
    } else {
      echo "Message has been sent.";
    }
    echo "</p>\n";

  } // End if $to != ""

  echo "  <p class=\"hide\"><a href=\"index.html.php\">Fill Out the Form Again</a></p>\n";

} // end of IF/ELSE for ISSET
echo "  <p class=\"hide\"><a href=\"https://www.google.com/a/ivytech.edu/ServiceLogin?continue=https://docs.google.com/forms/d/e/1FAIpQLSeI2sWdeP6QPW0xDVr91YeEDUZdQqTAI9BR58KDMcwNd7eA8w/viewform?usp=sf_link\" target=\"_blank\">Click here if you would like to be contacted by the CAE about FREE tutoring or writing support.</a></p>\n";
echo "  </article>\n";
require("footer.php");
?>