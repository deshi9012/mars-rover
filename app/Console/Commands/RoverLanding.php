<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Constants\Common\InitialLandingInformation;
use App\Exceptions\GridMapException;
use App\Exceptions\RoverException;
use App\Services\Landing\LandingService;
use App\Models\GridMap;
use App\Models\Rover;

class RoverLanding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'landing:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws GridMapException
     * @throws RoverException
     */
    public function handle(): void
    {
        $gridMapSize = $this->ask(InitialLandingInformation::ENTER_GRID_MAP_SIZE);

        $grid = new GridMap();
        $grid->setAxesLengths($gridMapSize);
        $roverLimitations = $grid->getAxesLengths();

        $roverCoordinates = $this->ask(InitialLandingInformation::ENTER_ROVER_COORDINATES);
        $roverModel = new Rover($roverLimitations);
        $roverModel->setCoordinates($roverCoordinates);

        $roverDirection = $this->ask(InitialLandingInformation::ENTER_ROVER_DIRECTION);
        $roverModel->setDirection($roverDirection);

        $roverNavigationCommands = $this->ask(InitialLandingInformation::ENTER_ROVER_MOVING_COMMANDS);

        $landingMission = new LandingService($roverModel);
        $landingMission->executeCommands($roverNavigationCommands);

        $this->info($landingMission->getFinalCoordinatesAndDirection());
    }
}
