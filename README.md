# Laravel Package to Implement Search Bars on Your Application 

A package for Laravel to add a search bar feature to your application.  Easily add search capabilities on your Eloquent models by adding a search bar component to your application.

[![Latest Unstable Version](http://poser.pugx.org/dalyio/laravel-search/v/unstable)](https://packagist.org/packages/dalyio/laravel-search)
[![PHP Version Require](http://poser.pugx.org/dalyio/laravel-search/require/php)](https://packagist.org/packages/dalyio/laravel-search)
[![License](https://poser.pugx.org/dalyio/laravel-search/license)](https://packagist.org/packages/dalyio/laravel-search)

## Installation

``` bash
composer require dalyio/laravel-search
```

``` bash
php artisan vendor:publish --provider="Dalyio\Search\Providers\SearchServiceProvider"
```

## Configuration

Edit the new `search.php` configuration file in the config directory to configure your application's search bars.  You may configure multiple search bars on a single application.  The order in which the Eloquent models are provided will be a factor in determining the order of the search results.

```php
return [
    // Default search namespace
    'default' => [
        'models' => [
            // Your searchable models
            App\Models\{YOUR SEARCHABLE MODEL}::class,
        ]
    ],
    
    // Choose any namespace you want to configure multiple searchbars
    // Namespaces of searchbars are assigned on the component tag
    'additional_namespace' => [
        'models' => [
            App\Models\{YOUR SEARCHABLE MODEL}::class,
        ]
    ],
]
```

## Usage

### Search Bar Component

Insert the blade search bar component into your view.  The namespace corresponds to the namespace you set in the configuration file.  These parameters are all optional.

``` phtml
<x-search-bar namespace="default" debounce="700" limit="10" />
```

### Searchable Eloquent Models

Specify which attributes to apply searches to on the Eloquent models by adding a *$searchable* property.  Omitting this property will cause all fields of the Eloquent model to be searched upon.

```php
    protected $searchable = [
        'first_name', 'last_name'
    ];
```

Add the *toSearch()* method to an Eloquent mode to properly format the search results and set the link url.  Omitting this method will cause the format of the results to not work properly.

```php
    public function toSearch()
    {
        return array_merge(parent::toArray(), [
            'search_header_format' => '<span>NFL Player</span>',
            'search_result_format' => '<span>'.$this->firstName().' '.$this->lastName().'</span> <span>('.$this->position().')</span>',
            'search_url' => 'https://www.pro-football-reference.com/players/'.strtoupper(substr($this->lastName(), 0, 1)).'/'.$this->frKey().'.htm',
        ]);
    }
```

### Styling

The search package comes with default styling to match Laravel's out-of-box welcome page.  To implement custom styling rules you can set the default styling to *false* on the blade component and implement custom rules.

``` phtml
<x-search-bar namespace="default" debounce="700" limit="10" useCss="false" />
```

Add the following rules and customizations to your application's main css files.

``` css
#search-bar-component {
    position: relative;
}
#search-bar-component input#search-bar {
    display: block;
    position: absolute;
    right: 0;
    cursor: text;
    height: 2rem;
    color: #4e6e8e;
    border: 1px solid #cfd4db;
    border-radius: 2rem;
    font-size: .9rem;
    line-height: 2rem;
    padding: 0 1rem;
    outline: 0;
    background-size: auto;
    background-size: 1rem;
    transition: all .2s ease;
}
#search-bar-component #dropdown-menu {
    display: none;
    position: absolute;
    top: 2rem;
    right: 0;
    border-radius: 1rem;
    text-align: left;
    min-width: 400px;
    background: #fff;
    border: 1px solid #cfd4db;
    transition: all .2s ease;
}
#search-bar-component #dropdown-menu .result-link {
    display: block;
    padding: .750rem 1rem;
    font-size: .875rem;
    
}
#search-bar-component #dropdown-menu .result-link:hover,
#search-bar-component #dropdown-menu .result-link:active {
    background-color: #f1f2f4;
}
#search-bar-component #dropdown-menu .result-header,
#search-bar-component #dropdown-menu .result-empty {
    padding: 1rem;
    width: 100%;
}
#search-bar-component #dropdown-menu .result-header {
    border-bottom: 1px solid #cfd4db;
}
```

## License

Laravel Search is open-sourced software licensed under the [MIT license](LICENSE).
