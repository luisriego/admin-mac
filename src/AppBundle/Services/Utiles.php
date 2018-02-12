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
        if ($this->get_http_response_code('https://api.hgbrasil.com/weather/?format=json&woeid=455821') == 200){
           
            // Primero guradamos en data los valores obtenidos de la api weather
            $json = file_get_contents('https://api.hgbrasil.com/weather/?format=json&woeid=455821');

            // convertimos ese JSON a um array
            $obj = json_decode($json, true);    
            
        }else {
            dump('hola');
            $obj = array (
                        'by' => 'woeid',
                        'valid_key' => false,
                        'results' => 
                        array (
                          'temp' => null,
                          'date' => '',
                          'time' => '',
                          'condition_code' => null,
                          'description' => 'Sem dados',
                          'currently' => 'Sem dados',
                          'cid' => '',
                          'city' => 'Belo Horizonte,',
                          'img_id' => null,
                          'humidity' => null,
                          'wind_speedy' => null,
                          'sunrise' => null,
                          'sunset' => null,
                          'condition_slug' => 'Sem dados',
                          'city_name' => 'Belo Horizonte',
                          'forecast' => 
                          array (
                            0 => 
                            array (
                              'date' => '',
                              'weekday' => '',
                              'max' => '',
                              'min' => '',
                              'description' => '',
                              'condition' => '',
                            ),
                            1 => 
                            array (
                              'date' => '',
                              'weekday' => '',
                              'max' => '',
                              'min' => '',
                              'description' => '',
                              'condition' => '',
                            ),
                            2 => 
                            array (
                              'date' => '',
                              'weekday' => '',
                              'max' => '',
                              'min' => '',
                              'description' => '',
                              'condition' => '',
                            ),
                            3 => 
                            array (
                              'date' => '',
                              'weekday' => '',
                              'max' => '',
                              'min' => '',
                              'description' => '',
                              'condition' => '',
                            ),
                            4 => 
                            array (
                              'date' => '',
                              'weekday' => '',
                              'max' => '',
                              'min' => '',
                              'description' => '',
                              'condition' => '',
                            ),
                          ),
                        ),
                        'execution_time' => 0,
                        'from_cache' => true,
                      );
            dump($obj);
        }

        

        return $obj;
    }
    
    private function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}
}