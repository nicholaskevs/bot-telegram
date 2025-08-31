<?php

require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/config/cons.php';

use Longman\TelegramBot\TelegramLog;
use TelegramBot\Lib\Bot;

TelegramLog::initialize(Bot::createLogger('RunCommandsBot'));

if(!isset($commands) || !is_array($commands)) {
	TelegramLog::info('No command to be run');
	die;
}

try {
	$bot = Bot::initBot();
	$bot->runCommands($commands);
	
} catch(Exception $e) {
	TelegramLog::error($e->getMessage());
}
