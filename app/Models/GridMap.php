<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class GridMap extends Model
{
    private $xAxis;
    private $yAxis;

    public function getXAxis():int
    {
        return $this->xAxis;
    }

    public function getYAxis():int
    {
        return $this->yAxis;
    }

    public function setAxisesData(string $gridData):void
    {
        $gridCoordinates = explode('x', $gridData);
        if (count($gridCoordinates) != 2) {
            throw new Exception('Invalid grid data!');
        }

        if (!is_numeric($gridCoordinates[0]) || !is_numeric($gridCoordinates[1])) {
            throw new Exception('Invalid grid data!');
        }


        $this->xAxis = $gridCoordinates[0];
        $this->yAxis = $gridCoordinates[1];
    }
}
