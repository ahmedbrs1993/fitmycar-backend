<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

// Force Doctrine to use an in-memory SQLite database during analysis
putenv('DATABASE_URL=sqlite:///:memory:');
$_ENV['DATABASE_URL'] = 'sqlite:///:memory:';
$_SERVER['DATABASE_URL'] = 'sqlite:///:memory:';
