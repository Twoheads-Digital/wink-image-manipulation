# Wink Image Manipulation

This package is aimed to provide simple support for image manipulation for [Mohamed Said's](https://twitter.com/themsaid) [Wink](https://github.com/writingink/) publishing package.

Under the hood it uses [PHP League's Glide API](https://glide.thephpleague.com/1.0/api/quick-reference/) which you can pass all parameters through to.

## Install
```
composer require twoheads-digital/wink-image-manipulation:^v0.0.1
```

## Apply to custom model

Create a new model to extend the default WinkPost model.


```php
<?php

namespace App;

use Wink\WinkPost;
use WinkImageManipulation\Traits\ImageManimulation;

class BlogPost extends WinkPost
{

    use ImageManipulation;

    /**
     * @var array
     */
    protected $images = [
        'winkListingImage' => [
            'w' => 400,
            'h' => 300,
            'fit' => 'crop'
        ],
        'winkHeaderImage' => [
            'w' => 1680,
            'h' => 916,
            'fit' => 'crop'
        ]
    ];

}
```

Define all your images parameters in the `$images` property. Please make sure all named definitions begin with `wink` and end with `Image`.

You can then use definitions as model methods in your views;

```blade
<img src="{{ $post->winkListingImage() }}" />
{{-- https://example.test/image/750e57d1-288d-4b3e-9bf2-ae6b5a397e59/9bd8353c2ead08643d7676681b51c3c3b247936f/winkListingImage --}}
```

## No Featured Image

By default, if no featured image is attached to the Wink Post then a placeholder provided by placehold.it is used. You can override this if required by defining a `placeholderImage` method on your model.

```php
<?php

namespace App;

use Wink\WinkPost;
use WinkImageManipulation\Traits\ImageManimulation;

class BlogPost extends WinkPost
{

    use ImageManipulation;

    ...

    /**
     * @return string
     */
    protected function placeholderImage(): string
    {
        return 'https://placeimg.com/%s/%s/any';
    }

}
```

### MIT License
    
    Copyright (c) 2020 Two Heads Digital
    
    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:
    
    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.
    
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.

