<?php

use Francerz\Render\HTML;

HTML::layout('@layouts/default');
HTML::startSection('content');
?>
<h1>Welcome!</h1>
<p>Page loading test completed successfully!</p>
<?php
HTML::endSection();
HTML::render();
