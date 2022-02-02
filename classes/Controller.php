<?php
use Illuminate\Support;  // https://laravel.com/docs/5.8/collections - provides the collect methods & collections class
require_once('classes/Exporter.php');
require_once ('classes/IController.php');

class Controller extends Request implements IController {

    public function __construct() {
        parent::__construct();
        $this->args = $this->requestCollection;
    }

    public function export($type, $format) {
        $data = [];
        $exporter = new Exporter();
        switch ($type) {
            case 'playerstats':
                $search = $this->searchAgs();
                $data = $exporter->getPlayerStats($search);
                break;
            case 'players':
                $search = $this->searchAgs();
                $data = $exporter->getPlayers($search);
                break;
        }
        if (!$data) {
            exit("Error: No data found!");
        }
        return $exporter->format($data, $format);
    }

    private function searchAgs() {
        $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
        $search = $this->args->filter(function($value, $key) use ($searchArgs) {
            return in_array($key, $searchArgs);
        });
        return $search;
    }

    public function process() {
        $format = $this->getVar('format') ?: 'html';
        $type = $this->getVar('type');

        if (!$type) {
            exit('Please specify a type');
        }

        echo $this->export($type, $format);
    }
}