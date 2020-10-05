<?php
include_once 'GameInterface.php';

class Game implements GameInterface {

    protected $messages = [];

    protected $state;

    public function __construct() 
    {
        $this->start();
    }
    //This function is for initializing the types
    public function start()
    {
        $this->add('Farmer',15,1,1,0);
        $this->add('Cows',10,2,1,0);
        $this->add('Bunnies',8,4,1,0);
        $this->setGameState(SELF::STATE_PLAYING);
    }
    
    //This function get the total farming count
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
    //This functiono is for creating the files for farmer,cows and bunnies
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
    //This function is for writing counts in files
    public function writeInFile($arr_write) 
    {        
        $fp = fopen('files/'.$arr_write['name'].'.json', 'w');
        fwrite($fp, json_encode($arr_write));
        fclose($fp); 
    }
    //this function is for unlink the file once turn reach to 50
    public function deleteFile($type)
    {
        if(unlink("files/".$type.".json")) {
            return true;
        }
        else{
            return false;
        }
    }
    //This function is get the gamestate
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
