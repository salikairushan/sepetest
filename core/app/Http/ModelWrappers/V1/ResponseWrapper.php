<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6/9/2016
 * Time: 6:15 PM
 */

namespace App\Http\ModelWrappers\V1;
use Illuminate\Http\Response;

class ResponseWrapper
{
    private $response = null;
    function __construct()
    {
        $this->response = new Response();
        $this->response->code = 200;
        $this->response->data = null;
        $this->response->description = "";
    }
    public function setCode($code = 200){
        $this->response->code = $code;
    }
    public function setData($data = null){
        $this->response->data = $data;
    }
    public function setDescription($description){
        $this->response->description = $description;
    }
    public function getResponse(){
        return $this->response;
    }
}