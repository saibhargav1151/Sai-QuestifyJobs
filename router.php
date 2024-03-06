<?php
class Router{

    protected $routes=[];

    public function method($method,$uri,$controller){
        $this->routes[]=[
            'method'=>$method,
            'uri'=>$uri,
            'controller'=>$controller
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

    public function error($httpCode=404){
        http_response_code($httpCode);
        loadView("error/$httpCode");
        exit;
    }

    public function route($uri,$method){
        foreach($this->routes as $route){
            if($route['uri']===$uri && $route['method']===$method){
                require basePath($route['controller']);
                return;
            }
        }
        $this->error();
    }

}
?>