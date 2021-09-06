<?php
namespace App\Traits;

trait AxesTrait{

    /**
     * @param $comparedAxisLength
     * @param $comparingPositionCoordinates
     * @return bool
     */
    public function isOverAxisLimitation($comparedAxisLength, $comparingPositionCoordinates) : bool
    {
        return $comparingPositionCoordinates < 0 || $comparingPositionCoordinates > $comparedAxisLength;
    }
}
