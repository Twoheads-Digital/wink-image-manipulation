# Wink Image Manipulation

This package is aimed to provide simple support for image manipulation for [Mohamed Said's](https://twitter.com/themsaid) [Wink](https://github.com/writingink/) publishing package.

## Install
```
composer require twoheads-digital/wink-image-manipulation
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
{{-- https://example.test/image/aefba831-12f7-4b58-9b62-c1e5c6f97994/winkListingImage --}}
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

