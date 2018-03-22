<?php

$cwd = getcwd();
chdir(__DIR__ . '/../');
$ts = rtrim(shell_exec('git log -n1 --pretty=%ct HEAD'));
if (!is_numeric($ts)) {
    echo 'Could not detect date using "git log -n1 --pretty=%ct HEAD"' . PHP_EOL;
    exit(1);
}
// Install with the current version to force it having the right ClassLoader version
// Install without dev packages to clean up the included classmap from phpunit classes
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    shell_exec('composer config autoloader-suffix --unset');
    shell_exec('composer install -q');
}
chdir($cwd);
if (isset($_SERVER['argv'][1])) {
    $version = $_SERVER['argv'][1];
} else {
    $version = trim(shell_exec('git log --pretty="%H" -n1 HEAD'));
}
file_put_contents('version.php', "<?php return '{$version}';");

echo "Compile version: {$version}" . PHP_EOL;

require __DIR__ . '/../vendor/autoload.php';

use KonstantinKuklin\StreamDefenseBot\Compiler;

error_reporting(-1);
ini_set('display_errors', 1);

// one more hack
$filePathToHack = 'vendor/composer/composer/src/Composer/Installer/LibraryInstaller.php';
$bufferedFile = file_get_contents($filePathToHack);
$newFileContent = str_replace('$this->vendorDir = realpath($this->vendorDir);', '', $bufferedFile);
file_put_contents($filePathToHack, $newFileContent);

try {
    $compiler = new Compiler();
    $compiler->compile();
} catch (\Exception $e) {
    echo 'Failed to compile phar: [' . get_class($e) . '] ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    exit(1);
} finally {
    @unlink('version.php');
    file_put_contents($filePathToHack, $bufferedFile);
}
