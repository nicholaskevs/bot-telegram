<?php

namespace TelegramBot\Lib;

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
	
	public static function createLogger() {
		$logger = new Logger('TelegramBot');
		if(ENV_DEV) {
			$logger->pushHandler(new StreamHandler('php://stdout'));
		} else {
			$logger->pushHandler((new RotatingFileHandler('logs/TelegramBot.log', 7, Logger::INFO))->setFilenameFormat('{date}-{filename}', 'Y-m-d'));
		}
		
		return $logger;
	}
}
