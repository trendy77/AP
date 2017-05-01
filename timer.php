<?php

// basic php timer usage...

PHP_Timer::start();

// ...

$time = PHP_Timer::stop();

var_dump($time);

print PHP_Timer::secondsToTimeString($time);

// also.... 

print PHP_Timer::resourceUsage();