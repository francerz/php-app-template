<?=$layout = $view->loadLayout('@layouts/default')?>
<?=$layout->startSection('content')?>
<h1><?=$title ?? 'Welcome!'?></h1>
<p>Page loading test completed successfully!</p>
<?=$layout->endSection()?>
