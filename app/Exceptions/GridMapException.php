<?php

namespace App\Exceptions;

use App\Constants\GridMap\GridMapExceptionConstants;
use App\Constants\GridMap\GridMapStringConstants;

class GridMapException extends \Exception
{
    /**
     * @return GridMapException
     */
    public static function invalidAxesCount(): GridMapException
    {
        return new self(
            GridMapStringConstants::INVALID_AXES_COUNT_EXCEPTION_MESSAGE,
            GridMapExceptionConstants::INVALID_AXES_DATA
        );
    }

    /**
     * @param array $axesData
     * @return GridMapException
     */
    public static function invalidAxesValuesTypeEntered(array $axesData): GridMapException
    {
        return new self(
            GridMapStringConstants::INVALID_AXES_VALUES_TYPE_ENTERED_EXCEPTION_MESSAGE . serialize($axesData),
            GridMapExceptionConstants::INVALID_AXES_DATA
        );
    }
}
