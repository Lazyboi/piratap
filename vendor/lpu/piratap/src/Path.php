<?php
namespace LPU;

class Path
{
    /**
     * Get the html layout file path.
     *
     * @param string $layout
     *
     * @return string
     */
    public static function getLayout($layout)
    {
        return Config::get('path')['base_path'] . Config::get('path')['layout_path'] . "/{$layout}.php";
    }

    /**
     * Get the html content file path.
     *
     * @param string $content
     *
     * @return string
     */
    public static function getContent($content)
    {
        return Config::get('path')['base_path'] . Config::get('path')['content_path'] . "/{$content}/{$content}.php";
    }

    /**
     * Get the user image file path
     *
     * @param string $image
     *
     * @return array
     */
    public static function getUserImage($image)
    {
        return Config::get('path')['base_path'] . Config::get('path')['user_image_path'] . "/{$image}.jpg";
    }
}
