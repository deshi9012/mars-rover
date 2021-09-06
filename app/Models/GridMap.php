<?php

namespace App\Models;

use App\Constants\GridMap\GridMapCommonConstants;
use App\Exceptions\GridMapException;
use Illuminate\Database\Eloquent\Model;

class GridMap extends Model
{
    /**
     * @var
     */
    private $xAxisLength;

    /**
     * @var
     */
    private $yAxisLength;

    /**
     * @return array
     */
    public function getCoordinates(): array
    {
        return [$this->xAxisLength, $this->yAxisLength];
    }


    /**
     * @param string $gridData
     * @throws GridMapException
     */
    public function setAxesLength(string $gridData): void
    {
        $gridCoordinates = explode(GridMapCommonConstants::AXES_DELIMITER, $gridData);
        if (count($gridCoordinates) != GridMapCommonConstants::AXES_COUNT) {
            throw GridMapException::invalidAxesCount();
        }

        if (!is_numeric($gridCoordinates[0]) || !is_numeric($gridCoordinates[1])) {
            throw GridMapException::invalidAxesValuesTypeEntered($gridCoordinates);
        }

        [$this->xAxisLength, $this->yAxisLength] = $gridCoordinates;
    }
}
