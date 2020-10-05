<?php 
include_once  'Game.php';
include_once 'GameInterface.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class Play extends Game {

    public function __construct()
    {
        $this->start();
    }
    public function playgame()
    {
        $status = $this->checkAliveStatus();

        if($status) {

            $getFarmerCount=$this->getFarmDetails(SELF::FARMER_TYPE);
            $getCowsCount=$this->getFarmDetails(SELF::COWS_TYPE);
            $getBunniesCount=$this->getFarmDetails(SELF::BUNNIES_TYPE);

            $farmerCount=$getFarmerCount['total'];
            $cowsCount=$getCowsCount['total'];
            $bunniesCount=$getBunniesCount['total'];
            if($farmerCount>0 && $cowsCount>0 && $bunniesCount>0)
            {
                $this->message('Farmer : '.$farmerCount);
                $this->message('Cows : '.$cowsCount);
                $this->message('Bunnies : '.$bunniesCount);
                $this->message('You Won the Game');
            }
            else
            {
                $this->message('Farmer : '.$farmerCount);
                $this->message('Cows : '.$cowsCount);
                $this->message('Bunnies : '.$bunniesCount);
                $this->message('You Loss the Game'); 
            }
            $this->deleteFile(SELF::FARMER_TYPE);
            $this->deleteFile(SELF::COWS_TYPE);
            $this->deleteFile(SELF::BUNNIES_TYPE);

            
            return json_encode($this->getMessages());
        }
        else {
            $result=array();
            $getFarmerCount=$this->getFarmDetails(SELF::FARMER_TYPE);
            $getCowsCount=$this->getFarmDetails(SELF::COWS_TYPE);
            $getBunniesCount=$this->getFarmDetails(SELF::BUNNIES_TYPE);
            $this->setGameState(SELF::STATE_GAMEOVER);

            $result['type']=$this->game();
            $result['count']=$getFarmerCount['total_turn'];
            $result['feed_farmer']=$getFarmerCount['total_feed_count'];
            $result['feed_cows']=$getCowsCount['total_feed_count'];
            $result['feed_bunnies']=$getBunniesCount['total_feed_count'];
            $result['remain_farmer']=$getFarmerCount['total'];
            $result['remain_cows']=$getCowsCount['total'];
            $result['remain_bunnies']=$getBunniesCount['total'];

            return json_encode($result);

        }
    }
    public function checkAliveStatus(){
        $count = 0;
        $farmer_data =  $this->getFarmDetails('Farmer');
        if($farmer_data['total_turn'] > SELF::TURN){
            return true;
        }
        else {
            return false;
        }
    }
    public function game() 
    {
        $getFarmerCount=$this->getFarmDetails(SELF::FARMER_TYPE);
        $getCowsCount=$this->getFarmDetails(SELF::COWS_TYPE);
        $getBunniesCount=$this->getFarmDetails(SELF::BUNNIES_TYPE);

        $count=$getFarmerCount['total_turn']++;

        if($count<=SELF::TURN) {
            $functions = array(SELF::FARMER_TYPE,SELF::COWS_TYPE,SELF::BUNNIES_TYPE);
            if($getFarmerCount['total']<=0) {
                $functions = array(SELF::COWS_TYPE,SELF::BUNNIES_TYPE);
            }
            if($getCowsCount['total']<=0) {
                $functions = array(SELF::FARMER_TYPE,SELF::BUNNIES_TYPE);
            }
            if($getBunniesCount['total']<=0) {
                $functions = array(SELF::FARMER_TYPE,SELF::COWS_TYPE);
            }
            shuffle($functions);
            $this->finalCount($functions[0],$count);
            return $functions[0];
        }
    }
    public function finalCount($type,$count)
    {
        if($type==SELF::FARMER_TYPE)
        {
            $getFarmerCount=$this->getFarmDetails(SELF::FARMER_TYPE);
            if($getFarmerCount['total']>0) {
            $arr_write=array(
                    'name'=>SELF::FARMER_TYPE,
                    'feed_turn'=>$getFarmerCount['feed_turn'],
                    'total'=>$getFarmerCount['total'],
                    'total_turn'=>$getFarmerCount['total_turn']+1,
                    'count'=>0,
                    'total_feed_count'=>$getFarmerCount['total_feed_count']+1,
                );
            $this->writeInFile($arr_write);
            }
        }
        else
        {
            $getFarmerCount=$this->getFarmDetails(SELF::FARMER_TYPE);

            $count=$getFarmerCount['count']+1;
            $total=$getFarmerCount['total'];
            if($count>$getFarmerCount['feed_turn']) {
                $total=$total-1;
                if($total>0)
                {
                    $count=0; 
                }
                else
                {
                    $total=0;
                }
            }
            $arr_write=array(
                'name'=>SELF::FARMER_TYPE,
                'feed_turn'=>$getFarmerCount['feed_turn'],
                'total'=>$total,
                'total_turn'=>$getFarmerCount['total_turn']+1,
                'count'=>$getFarmerCount['count']+1,
                'total_feed_count'=>$getFarmerCount['total_feed_count'],

            );
            $this->writeInFile($arr_write);
        }

        if($type==SELF::COWS_TYPE) {
            $getCowsCount=$this->getFarmDetails(SELF::COWS_TYPE);
            if($getCowsCount['total']>0) {
                $arr_write=array(
                    'name'=>SELF::COWS_TYPE,
                    'feed_turn'=>$getCowsCount['feed_turn'],
                    'total'=>$getCowsCount['total'],
                    'total_turn'=>$getCowsCount['total_turn']+1,
                    'count'=>0,
                    'total_feed_count'=>$getCowsCount['total_feed_count']+1,
                );
                $this->writeInFile($arr_write);
            }
        }
        else {
            $getCowsCount=$this->getFarmDetails(SELF::COWS_TYPE);
            $count=$getCowsCount['count']+1;
            $total=$getCowsCount['total'];
            if($count>$getCowsCount['feed_turn']) {
                $total=$total-1;
                if($total>0)
                {
                    $count=0; 
                }
                else
                {
                    $total=0;
                }
            }
            $arr_write=array(
                'name'=>SELF::COWS_TYPE,
                'feed_turn'=>$getCowsCount['feed_turn'],
                'total'=>$total,
                'total_turn'=>$getCowsCount['total_turn']+1,
                'count'=>$getCowsCount['count']+1,
                'total_feed_count'=>$getCowsCount['total_feed_count'],

            );
            $this->writeInFile($arr_write);
        }

        if($type==SELF::BUNNIES_TYPE) {
            $getBunniesCount=$this->getFarmDetails(SELF::BUNNIES_TYPE);
            if($getBunniesCount['total']>0) {
                $arr_write=array(
                    'name'=>SELF::BUNNIES_TYPE,
                    'feed_turn'=>$getBunniesCount['feed_turn'],
                    'total'=>$getBunniesCount['total'],
                    'total_turn'=>$getBunniesCount['total_turn']+1,
                    'count'=>0,
                    'total_feed_count'=>$getBunniesCount['total_feed_count']+1,
                );
                $this->writeInFile($arr_write);            
            }
        }
        else {
            $getBunniesCount=$this->getFarmDetails(SELF::BUNNIES_TYPE);
            $count=$getBunniesCount['count']+1;
            $total=$getBunniesCount['total'];
            if($count>$getBunniesCount['feed_turn']) {
                $total=$total-1;
                if($total>0)
                {
                    $count=0; 
                }
                else
                {
                    $total=0;
                }
            }
            
            $arr_write=array(
                'name'=>SELF::BUNNIES_TYPE,
                'feed_turn'=>$getBunniesCount['feed_turn'],
                'total'=>$total,
                'total_turn'=>$getBunniesCount['total_turn']+1,
                'count'=>$getBunniesCount['count']+1,
                'total_feed_count'=>$getBunniesCount['total_feed_count'],
            );
            $this->writeInFile($arr_write);        
        }
        
    }   
}


