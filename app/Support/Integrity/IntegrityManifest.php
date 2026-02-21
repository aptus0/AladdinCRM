<?php

namespace App\Support\Integrity;

use Illuminate\Support\Facades\File;

class IntegrityManifest
{
    /**
     * @param  list<string>  $paths
     * @return array{
     *     generated_at: string,
     *     paths: list<string>,
     *     files: array<string, string>
     * }
     */
    public function snapshot(array $paths): array
    {
        $normalizedPaths = $this->normalizePaths($paths);
        $files = [];

        foreach ($normalizedPaths as $path) {
            $absolutePath = base_path($path);

            if (! File::exists($absolutePath)) {
                continue;
            }

            if (File::isFile($absolutePath)) {
                $relativePath = $this->relativePath($absolutePath);
                $files[$relativePath] = hash_file('sha256', $absolutePath) ?: '';

                continue;
            }

            foreach (File::allFiles($absolutePath) as $file) {
                $realPath = $file->getRealPath();

                if ($realPath === false) {
                    continue;
                }

                $relativePath = $this->relativePath($realPath);
                $files[$relativePath] = hash_file('sha256', $realPath) ?: '';
            }
        }

        ksort($files);

        return [
            'generated_at' => now()->toIso8601String(),
            'paths' => $normalizedPaths,
            'files' => $files,
        ];
    }

    /**
     * @param  array{
     *     generated_at?: string,
     *     paths?: list<string>,
     *     files?: array<string, string>
     * }  $manifest
     * @return array{
     *     changed: list<string>,
     *     added: list<string>,
     *     removed: list<string>
     * }
     */
    public function compare(array $manifest): array
    {
        $paths = isset($manifest['paths']) && is_array($manifest['paths'])
            ? $manifest['paths']
            : ['app', 'config', 'routes', 'resources', 'database'];

        $current = $this->snapshot($paths);
        $previousFiles = isset($manifest['files']) && is_array($manifest['files']) ? $manifest['files'] : [];
        $currentFiles = $current['files'];

        $changed = [];
        $added = [];
        $removed = [];

        foreach ($currentFiles as $path => $hash) {
            if (! array_key_exists($path, $previousFiles)) {
                $added[] = $path;

                continue;
            }

            if ($previousFiles[$path] !== $hash) {
                $changed[] = $path;
            }
        }

        foreach ($previousFiles as $path => $hash) {
            if (! array_key_exists($path, $currentFiles)) {
                $removed[] = $path;
            }
        }

        sort($changed);
        sort($added);
        sort($removed);

        return [
            'changed' => $changed,
            'added' => $added,
            'removed' => $removed,
        ];
    }

    /**
     * @param  list<string>  $paths
     * @return list<string>
     */
    private function normalizePaths(array $paths): array
    {
        $normalized = array_values(array_filter(array_map(
            fn (string $path): string => trim(str_replace('\\', '/', $path), '/'),
            $paths,
        )));

        return array_values(array_unique($normalized));
    }

    private function relativePath(string $absolutePath): string
    {
        $base = rtrim(str_replace('\\', '/', base_path()), '/').'/';
        $normalizedPath = str_replace('\\', '/', $absolutePath);

        if (str_starts_with($normalizedPath, $base)) {
            return substr($normalizedPath, strlen($base));
        }

        return $normalizedPath;
    }
}
