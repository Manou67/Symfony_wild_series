<?php

namespace App\Service;

class Slugify
{
    public function generate(string $input) : string
    {
        $input = str_replace(' ', '-', $input);
        $input = str_replace('ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy', $input);
        $input = preg_replace('/--+/', '-', $input);
        $input = strtolower($input);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $input);
    }
}
