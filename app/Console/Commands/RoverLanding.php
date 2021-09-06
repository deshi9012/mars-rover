<?php

namespace App\Console\Commands;

use App\Constants\Common\InitialLandingInformation;
use Illuminate\Console\Command;
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
        $grid->setAxesLength($gridMapSize);

        $roverCoordinates = $this->ask(InitialLandingInformation::ENTER_ROVER_COORDINATES);
        $roverDirection = $this->ask(InitialLandingInformation::ENTER_ROVER_DIRECTION);

        $roverModel = new Rover();
        $roverModel->setCoordinates($roverCoordinates);
        $roverModel->setDirection($roverDirection);

        $roverNavigationCommands = $this->ask(InitialLandingInformation::ENTER_ROVER_MOVING_COMMANDS);

        $landingMission = new LandingService($roverModel, $grid);

        $landingMission->executeCommands($roverNavigationCommands);

        $this->info($landingMission->getFinalCoordinatesAndDirection());
    }
}
