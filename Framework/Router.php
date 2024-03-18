<?php
namespace Framework;
use App\Controllers\ErrorController;
//use App\Controllers\ErrorController;

class Router{

    protected $routes=[];

    public function method($method,$uri,$action){
        list($controller,$controllerMethod)=explode('@',$action);

        $this->routes[]=[
            'method'=>$method,
            'uri'=>$uri,
            'controller'=>$controller,
            'controllerMethod'=>$controllerMethod
        ];
    }
    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     *  @return void
     */
    public function get($uri,$controller){
        $this->method('GET',$uri,$controller);
    }

     /**
     * Add a post route
     * 
     * @param string $uri
     * @param string $controller
     *  @return void
     */
    public function post($uri,$controller){
        $this->method('POST',$uri,$controller);

    }

     /**
     * Add a put route
     * 
     * @param string $uri
     * @param string $controller
     *  @return void
     */
    public function put($uri,$controller){
        $this->method('PUT',$uri,$controller);

    }

     /**
     * Add a delete route
     * 
     * @param string $uri
     * @param string $controller
     *  @return void
     */
    public function delete($uri,$controller){
        $this->method('DELETE',$uri,$controller);

    }

   

    public function route($uri){

$requestMethod=$_SERVER['REQUEST_METHOD'];
//check for method input
if($requestMethod==='POST' && isset($_POST['_method']))
    {
    //override req method
    $requestMethod=strtoupper($_POST['_method']);}
    
        foreach($this->routes as $route){
            // if($route['uri']===$uri && $route['method']===$method){
            //     //require basePath('App/'.$route['controller']);

            //     $controller='App\\Controllers\\'.$route['controller'];
            //     $controllerMethod=$route['controllerMethod'];
            //     $controllerInstance=new $controller();
            //     $controllerInstance->$controllerMethod();
            //     return;
                

            // }
            $uriSegments=explode('/', trim($uri,'/'));
            $routeSegments=explode('/', trim($route['uri'],'/'));
                // var_dump($routeSegments);
            $match=true;
            
            if(count($uriSegments)=== count($routeSegments) && strtoupper($route['method'])=== $requestMethod){
            $params=[];

            $match=true;
            for($i=0;$i<count($uriSegments);$i++){
                if($routeSegments[$i]!==$uriSegments[$i] && !preg_match('/\{(.+?)\}/',$routeSegments[$i])){
                    $match=false;
                    break;


                }
                if(preg_match('/\{(.+?)\}/',$routeSegments[$i],$matches)){
                    $params[$matches[1]]=$uriSegments[$i];
                    // inspect($params);
                }


            }
            if($match){
                $controller='App\\Controllers\\'.$route['controller'];
                    $controllerMethod=$route['controllerMethod'];
                    $controllerInstance=new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
            }

            }

    
        }
        ErrorController::notFound();
    }

}
?>