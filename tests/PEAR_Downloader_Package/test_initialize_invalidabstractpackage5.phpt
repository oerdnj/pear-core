--TEST--
PEAR_Downloader_Package->initialize() with unknown channel
--SKIPIF--
<?php
if (!getenv('PHP_PEAR_RUNTESTS')) {
    echo 'skip';
}
?>
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$dp = &newDownloaderPackage(array());
$phpunit->assertNoErrors('after create');
$result = $dp->initialize('foo/test');
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'invalid package name/package file "foo/test"'),
    array('package' => 'PEAR_Error', 'message' =>
    'invalid package name/package file "foo/test"')),
    'after initialize');
$phpunit->assertEquals(array (
  0 => 
  array (
    0 => 0,
    1 => 'unknown channel "foo" in "foo/test"',
  ),
  array (
    0 => 3,
    1 => '+ tmp dir created at ' . $dp->_downloader->getDownloadDir(),
  ),
), $fakelog->getLog(), 'log messages');
$phpunit->assertEquals(array (), $fakelog->getDownload(), 'download callback messages');
$phpunit->assertIsa('PEAR_Error', $result, 'after initialize');
$phpunit->assertNull($dp->getPackageFile(), 'downloadable test');
echo 'tests done';
?>
--EXPECT--
tests done