--TEST--
CLI -a and readline w/ print returns
--SKIPIF--
<?php 
include "skipif.inc"; 
if (!extension_loaded('readline') || readline_info('done') === NULL) {
	die ("skip need readline support");
}
?>
--FILE--
<?php
$php = getenv('TEST_PHP_EXECUTABLE');

// disallow console escape sequences that may break the output
putenv('TERM=VT100');

$codes = array();

$codes[1] = <<<EOT
print 1+2;
#cli.print_returns=1
print 1+2;
EOT;

foreach ($codes as $key => $code) {
	echo "\n--------------\nSnippet no. $key:\n--------------\n";
	$code = escapeshellarg($code);
	echo `echo $code | "$php" -a`, "\n";
}

echo "\nDone\n";
?>
--EXPECTF--
--------------
Snippet no. 1:
--------------
Interactive shell

php > print 1+2;
3php > #cli.print_returns=1
php > print 1+2;
3

Returned:
int(1)
php > 

Done
