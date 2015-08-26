<!-- app/Resources/views/base.html.php -->
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php $view['slots']->output('title', 'Welcome!') ?></title>
    <?php $view['slots']->output('stylesheets') ?>
    <link rel="shortcut icon" href="<?php echo $view['assets']->getUrl('favicon.ico') ?>" />
    </head>
    <body>
    <?php $view['slots']->output('_content') ?>
    <?php $view['slots']->output('stylesheets') ?>
    </body>
</html>