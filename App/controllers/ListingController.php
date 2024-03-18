<?php
namespace App\Controllers;
use Framework\Database;
use Framework\Validation;

class ListingController{

    protected $db;
    
        public function __construct(){
                $config=require basePath('config/db.php');
                $this->db=new Database($config);    
        }
    
        public function index(){
            //die('HomeController@index');
            $listings=$this->db->query('select * from listings')->fetchAll();
    // inspect($listings);
    
    loadView('listings/index',['listings'=> $listings]);
        }
        public function create(){
            loadView('listings/create');
        }

        public function show($parmas){
            $id=$parmas['id'] ?? '';

            // $parmas=[
            //     'id'=>$id
            // ];


            $listings=$this->db->query("select * from listings where id=:id",$parmas)->fetch();

            if(!$listings){
                ErrorController::notFound('Listing Not Found');
                return;
            }

            loadView('listings/show',['listings'=> $listings]);

        }
        public function store(){
            $allowedFileds=['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];
            $newListingData=array_intersect_key($_POST,array_flip($allowedFileds));

            $newListingData['user_id']=1;
            $newListingData= array_map('sanatizeData', $newListingData);
            $requiredFilelds=['title', 'description', 'email','city','salary', 'state'];
            $errors=[];
            foreach($requiredFilelds as $fileds){
                if(empty($newListingData[$fileds]) || !Validation::string($newListingData[$fileds])){
                    $errors[$fileds]=ucfirst($fileds). ' is required!';
                }
            }
            if(!empty($errors)){
                loadView('listings/create',['errors'=>$errors,'listing'=>$newListingData]);
            }else {
               //Submit data
            //    $this->db->query('INSERT INTO QuestifyJobs.listings ( title, description, salary, tags, company, address, city, state, phone, email, requirements, benefits, user_id)
            //    VALUES(:title, :description, :salary, :tags, :company, :address, :city, :state, :phone, :email, :requirements, :benefits, :user_id)',$newListingData);

            $fileds=[];
            foreach($newListingData as $field=>$value){
            $fileds[]= $field;
            }

            $values=[];
            foreach($newListingData as $field=>$value){
            $values[]= ':'.$field;
            }

            $fileds=implode(', ',$fileds);
            $values=implode(', ',$values);

            $query="INSERT INTO QuestifyJobs.listings ({$fileds}) values({$values})";
            $this->db->query($query, $newListingData);

            header('Location: /listings');
            exit;
            }

        }
        public function destroy($params=[]){
            $id=$params['id'] ;
            $params=[
                    'id'=>$id
                ];
                $listing=$this->db->query('SELECT * from listings where id=:id ',$params)->fetch();
                if(!$listing){
                    ErrorController::notFound('LIsting not Found');
                    return;
                }
                $this->db->query("DELETE from listings where id=:id",$params);
                //set flash message;
                $_SESSION['success_message']="Listing deleted Successfully";
                redirect('/listings');
        }

        public function edit($parmas){
            $id=$parmas['id'] ?? '';

            $parmas=[
                'id'=>$id
            ];


            $listings=$this->db->query("select * from listings where id=:id",$parmas)->fetch();

            if(!$listings){
                ErrorController::notFound('Listing Not Found');
                return;
            }

            loadView('listings/edit',['listings'=> $listings]);

        }

    }
    

?>