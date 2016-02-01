# ApiResponseBundle

Standardized response to API requests



## Installation
Install with composer
```bash
composer require openview/apiresponse-bundle
```

Activate the bundle in AppKernel.php
```php
#AppKernel.php
public function registerBundles()
{
    $bundles = array(
        new Openview\LoggerBundle\OpenviewLoggerBundle(),
    );
```


## Usage
Example in a Controller:
```php
// MyController.php
use Openview\ApiResponseBundle\Model\ApiResponse;

public function newAction(Request $request)
{
    $r = new ApiResponse();
    // some operations
    if ($succeeded) {
        $r->setBody(array('id'=>$document->getId()));
        $r->setSuccess(true);
        $r->setResponseCode(Response::HTTP_OK);
    } else {
        $r->setSuccess(false);
        $r->setResponseCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        $r->addError('myapp.err.unabletocreate');
        // log request
        
    }
    // you can log your request, if you wish
    $r->log($this->get('logger'));

    return $r->toResponse();
    // you may also return a Symfony response:
    // return new Response($r->toJson(), $r->getResponseCode());
}
```