# A nice API to write CSV files.

This is just a very light weight package to write to a csv file, it's basically a wrapper around `fputcsv`.
It also handles the file's creation, opening and closing.

## Installation

You can install the package via composer:

```bash
composer require yazanstash/csv
```

## Usage

``` php
$file = Csv\Csv::create();

$file->delimiter('|')->enclosure("'")->write(['Hola Amigo!']);
```

You can choose between providing a file for the package or letting it generate one, by default the generated file is located at `/tmp/{random-file-name}.csv`.
**Caution:** If the file already exists, the package will overwrite it.

#### Customizing the write parameters

To customize the parameters of writing, you have 3 dynamic methods available for your disposal, `delimiter()`, `enclosure()` and `escapeCharacter()`. Passing an argument will change the value, and calling the method without it will give you the current value of it. In the case of overwriting the value, it will you give you back the object to allow chainability.

#### Writing to file

Use the `write()` method to write new lines to the file, the method expects an array of values to be written, representing one line for each call.

#### Getting the file back

To get the written file path back, just call `filePath()` on the instance.

#### Manually closing the file

If you need to close the file manually for some reason (the package automatically does that upon destructing the instance), you have `closeFile()` at your disposal.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Yazan Stash](https://github.com/Yazan-Stash)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
