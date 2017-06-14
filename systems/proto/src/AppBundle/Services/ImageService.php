<?php

namespace AppBundle\Services;

use Cloudinary\Uploader;

class ImageService
{

    /**
     * ImageService constructor.
     */
    public function __construct($cloudName, $apiKey, $apiSecret)
    {
        \Cloudinary::config(array(
            "cloud_name" => $cloudName,
            "api_key" => $apiKey,
            "api_secret" => $apiSecret
        ));
    }

    public function upload($image)
    {
        return Uploader::upload($image)['secure_url'];
    }
}