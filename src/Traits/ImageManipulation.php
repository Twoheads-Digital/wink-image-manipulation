<?php

namespace WinkImageManipulation\Traits;

use Exception;
use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Cache;

trait ImageManipulation
{

    /**
     * @var Server
     */
    protected $server;

    /**
     * @response void
     */
    public function server()
    {
        return ServerFactory::create([
            'response' 				=> new LaravelResponseFactory(app('request')),
            'source' 				=> Storage::getDriver(),
            'cache' 				=> Storage::getDriver(),
            'source_path_prefix' 	=> 'public/wink/images',
            'cache_path_prefix' 	=> 'images/.cache'
        ]);
    }

    /**
     * @return string
     */
    protected function placeholderImage(): string
    {
        return 'https://placehold.it/%sx%s';
    }

    /**
     * @param array $params
     * @return StreamedResponse
     */
    protected function response($params = []): StreamedResponse
    {
        return $this->server()->getImageResponse(
            $this->getFeaturedImageBaseName(), $params
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
        $class = get_class($this);
        $UMID = sha1($class);

        Cache::rememberForever($UMID, function() use($class) {
            return $class;
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
            return sprintf($this->placeholderImage(), $this->images[$name]['w'], $this->images[$name]['h']);
        }
        return route('wink-image', [$this, $this->UMID(), $name]);
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
