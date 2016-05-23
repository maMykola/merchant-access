<?php

require_once __DIR__ . '/../include/core.php';

$stores = [
    ['id' => 1, 'name' => 'Store 1'],
    ['id' => 2, 'name' => 'Store 2'],
    ['id' => 3, 'name' => 'Store 3'],
];

echo $twig->render('Stores/index.html.twig', [
        'title' => 'List of Stores',
        'all_stores' => $stores,
    ]);
