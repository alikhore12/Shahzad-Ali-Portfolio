<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HandlesUploads
{
    protected function storeUpload(?UploadedFile $file, string $directory): ?string
    {
        if (! $file) {
            return null;
        }

        $name = now()->format('Y-m-d-His').'-'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->guessExtension();

        $file->move(public_path($directory), $name);

        return $directory.'/'.$name;
    }

    protected function removeUpload(?string $path): void
    {
        if (! $path || Str::startsWith($path, ['http://', 'https://', '//'])) {
            return;
        }

        $absolute = public_path($path);

        if (is_file($absolute)) {
            @unlink($absolute);
        }
    }

    protected function lines(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
