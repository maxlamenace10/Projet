<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

class FileToStringTransformer implements DataTransformerInterface
{
    public function transform($file)
    {
        if (null === $file) {
            return '';
        }
        if (!is_object($file) || !$file instanceof File) {
            throw new \LogicException('The file is not a valid instance.');
        }
    
        return $file->getFilename();
    }
    
    public function reverseTransform($filename)
    {
        if (!$filename) {
            return null;
        }
    
        return new File($filename);
    }
}