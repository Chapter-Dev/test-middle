<?php
namespace App\Services;

class UserService extends DatabaseService
{
    protected $fillable = [
        'first_name','last_name','dob','gender', 'email'
    ];

    protected $values = [];

    /**
     * Update a user request 
     * 
     * @author Apoorv Vyas
     */
    function update(){

    }

    /**
     * Create a user request 
     * 
     * @author Apoorv Vyas
     */
    function create(){

    }

    /**
     * Set User data
     * 
     * @author Apoorv Vyas
     */
    function __set($name,$value){
        if(in_array($name,$this->fillable) && !empty($value)){
            $this->values[$name] = $value;
        }
    }

    /**
     * Get data response 
     * 
     * @author Apoorv Vyas
     */
    function response(){
        $data = parent::response();
    }
}