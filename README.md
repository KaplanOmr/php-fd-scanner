# php-fd-scanner
PHP File/Directory Scanner

```php
require('fdscanner.class.php');
$fd = new FDScanner;
```

**Directory List**

```php
$fd->list();
```

**Read One File**

```php
$fd->oneReadFile();
```

**Read Many File**

```php
$fd->manyReadFile();
```

**Search File Name**

```php
$fd->searchFileName('file');
```

**Search File Name Extentions**

```php 
$fd->searchFileNameExtentions('txt');
```
