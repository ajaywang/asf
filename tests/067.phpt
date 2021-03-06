--TEST--
Check for Application::task(), The module name is default
--SKIPIF--
<?php if (!extension_loaded("asf")) print "skip"; ?>
--INI--
asf.use_namespace=0
asf.ctype_id=0
--FILE--
<?php
define('ROOT_PATH', __DIR__);
require ROOT_PATH . "/build.inc";
start();

file_put_contents(APP_PATH_ADMIN . "/services/Main.php", <<<PHP
<?php
class MainService
{
    public function userAction()
    {
    }
}
PHP
);

file_put_contents(APP_PATH_ADMIN . "/logics/User.php", <<<PHP
<?php
class UserLogic
{
    public function test()
    {
    }
}
PHP
);

file_put_contents(APP_PATH . "/logics/Wrong.php", <<<PHP
<?php
class WrongLogic
{
    public function test()
    {
    }
}
PHP
);

$configs = array(
    'asf' => array(
        'root_path' => MODULE_PATH,
    )
);

$handle = new Asf_Application($configs);
var_dump($handle->task());

var_dump(Asf_Loader::get('MainService'));
var_dump(Asf_Loader::get('UserLogic'));

/* class 'WrongLogic' not found */
var_dump(Asf_Loader::get('WrongLogic'));

shutdown();

?>
--EXPECTF--
bool(true)
bool(false)
bool(false)
object(WrongLogic)#%d (%d) {
}

