## Installation


#### Via Composer

Going your project directory on shell and run this command: 

```sh
$ composer require stereoflo/VestaManage
```

Publication
```php
php artisan vendor:publish -all
```

Generate api key

```bash
bash /usr/local/vesta/bin/v-generate-api-key
```
Or you can view existing keys

```sh
ls -l /usr/local/vesta/data/keys/
```

## Usage

	
Simple usage
```php
use VestaManage\Facades\Vesta;

$backups = Vesta::server('testVDS')->setUserName('MyUserName')->listUserBackups($userThatUWantView);

