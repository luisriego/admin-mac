<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('weather_icon', array($this, 'weatherIcon')),
            new \Twig_SimpleFilter('labelColour', array($this, 'labelColour')),
        );
    }

    public function weatherIcon($code)
    {
        if (is_numeric($code)) {
            switch ($code) {
                case 47:
                    $icon = 'wi wi-thunderstorm';
                    break;
                case 31:
                case 32:
                case 33:
                case 34:
                case 36:
                    $icon = 'wi wi-day-sunny';
                    break;
                case 26:
                    $icon = 'wi wi-cloud';
                    break;
                case 27:
                case 28:
                case 29:
                case 30:
                    $icon = 'wi wi-day-cloudy';
                    break;
                case 12:
                case 40:
                    $icon = 'wi wi-showers';
                    break;
                case 0:
                case 1:
                case 2:
                case 3:
                case 4:
                    $icon = 'wi wi-rain';
                    break;
                default:
                    $icon = 'wi wi-refresh';
            }
        }else {
            switch ($code) {
                case 'sunny':
                    $icon = 'wi wi-day-sunny';
                    break;
                case 'cloud':
                    $icon = 'wi wi-day-cloudy';
                    break;
                case 'cloudly_day':
                    $icon = 'wi wi-day-cloudy-high';
                    break;
                case 'storm':
                    $icon = 'wi wi-thunderstorm';
                    break;
                case 'rain':
                    $icon = 'wi wi-rain';
                    break;
                default:
                    $icon = 'wi wi-refresh';
            }
        }

        return $icon;
    }

    public function labelColour($status)
    {
        switch ($status) {
            case "aberto":
                $label = "label-danger !important";
                break;
            case "analise":
                $label = "label-warning";
                break;
            case "aprovacao":
                $label = "label-primary";
                break;
            case "reprovado":
                $label = "label-default";
                break;
            case "em-execucao":
                $label = "label-success";
                break;
            case "agendado":
                $label = "label-info";
                break;
            case "dependo-do-cliente":
                $label = "label-success";
                break;
            case "dependo-de-pecas":
                $label = "label-success";
                break;
            case "finalizado":
                $label = "label-inverse";
                break;
            default:
                $label = "label-warning";
        }

        return $label;
    }
}