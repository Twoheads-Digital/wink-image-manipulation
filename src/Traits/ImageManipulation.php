<?php

namespace WinkImageManipulation\Traits;

use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Cache;

trait ImageManipulation
{

    /**
     * @var Filesystem
     */
    protected $system;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @response void
     */
    public function setup()
    {
        $this->system = app('filesystem');
        $this->server = ServerFactory::create([
            'response' 				=> new LaravelResponseFactory(app('request')),
            'source' 				=> Storage::getDriver(),
            'cache' 				=> Storage::getDriver(),
            'source_path_prefix' 	=> 'images',
            'cache_path_prefix' 	=> 'images/.cache'
        ]);
    }

    /**
     * @param array $params
     * @return StreamedResponse
     */
    protected function response($params = []): StreamedResponse
    {
        return $this->server->getImageResponse(
            '../public/wink/images/'.$this->getFeaturedImageBaseName(), $params
        );
    }

    /**
     * @param $method
     * @return StreamedResponse
     */
    public function imageResponse($method): StreamedResponse
    {
        return $this->response(
            $params = $this->images[$method]
        );
    }

    /**
     * @return string
     */
    protected function getFeaturedImageBaseName()
    {
        return basename($this->featured_image);
    }

    /**
     * @return string
     */
    public function UMID(): string
    {
        $UMID = sha1(get_class($this));

        Cache::rememberForever($UMID, function() use($UMID) {
            return $UMID;
        });

        return $UMID;
    }

    /**
     * @param $name
     * @return string
     */
    protected function imageRoute($name): string
    {
        if(!$this->getFeaturedImageBaseName()) {
            return sprintf('https://placehold.it/%sx%s', $this->images[$name]['w'], $this->images[$name]['h']);
        }
        return route('image', [$this, $this->UMID(), $name]);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed|string
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        if(preg_match('/^wink[A-Z][\w\d]+Image$/', $name)) {
            if(isset($this->images[$name])) {
                return $this->imageRoute($name);
            }
            throw new Exception("Please define \$images[\"{$name}\"] parameters on your ". get_class($this) ." model.");
        }
        return parent::__call($name, $arguments);
    }

}