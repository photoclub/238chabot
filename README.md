# 238chabot


## Contributing Guide
* Each command should be have it's own file under `commands` directory.
* Add the command on the top part of `FbBot.php` (our main entry point)
```php
<?php
require 'vendor/autoload.php';
include 'commands/recipe.php';
// insert here
```
* To debug `sendMessage`, take a look at `test.json` if there are any.