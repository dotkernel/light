<?php

declare(strict_types=1);

// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

/**
 * @param array{source: string, destination: string} $file
 */
function copyFile(array $file): void
{
    if (is_readable($file['destination'])) {
        echo "File {$file['destination']} already exists." . PHP_EOL;
    } else {
        if (! copy($file['source'], $file['destination'])) {
            echo "Cannot copy {$file['source']} file to {$file['destination']}" . PHP_EOL;
        } else {
            echo "File {$file['source']} copied successfully to {$file['destination']}." . PHP_EOL;
        }
    }
}

$files = [
    [
        'source'      => 'config/autoload/local.php.dist',
        'destination' => 'config/autoload/local.php',
    ],
];

array_walk($files, 'copyFile');
