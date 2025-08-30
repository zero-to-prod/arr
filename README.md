# Zerotoprod\Arr

![](art/logo.png)

[![Repo](https://img.shields.io/badge/github-gray?logo=github)](https://github.com/zero-to-prod/arr)
[![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/zero-to-prod/arr/test.yml?label=test)](https://github.com/zero-to-prod/arr/actions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zero-to-prod/arr?color=blue)](https://packagist.org/packages/zero-to-prod/arr/stats)
[![php](https://img.shields.io/packagist/php-v/zero-to-prod/arr.svg?color=purple)](https://packagist.org/packages/zero-to-prod/arr/stats)
[![Packagist Version](https://img.shields.io/packagist/v/zero-to-prod/arr?color=f28d1a)](https://packagist.org/packages/zero-to-prod/arr)
[![License](https://img.shields.io/packagist/l/zero-to-prod/arr?color=pink)](https://github.com/zero-to-prod/arr/blob/main/LICENSE.md)
[![wakatime](https://wakatime.com/badge/github/zero-to-prod/arr.svg)](https://wakatime.com/badge/github/zero-to-prod/arr)
[![Hits-of-Code](https://hitsofcode.com/github/zero-to-prod/arr?branch=main)](https://hitsofcode.com/github/zero-to-prod/arr/view?branch=main)

## Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
    - [mapKeys()](#mapkeys)
    - [set()](#set)
- [Local Development](./LOCAL_DEVELOPMENT.md)
- [Contributing](#contributing)

## Introduction

Array helpers.

## Requirements

- PHP 7.1 or higher.

## Installation

Install `Zerotoprod\Arr` via [Composer](https://getcomposer.org/):

```bash
composer require zero-to-prod/arr
```

This will add the package to your project’s dependencies and create an autoloader entry for it.

## Documentation Publishing

You can publish this README to your local documentation directory.

This can be useful for providing documentation for AI agents.

This can be done using the included script:

```bash
# Publish to default location (./docs/zero-to-prod/arr)
vendor/bin/zero-to-prod-arr

# Publish to custom directory
vendor/bin/zero-to-prod-arr /path/to/your/docs
```

#### Automatic Documentation Publishing

You can automatically publish documentation by adding the following to your `composer.json`:

```json
{
  "scripts": {
    "post-install-cmd": [
      "zero-to-prod-arr"
    ],
    "post-update-cmd": [
      "zero-to-prod-arr"
    ]
  }
}
```

## Usage

### mapKeys()

Map keys of an array like this:

```php
$array = [
    'Key1' => [
        'Key2' => 1
    ]
];

$new_array = Arr::mapKeys($array, function (string $key) {
    return strtolower($key);
});

$key2 = $new_array['key1']['key2']);
```

### set()

Set values in arrays using dot notation, merge arrays, or use callbacks:

```php

// Set value with dot notation
$array = ['a' => ['b' => 1]];
$new_array = Arr::set($array, 'a.b', 2); // ['a' => ['b' => 2]]

// Merge arrays
$array1 = ['a' => 1];
$array2 = ['b' => 2];
$new_array = Arr::set($array1, $array2); // ['a' => 1, 'b' => 2]

// Use a callback
$array = ['a' => 1];
$new_array = Arr::set($array, function($array) {
    $array['b'] = 2;
    return $array;
}); // ['a' => 1, 'b' => 2]

// Empty string key does not modify the array
$array = ['a' => 1];
$new_array = Arr::set($array, ''); // ['a' => 1]
```

## Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check the [issues](https://github.com/zero-to-prod/arr/issues) page if you want to contribute.

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request.