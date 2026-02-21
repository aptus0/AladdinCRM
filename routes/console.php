<?php

use App\Support\Integrity\IntegrityManifest;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:integrity:snapshot {--paths=app,config,routes,resources,database} {--output=storage/app/integrity-manifest.json}', function (): int {
    $pathsOption = (string) $this->option('paths');
    $paths = array_values(array_filter(array_map('trim', explode(',', $pathsOption))));
    $output = (string) $this->option('output');
    $outputPath = str_starts_with($output, '/')
        ? $output
        : base_path(trim($output, '/'));

    /** @var IntegrityManifest $integrityManifest */
    $integrityManifest = app(IntegrityManifest::class);
    $snapshot = $integrityManifest->snapshot($paths);

    $outputDirectory = dirname($outputPath);
    if (! File::exists($outputDirectory)) {
        File::makeDirectory($outputDirectory, 0755, true);
    }

    File::put(
        $outputPath,
        json_encode($snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL,
    );

    $this->info(sprintf('Integrity manifest generated: %s', $outputPath));
    $this->line(sprintf('Tracked files: %d', count($snapshot['files'])));

    return Command::SUCCESS;
})->purpose('Generate SHA256 integrity snapshot for selected project paths');

Artisan::command('app:integrity:check {--input=storage/app/integrity-manifest.json}', function (): int {
    $input = (string) $this->option('input');
    $inputPath = str_starts_with($input, '/')
        ? $input
        : base_path(trim($input, '/'));

    if (! File::exists($inputPath)) {
        $this->error(sprintf('Integrity manifest not found: %s', $inputPath));

        return Command::FAILURE;
    }

    $content = File::get($inputPath);
    $decoded = json_decode($content, true);

    if (! is_array($decoded)) {
        $this->error('Integrity manifest is not valid JSON.');

        return Command::FAILURE;
    }

    /** @var IntegrityManifest $integrityManifest */
    $integrityManifest = app(IntegrityManifest::class);
    $diff = $integrityManifest->compare($decoded);

    if ($diff['changed'] === [] && $diff['added'] === [] && $diff['removed'] === []) {
        $this->info('Integrity check passed: no file changes detected.');

        return Command::SUCCESS;
    }

    $this->warn('Integrity check detected file changes.');

    if ($diff['changed'] !== []) {
        $this->line('Changed files:');
        foreach ($diff['changed'] as $path) {
            $this->line('  - '.$path);
        }
    }

    if ($diff['added'] !== []) {
        $this->line('Added files:');
        foreach ($diff['added'] as $path) {
            $this->line('  + '.$path);
        }
    }

    if ($diff['removed'] !== []) {
        $this->line('Removed files:');
        foreach ($diff['removed'] as $path) {
            $this->line('  x '.$path);
        }
    }

    return Command::FAILURE;
})->purpose('Compare current file hashes against integrity manifest');
