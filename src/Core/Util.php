<?php
/**
 * Created by PhpStorm.
 * User: kostjami
 * Date: 19.09.18
 * Time: 15:51
 */

namespace App\Core;


class Util
{
    const USER_ANONYMOUS = 'anonymous';
    /**
     * Class casting
     *
     * @param string|object $destination
     * @param object $sourceObject
     * @return object
     */
    static function cast($destination, $sourceObject)
    {
        if (is_string($destination)) {
            $destination = new $destination();
        }
        $sourceReflection = new \ReflectionObject($sourceObject);
        $destinationReflection = new \ReflectionObject($destination);
        $sourceProperties = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            $name = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);
            if ($destinationReflection->hasProperty($name)) {
                $propDest = $destinationReflection->getProperty($name);
                $propDest->setAccessible(true);
                $propDest->setValue($destination,$value);
            }
        }
        return $destination;
    }

    static function hasClassProperty(string $className, string $fieldIn): bool
    {
        $res = false;
        try {
            $sourceReflection = new \ReflectionClass($className);
            $res = $sourceReflection->hasProperty($fieldIn);
        } catch (\ReflectionException $e) {
        }
        return $res;
    }

    static function redirect($uri, $statusCode = 302)
    {
        header('Location: ' .$_SERVER['REQUEST_SCHEME'] .'://'.$_SERVER['HTTP_HOST']. $uri, true, $statusCode);
        die();
    }

    static function setSessionUser(string $user)
    {
        $_SESSION['current_user'] = $user;
    }

    static function getSessionUser()
    {
        if (!isset($_SESSION['current_user'])) {
            $_SESSION['current_user'] = self::USER_ANONYMOUS;
        }

        return $_SESSION['current_user'];
    }

    static function resizeImage($file, $imageType, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }

        switch ($imageType) {
            case 'image/jpeg':
                $src = imagecreatefromjpeg($file);
                break;
            case 'image/gif':
                $src = imagecreatefromgif($file);
                break;
            default:
                $src = imagecreatefrompng($file);
                break;
        }
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }
}