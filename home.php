<?php
// Include the template functions
require_once 'functions.php';
require_once 'init.php';
// Output the header
template_header('Home');
?>
<div class="text-center">
    <h1 class="display-4">Welcome to Fixer Upper!</h1>
    <p class="lead">High-quality home hardware at unbeatable prices.</p>

    <div class="position-relative d-inline-block mt-4">
        <img src="img/home.jpg" alt="FixerUpper Home" class="img-fluid rounded shadow" style="max-width: 900px;">
    </div>
</div>

<!-- Page content ends here -->


<?php
// Output the footer
template_footer();
?>
