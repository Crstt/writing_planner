<main class="container">
    <article id="planner">

      <?php
        $title = "Writing Planner";

        require_once("head.php");
        require_once("header.php");
      ?>

      <h2>Writing is a process! Use this writing planner to save yourself time and create a better paper.</h2>
      <p class="hide"><strong>Please enter a start date and a due date for your writing assignment, then complete the rest of the form and click submit.</strong></p>
      <form action="planner.php" method="post" onsubmit="return validateForm()">
        <div class="mb-3">
          <label for="startDate" class="form-label"><strong>Start Date:</strong></label>
          <input id="startDate" name="startDate" type="text" class="form-control" placeholder="yyyy-mm-dd" required>
          <div class="error-message" id="startDate-error">Start Date is required.</div>
        </div>
        <div class="mb-3">
          <label for="dueDate" class="form-label"><strong>Due Date:</strong></label>
          <input id="dueDate" name="dueDate" type="text" class="form-control" placeholder="yyyy-mm-dd" required>
          <div class="error-message" id="dueDate-error">Due Date is required and must be later than the Start Date.</div>
        </div>
        <div class="mb-3" style="display: none">
          <label for="studentEmail" class="form-label"><strong>Optional-Email: get your writing plan sent to your inbox</strong></label>
          <input id="studentEmail" name="studentEmail" type="text" class="form-control" placeholder="username@domain.com">
        </div>
        <div class="mb-3">
          <input type="reset" name="reset" class="btn btn-secondary" value="Reset">
          <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </div>
      </form>
      <script src="js/datePickers.js"></script>
      <script>

        // Set today's date as the placeholder for Start Date
        var today = new Date();
        var yyyy = today.getFullYear();
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var dd = String(today.getDate()).padStart(2, '0');
        var formattedDate = yyyy + '-' + mm + '-' + dd;
        document.getElementById("startDate").setAttribute("value", formattedDate);

        function validateForm() {
          var startDate = document.getElementById("startDate").value;
          var dueDate = document.getElementById("dueDate").value;
          var startDateError = document.getElementById("startDate-error");
          var dueDateError = document.getElementById("dueDate-error");

          // Reset error messages
          startDateError.style.display = "none";
          dueDateError.style.display = "none";

          if (startDate === "") {
            startDateError.style.display = "block";
            return false; // Prevent form submission
          }

          if (dueDate === "") {
            dueDateError.style.display = "block";
            return false; // Prevent form submission
          }

          // Convert the date strings to Date objects for comparison
          var startDateObj = new Date(startDate);
          var dueDateObj = new Date(dueDate);

          if (dueDateObj <= startDateObj) {
            dueDateError.style.display = "block";
            return false; // Prevent form submission
          }
        }
      </script>
    </article>
  </main>

  <?php
      require("footer.php");
    ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>