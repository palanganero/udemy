<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TiempoExtension extends AbstractExtension
{
    const CONFIGURACION =["formato"=>"Y-m-d H:m:s"];
    public function getFilters()
    {
        return [new TwigFilter("tiempo",[$this,"formatearTiempo"]),];
    }
    public function formatearTiempo ($fecha,$configuracion=[])
    //public function formatearTiempo ($fecha)
    {
        //$fechaActual= new \DateTime();
        
        $configuracion=array_merge(self::CONFIGURACION,$configuracion);
        $fechaActual= new \DateTime();
        $fechaFormateada=$fecha->format($configuracion["formato"]);
        
        $fechaDiferenciaSegundos=$fechaActual->getTimestamp() - $fecha->getTimestamp();
        if ($fechaDiferenciaSegundos<60)
        {
            $fechaFormateada="Creado ahora mismo";
        }
        else if($fechaDiferenciaSegundos<3600)
        {
            $fechaFormateada="Creado ahora recientemente";
        }
        else if($fechaDiferenciaSegundos<14400)
        {
            $fechaFormateada="Creado hace unas horas";
        }
        return $fechaFormateada;
         
        //return $fecha->getTimestamp()-$fechaActual->getTimestamp()." ostia";
        //return $fecha->format("Y-m-d H:m:s");
    }
}
