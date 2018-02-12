<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 02/02/18
 * Time: 20:33
 */

namespace AppBundle\Services;


Class Utiles
{
    public function weather() {
        // Primero guradamos en data los valores obtenidos de la api weather
        $json = file_get_contents('https://api.hgbrasil.com/weather/?format=json&woeid=455821');

        // convertimos ese JSON a um array
        if (isset($json)){
            $obj = json_decode($json);
        }else {
            $obj = null;
        }

        return $obj;
    }
}