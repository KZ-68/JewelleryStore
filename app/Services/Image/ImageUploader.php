<?php

namespace App\Services\Image;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ImageUploader
{
    /**
     * Types MIME réels autorisés
     */
    private const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    /**
     * Extensions autorisées.
     */
    private const ALLOWED_EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
    ];

    /**
     * Taille maximale autorisée : 2 Mo.
     */
    private const MAX_FILE_SIZE = 2 * 1024 * 1024;

    public function __construct(
        private readonly string $disk = 'public',
        private readonly string $directory = 'images',
    ) {}

    /**
     * Valide et déplace le fichier uploadé vers le disque configuré.
     * Retourne le nom du fichier stocké.
     *
     * @throws InvalidArgumentException si le fichier ne passe pas la validation
     */
    public function upload(UploadedFile $file): string
    {
        $this->validate($file);

        $filename = $this->generateSafeFilename($file);

        Storage::disk($this->disk)->putFileAs(
            $this->directory,
            $file,
            $filename
        );

        return $filename;
    }

    /**
     * Valide et stocke l'image d'un produit dans img/p/{productId}/.
     * Le fichier est nommé product-{index}.{extension} pour être compatible avec ProductImageService.
     * Retourne le nom du fichier stocké (ex: "product-1.jpg").
     *
     * @throws InvalidArgumentException si le fichier ne passe pas la validation
     */
    public function uploadForProduct(UploadedFile $file, int $productId): string
    {
        $this->validate($file);

        $extension = strtolower($file->getClientOriginalExtension());
        $directory = "img/p/{$productId}";

        $existingFiles = Storage::disk($this->disk)->files($directory);
        $index = count($existingFiles) + 1;

        $filename = "product-{$index}.{$extension}";

        Storage::disk($this->disk)->putFileAs($directory, $file, $filename);

        return $filename;
    }

    /**
     * Supprime un fichier du disque.
     */
    public function delete(string $filename): bool
    {
        return Storage::disk($this->disk)->delete("{$this->directory}/{$filename}");
    }

    /**
     * Retourne l'URL publique d'un fichier.
     */
    public function getUrl(string $filename): string
    {
        return Storage::disk($this->disk)->url("{$this->directory}/{$filename}");
    }

    /**
     * Valide le fichier contre les vecteurs d'attaque courants sur l'upload.
     *
     * @throws InvalidArgumentException
     */
    private function validate(UploadedFile $file): void
    {
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new InvalidArgumentException(
                'Le fichier dépasse la taille maximale autorisée (2 Mo).'
            );
        }

        $realMime = $file->getMimeType();

        if (!in_array($realMime, self::ALLOWED_MIME_TYPES, true)) {
            throw new InvalidArgumentException(
                "Type de fichier non autorisé : {$realMime}."
            );
        }

        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new InvalidArgumentException(
                "Extension de fichier non autorisée : {$extension}."
            );
        }

        if (!$this->isValidImage($file)) {
            throw new InvalidArgumentException(
                'Le fichier ne peut pas être traité comme une image valide.'
            );
        }
    }

    /**
     * Génère un nom de fichier sûr et non prédictible.
     *
     * - Str::slug() assainit le nom original (supprime les caractères spéciaux,
     *   neutralise les doubles extensions comme "shell.php" → "shell-php").
     * - Str::random(16) génère une chaîne aléatoire cryptographiquement sûre
     *   (contrairement à uniqid() basé sur le timestamp µs, prédictible).
     */
    private function generateSafeFilename(UploadedFile $file): string
    {
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBasename = Str::slug($basename);
        $extension = strtolower($file->getClientOriginalExtension());

        return $safeBasename . '-' . Str::random(16) . '.' . $extension;
    }

    /**
     * Vérifie via GD que le fichier est une image réelle et non corrompue.
     */
    private function isValidImage(UploadedFile $file): bool
    {
        if (!function_exists('getimagesize')) {
            return true; // GD non disponible, on se fie aux contrôles MIME/extension.
        }

        $imageInfo = @getimagesize($file->getRealPath());

        return $imageInfo !== false;
    }
}
