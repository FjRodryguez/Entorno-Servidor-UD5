<?php

declare(strict_types=1);

namespace Com\Daw2\Libraries;

use GuzzleHttp\Client;

class RemoteImageDownloader
{
    /**
     * Descarga una imagen dada una $uri y la guarda en la ruta especificada
     * @param string $uri URI donde se aloja la imagen
     * @param string $to Ubicación en la que queremos guardar las imágenes de usuarios
     * @return bool true si se guarda correctamente, false en caso contrario
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadFromUri(string $uri, string $to): bool
    {
        $client = new Client();
        $response = $client->get($uri);
        if ($response->getStatusCode() !== 200) {
            return false;
        } else {
            $imageContent = $response->getBody()->getContents();
            file_put_contents($to, $imageContent);
            return true;
        }
    }
}
