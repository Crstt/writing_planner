<?php
$title = "Writing Planner";

require_once("head.php");
require_once("body.php");

?>
<h2>Writing is a process! Use this writing planner to save yourself time and create a better paper.</h2>
<p class="hide"><strong>Please enter a start date and a due date for your writing assignment, then complete the rest of
    the form and click submit.</strong></p>
<form action="planner.php" method="post">
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
    <input type="reset" name="reset" value="Reset" />
    <input type="submit" name="submit" value="Submit" />
  </p>
</form>

<script src="js/datePickers.js"></script>
<?php
require("footer.php");
?>