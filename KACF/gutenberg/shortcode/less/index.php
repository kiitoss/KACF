<?php

header("content-type:text/css");

require dirname(__FILE__).'/../../../../less/lessc.inc.php';

$less = new lessc;

echo $less->compileFile(dirname(__FILE__).'/style.less');