<?php
namespace App\Services;

use Illuminate\Support\Collection;

class UserService extends DatabaseService
{
    protected $fillable = [
        'first_name','last_name','dob','gender', 'email'
    ];

    protected $values = [];

    /**
     * Update a user request 
     *
     * @param string $uuid
     *  
     * @author Apoorv Vyas
     */
    function update($uuid){
        $this->request_url = $this->base_url.'user/'.$uuid.'/update';
        unset($this->values['email']);
        try{
            $this->post($this->values);
        }
        catch(Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * Create a user request 
     * 
     * @author Apoorv Vyas
     */
    function create(){
        $this->request_url = $this->base_url.'user/create';
        try{
            $this->post($this->values);
        }
        catch(Exception $e){
            dd($e->getMessage());
        }
        
    }

    /**
     * Get the User Details
     * 
     * @param string $uuid
     * 
     * @author Apoorv Vyas
     */
    function details($uuid){
        $this->request_url = $this->base_url.'user/'.$uuid;
        $this->get($this->values);
    }

    /**
     * Set User data
     * 
     * @param string $name
     * @param string $value
     * 
     * @author Apoorv Vyas
     */
    function __set($name,$value){
        if(in_array($name,$this->fillable) && !empty($value)){
            $this->values[$name] = $value;
        }
    }

    /**
     * Set Multiple data
     * 
     * @param string $data
     * 
     * @author Apoorv Vyas
     */
    function put(Collection $data){
        $self = $this;
        $data->each(function($value,$key) use(&$self){
            $self->__set($key,$value);
        });

        return $self;
    }
}