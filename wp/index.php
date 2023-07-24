<main class="container">
    <article id="planner">

      <?php
        $title = "Writing Planner";

        require_once("head.php");
        require_once("header.php");
      ?>

      <h2>Writing is a process! Use this writing planner to save yourself time and create a better paper.</h2>
      <p class="hide"><strong>Please enter a start date and a due date for your writing assignment, then complete the rest of the form and click submit.</strong></p>
      <form action="planner.php" method="post">
        <div class="mb-3">
          <label for="startDate" class="form-label"><strong>Start Date:</strong></label>
          <input id="startDate" name="startDate" type="text" class="form-control" placeholder="yyyy-mm-dd" required>
        </div>
        <div class="mb-3">
          <label for="dueDate" class="form-label"><strong>Due Date:</strong></label>
          <input id="dueDate" name="dueDate" type="text" class="form-control" placeholder="yyyy-mm-dd" required>
        </div>
        <div class="mb-3">
          <label for="studentEmail" class="form-label"><strong>Optional-Email: get your writing plan sent to your inbox</strong></label>
          <input id="studentEmail" name="studentEmail" type="text" class="form-control" placeholder="username@domain.com">
        </div>
        <div class="mb-3">
          <input type="reset" name="reset" class="btn btn-secondary" value="Reset">
          <input type="submit" name="submit" class="btn btn-success" value="Submit">
        </div>
      </form>

      <script src="js/datePickers.js"></script>

      

    </article>
  </main>

  <?php
      require("footer.php");
    ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>