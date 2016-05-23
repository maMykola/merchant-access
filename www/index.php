<?php

require_once __DIR__ . '/../include/core.php';

echo $twig->render('Index/index.html.twig', [
        'title' => 'Dashboard',
    ]);
