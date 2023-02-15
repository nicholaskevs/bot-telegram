<?php

require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/config/cons.php';

use Longman\TelegramBot\TelegramLog;
use TelegramBot\Lib\Bot;

TelegramLog::initialize(Bot::createLogger('RunCommandsBot'));

try {
	$bot = Bot::initBot();
	$bot->runCommands(['/test']);
	
} catch(Exception $e) {
	TelegramLog::error($e->getMessage());
}
