<?php

namespace Devbook\utility;

class CommonFile
{
    public static function getFile(string $fileField): array
    {
        return !empty($_FILES[$fileField]['tmp_name']) ? $_FILES[$fileField] : [];
    }

    public static function makeImage(array $file, int $width, int $height, string $type, int $quality = 90): string
    {
        if (in_array($file['type'], ['image/jpg', 'image/jpeg', 'image/png', 'image/bmp', 'image/webp'])) {
            $fileWidth = $width;
            $fileHeight = $height;
            list($originalWidth, $originalHeight) = getImageSize($file['tmp_name']);
            $ratio = $originalWidth / $originalHeight;
            $newWidth = $fileWidth;
            $newHeight = $newWidth / $ratio;

            if ($newHeight < $fileHeight) {
                $newHeight = $fileHeight;
                $newWidth = $newHeight * $ratio;
            }

            $x = $fileWidth - $newWidth;
            $y = $fileHeight - $newHeight;
            $x = $x < 0 ? $x / 2 : $x;
            $y = $y < 0 ? $y / 2 : $y;
            $canvas = imagecreatetruecolor($fileWidth, $fileHeight);
            $image = '';

            switch ($file['type']) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($file['tmp_name']);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file['tmp_name']);
                    break;
                case 'image/webp':
                    $image = imagecreatefromwebp($file['tmp_name']);
                    break;
            }

            $alphaChannel = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagecolortransparent($canvas, $alphaChannel);
            imagefill($canvas, 0, 0, $alphaChannel);
            imagecopyresampled(
                $canvas, $image, $x, $y, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight
            );

            switch ($type) {
                case 'cover':
                    $folder = 'covers';
                    break;
                case 'avatar':
                    $folder = 'avatars';
                    break;
                case 'upload':
                    $folder = 'uploads';
                    break;
                default:
                    $folder = '';
                    break;
            }

            $fileName = md5(time() . rand(0, 99999)) . '.webp';
            if (imagewebp($canvas, "./media/$folder/$fileName", 90)) {
                imagedestroy($canvas);
                return $fileName;
            }
        }
        return '';
    }
}
