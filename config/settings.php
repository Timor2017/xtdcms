<?php
$env = (!empty($_SERVER['ENV']))? $_SERVER['ENV']: 'dev';
return require_once('settings.'.$env.'.php');