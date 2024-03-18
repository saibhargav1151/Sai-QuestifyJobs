<?php
namespace App\Controllers;
use Framework\Database;

class HomeController{

protected $db;

    public function __construct(){
            $config=require basePath('config/db.php');
            $this->db=new Database($config);    
    }

    public function index(){
        //die('HomeController@index');
        $listings=$this->db->query('select * from listings limit 6')->fetchAll();
// inspect($listings);

loadView('home',['listings'=> $listings]);
    }
    
}
?>