<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 08/12/17
 * Time: 16:34
 */

namespace AppBundle\Service;

/**
 * Class Sluggifier
 * This class replace every special character with a "-"
 * Here, special characters are mostly french accents
 *
 * @package AppBundle\Service
 */
class Sluggifier
{

    /**
     * Sluggify the given string
     * Replace every special character with a "-"
     *
     * @param $string
     * @return mixed|string
     */
    public function sluggify($string){

        // Call the stripAccent property on given string
        $slug = $this->stripAccents($string);

        // Format and return the string chain in lower characters
        return strtolower($slug);

    }

    /**
     * Replace the specified characters in the first array
     * by the matched one in the second array
     * Ex: ' ' will become '-'
     *     'è' will become 'e'
     *
     * @param $str
     * @return mixed
     */
    public function stripAccents($str) {

        // Replace the specified characters in given string chain
        $str = str_replace(

            // Array of forbidden characters
            array(
                'à', 'â', 'á', 'À', 'Â', 'Á',
                'î', 'Î',
                'ô', 'ö', 'Ô', 'Ö',
                'ù', 'û', 'ú', 'Ù', 'Û', 'Ú',
                'é', 'è', 'ê', 'ë', 'É', 'È', 'Ê', 'Ë',
                'ç', 'Ç',
                '\'', ' '
            ),

            // Replacement characters for forbidden ones
            array(
                'a', 'a', 'a', 'a', 'a', 'a',
                'i', 'i',
                'o', 'o', 'o', 'o',
                'u', 'u', 'u', 'u', 'u', 'u',
                'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                'c', 'c',
                '-', '-'
            ),

            // Target is given string
            $str
        );

        // Return the sluggified given string
        return $str;
    }

}
