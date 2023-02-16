<?php

namespace TelegramBot\Lib;

use Longman\TelegramBot\Telegram;
use Medoo\Medoo;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

Class Bot
{
	private static function dbConnect() {
		return new Medoo([
			'type'		=> 'mysql',
			'host'		=> DB_HOST,
			'username'	=> DB_USERNAME,
			'password'	=> DB_PASSWORD,
			'database'	=> DB_DBNAME
		]);
	}
	
	public static function createLogger(String $name = 'Logger') {
		$logger = new Logger($name);
		if(ENV_DEV) {
			$logger->pushHandler(new StreamHandler('php://stdout'));
		} else {
			$logger->pushHandler((new RotatingFileHandler("logs/$name.log", 7, Logger::INFO))->setFilenameFormat('{date}-{filename}', 'Y-m-d'));
		}
		
		return $logger;
	}
	
	public static function initBot() {
		$bot = new Telegram(BOT_TOKEN, BOT_USERNAME);
		
		$bot->enableMySql([
			'host'		=> DB_HOST,
			'user'		=> DB_USERNAME,
			'password'	=> DB_PASSWORD,
			'database'	=> DB_DBNAME_VENDOR,
		]);
		
		$bot->addCommandsPath(dirname(__DIR__).'/Command');
		
		return $bot;
	}
}
