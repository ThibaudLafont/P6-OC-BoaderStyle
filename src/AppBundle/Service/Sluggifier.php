<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 08/12/17
 * Time: 16:34
 */

namespace AppBundle\Service;


class Sluggifier
{

    public function sluggify($string){

        $slug = $this->stripAccents($string);
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower($slug);

        return $slug;

    }

    public function stripAccents($str) {
        $str = str_replace(
            array(
                'à', 'â', 'á', 'À', 'Â', 'Á',
                'î', 'Î',
                'ô', 'ö', 'Ô', 'Ö',
                'ù', 'û', 'ú', 'Ù', 'Û', 'Ú',
                'é', 'è', 'ê', 'ë', 'É', 'È', 'Ê', 'Ë',
                'ç', 'Ç',
                '\''
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a',
                'i', 'i',
                'o', 'o', 'o', 'o',
                'u', 'u', 'u', 'u', 'u', 'u',
                'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                'c', 'c',
                ' '
            ), $str);

        return $str;
    }

}
