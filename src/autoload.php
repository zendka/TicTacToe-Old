<?php

// Autoload Classes
spl_autoload_register(function ($class) {
    $parts = explode('\\', $class);
    require end($parts) . '.php';
});
