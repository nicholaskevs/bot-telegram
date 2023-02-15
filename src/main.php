<?php

require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/config/cons.php';

use Longman\TelegramBot\TelegramLog;
use TelegramBot\Lib\Bot;

TelegramLog::initialize(Bot::createLogger('GetUpdatesBot'));

try {
	$bot = Bot::initBot();
	
	$response = $bot->handleGetUpdates();
	
	if($response->isOk()) {
		TelegramLog::info('Processed '.count($response->getResult()).' updates');
	} else {
		TelegramLog::error('Failed to fetch updates');
		TelegramLog::error($response->printError());
	}
	
} catch(Exception $e) {
	TelegramLog::error($e->getMessage());
}
