<?php

require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/config/cons.php';

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use TelegramBot\Lib\Bot;

try {
	$bot = new Telegram(BOT_TOKEN, BOT_USERNAME);
	
	$bot->enableMySql([
		'host'		=> DB_HOST,
		'user'		=> DB_USERNAME,
		'password'	=> DB_PASSWORD,
		'database'	=> DB_DBNAME,
	]);
	
	$bot->addCommandsPath(dirname(__DIR__).'/src/Command');
	
	$server_response = $bot->handleGetUpdates();
	
	if ($server_response->isOk()) {
		$update_count = count($server_response->getResult());
		echo date('Y-m-d H:i:s') . ' - Processed ' . $update_count . ' updates' . PHP_EOL;
	} else {
		echo date('Y-m-d H:i:s') . ' - Failed to fetch updates' . PHP_EOL;
		echo $server_response->printError();
	}
	
} catch(TelegramException $e) {
	TelegramLog::error($e);
	echo $e;
	
} catch(TelegramLogException $e) {
	echo $e;
	
} catch(Exception $e) {
	echo $e->getMessage();
}
