<?php
namespace LPU;

class Url
{
    /**
     * Get the user image file url
     *
     * @param string $image
     *
     * @return array
     */
    public static function getUserImage($image)
    {
        return Config::get('url')['user_image_url'] . "/{$image}.jpg";
    }
}
