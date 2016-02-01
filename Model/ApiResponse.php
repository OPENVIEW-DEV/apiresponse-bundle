<?php
namespace Openview\ApiResponseBundle\Model;

use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

/**
 * Response to an API call
 *
 * @author nicola.darold
 */
class ApiResponse {
    protected $data;
    
    
    
    
    public function __construct() {
        $this->data = array(
            'success'=>true,                        // boolean: response success
            'responseCode'=>Response::HTTP_OK,      // http response code
            'errors'=>array(),                      // errors array(code, message)
            'body'=>array(),                        // response body, as an array
        );
    }
    
    
    
    /**
     * Returns the success status of an API call
     * @return boolean
     */
    public function getSuccess() {
        return $this->data['success'];
    }
    /**
     * Return http code
     * @return integer
     */
    public function getResponseCode() {
        return $this->data['responseCode'];
    }
    /**
     * Return request errors array
     * @return array
     */
    public function getErrors() {
        return $this->data['errors'];
    }
    /**
     * Return request body
     * @return array
     */
    public function getBody() {
        return $this->data['body'];
    }
    
    
    /**
     * Set success status of an API call
     * @return \Openview\ApiResponseBundle\Model\ApiResponse
     */
    public function setSuccess($success) {
        $this->data['success'] = $success;
        return $this;
    }
    /**
     * Set http code
     * @return \Openview\ApiResponseBundle\Model\ApiResponse
     */
    public function setResponseCode($responseCode) {
        $this->data['responseCode'] = $responseCode;
        return $this;
    }
    /**
     * Set request errors array
     * @return \Openview\ApiResponseBundle\Model\ApiResponse
     */
    public function setErrors($errors) {
        $this->data['errors'] = $errors;
        return $this;
    }
    /**
     * Add an error message
     * 
     * @param error message $message
     * @param integer $code
     * @return \Openview\ApiResponseBundle\Model\ApiResponse
     */
    public function addError($message, $code=null)
    {
        $this->data['errors'][] = array(
            'message'=>$message,
            'code'=>$code
        );
        return $this;
    }
    /**
     * Set request body
     * @return \Openview\ApiResponseBundle\Model\ApiResponse
     */
    public function setBody($body) {
        $this->data['body'] = $body;
        return $this;
    }
    
    
    
    
    
    
    
    /**
     * Add a custom response property
     * 
     * @param string $propertyName
     * @param mixed $propertyValue
     * @return boolean True if success
     */
    public function addProperty($propertyName, $propertyValue)
    {
        if (is_string($propertyName)) {
            $this->data[$propertyName] = $propertyValue;
            
            return true;
        } else {
            
            return false;
        }
    }
    
    
    
    
    
    /**
     * Get normalized version of response
     * 
     * @return array
     */
    public function normalize()
    {
        return $this->data;
    }
    
    
    
    
    /**
     * Transforms entity to json string
     * 
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->data);
    }
    
    
    
    /**
     * Return the response based on an ApiResponse
     * 
     * @return Response
     */
    public function toResponse()
    {
        return new Response($this->toJson(), $this->data['responseCode']);
    }
    
    
    
    
    /**
     * Log current response
     * 
     * @param LoggerInterface $logger
     * @param string $prefix
     * @return boolean Success status
     */
    public function log(LoggerInterface $logger=null, $prefix='')
    {
        if ($logger instanceof LoggerInterface) {
            if (!$this->getSuccess()) {
                $logger->error($prefix . $this->toJson());
            } else {
                $logger->info($prefix . $this->toJson());
            }
            
            return true;
        } else {
            
            return false;
        }
    }


}
