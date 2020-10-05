<?php
include_once 'GameInterface.php';

class Game implements GameInterface {

    protected $messages = [];

    protected $state;

    public function __construct() 
    {
        $this->start();
    }
    //This function start the timer
    public function start()
    {
        $this->add('Farmer',15,1,1,0);
        $this->add('Cows',10,2,1,0);
        $this->add('Bunnies',8,4,1,0);
        $this->setGameState(SELF::STATE_PLAYING);
    }
    //This function get the game state
    
    //This function get the total bees count
    public function getFarmDetails($type){
        $file = file_get_contents('files/'.$type.'.json');
        $data = json_decode($file, true);
        return $data;
    }
    //This function is used for writing the bees information in json file

    public function getMessages() 
    {
        return $this->messages;
    }
    //This function store message in array
    public function message($message)
    {
        $this->messages[] = $message;
    }
    public function add($type,$feed_turn,$total,$total_turn,$feed_count){
        $details = [
            'name' => $type,
            'feed_turn' => $feed_turn,
            'total'=>$total,
            'total_turn'=>$total_turn,
            'count'=>$feed_count,
            'total_feed_count'=>0,
        ];
        if(!file_exists('files/'.$type.'.json') && $type == 'Farmer'){
            $fp = fopen('files/'.$type.'.json', 'w');
            fwrite($fp, json_encode($details));
            fclose($fp);
        }
        if(!file_exists('files/'.$type.'.json') && $type == 'Cows'){
            $fp = fopen('files/'.$type.'.json', 'w');
            fwrite($fp, json_encode($details));
            fclose($fp);
        }
        if(!file_exists('files/'.$type.'.json') && $type == 'Bunnies'){
            $fp = fopen('files/'.$type.'.json', 'w');
            fwrite($fp, json_encode($details));
            fclose($fp);
        }

    }
    public function writeInFile($arr_write) 
    {        
        $fp = fopen('files/'.$arr_write['name'].'.json', 'w');
        fwrite($fp, json_encode($arr_write));
        fclose($fp); 
    }
    public function deleteFile($type)
    {
        if(unlink("files/".$type.".json")) {
            return true;
        }
        else{
            return false;
        }
    }
    public function getGameState() 
    {
        return $this->state;
    }
    //This function set the game state
    public function setGameState($state) 
    {
        $this->state = $state;
    }
}
