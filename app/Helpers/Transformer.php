<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 1/7/2018 AD
 * Time: 11:33
 */

namespace ImageGallery\Helpers;

use ImageGallery\Transformers;

class Transformer
{

    protected static $namespace = '\ImageGallery\Repositories\Transformers\\';

    public static function getTransformer($transformer)
    {
        $transformerClass = studly_case($transformer . '_transformer');
        $class = static::$namespace . $transformerClass;
        if (class_exists($class)) {
            return new $class();
        }

        return null;
    }

}