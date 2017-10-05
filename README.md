## Installation


#### Via Composer

Going your project directory on shell and run this command: 

```sh
$ composer require stereoflo/vesta-manage
```

Publication
```php
php artisan vendor:publish
```
Then select a needed option from list

Generate api key on a server

```bash
bash /usr/local/vesta/bin/v-generate-api-key
```
Or you can get existing keys

```sh
ls -l /usr/local/vesta/data/keys/
```

## Usage

	
Simple usage
```php
use VestaManage\Facades\Vesta;

$backups = Vesta::server('testVDS')->setUserName($userThatUWantToView)->listUserBackups();

