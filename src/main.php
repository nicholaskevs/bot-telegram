<?php

require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/config/cons.php';

use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use TelegramBot\Lib\Bot;

TelegramLog::initialize(Bot::createLogger());

try {
	$bot = new Telegram(BOT_TOKEN, BOT_USERNAME);
	
	$bot->enableMySql([
		'host'		=> DB_HOST,
		'user'		=> DB_USERNAME,
		'password'	=> DB_PASSWORD,
		'database'	=> DB_DBNAME,
	]);
	
	$bot->addCommandsPath(dirname(__DIR__).'/src/Command');
	
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
