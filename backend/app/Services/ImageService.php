<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Valida y sube una imagen al almacenamiento público.
     *
     * @param UploadedFile $image
     * @return string URL pública de la imagen subida
     */
    public function uploadImage(UploadedFile $image): string
    {
        // Validar el archivo (puedes mover esta lógica al controlador si prefieres)
        $this->validateImage($image);

        // Guardar la imagen en storage/app/public/images
        $path = $image->store('images', 'public');

        // Retornar la URL accesible públicamente
        return $this->getPublicUrl($path);
    }

    /**
     * Valida que el archivo sea una imagen válida.
     *
     * @param UploadedFile $image
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateImage(UploadedFile $image): void
    {
        $rules = [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        validator(['image' => $image], $rules)->validate();
    }

    /*
     * Genera la URL pública de un archivo almacenado.
     *
     * @param string $path
     * @return string
     */
    protected function getPublicUrl(string $path): string
    {
        return asset("storage/{$path}");
    }
}