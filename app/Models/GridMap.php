<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class GridMap extends Model
{
    private $xAxisLength;
    private $yAxisLength;

    public function getCoordinates():array
    {
        return [$this->xAxisLength, $this->yAxisLength];
    }

    /**
     * @throws Exception
     */
    public function setAxesLength(string $gridData):void
    {
        $gridCoordinates = explode('x', $gridData);
        if (count($gridCoordinates) != 2) {
            throw new Exception('Invalid grid data!');
        }

        if (!is_numeric($gridCoordinates[0]) || !is_numeric($gridCoordinates[1])) {
            throw new Exception('Invalid grid data!');
        }

        $this->xAxisLength = $gridCoordinates[0];
        $this->yAxisLength = $gridCoordinates[1];
    }
}
