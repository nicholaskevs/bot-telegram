<?php

namespace TelegramBot\Lib;

use Exception;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
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
		$db = self::dbConnect();
		$bot = new Telegram(BOT_TOKEN, BOT_USERNAME);
		
		$bot->enableMySql([
			'host'		=> DB_HOST,
			'user'		=> DB_USERNAME,
			'password'	=> DB_PASSWORD,
			'database'	=> DB_DBNAME_VENDOR,
		]);
		
		$bot->setCommandsPaths([
			dirname(__DIR__).'/Command/Admin',
			dirname(__DIR__).'/Command/System',
			dirname(__DIR__).'/Command/User'
		]);
		
		$admins = $db->select('users', 'telegram_id', ['admin'=>true]);
		$bot->enableAdmins($admins);
		
		unset($db);
		return $bot;
	}
	
	public static function updateUser(Array $users) {
		$db = self::dbConnect();
		
		try {
			foreach($users as $user) {
				if($user['type'] == 'private') {
					$db->update('users', [
						'first_name'	=> $user['first_name'],
						'last_name'		=> $user['last_name'],
						'username'		=> $user['username']
					], ['telegram_id' => $user['user_id']]);
				}
			}
		} catch(Exception $e) {
			TelegramLog::error($e->getMessage());
			return false;
			
		} finally {
			unset($db);
		}
		
		return true;
	}
	
	private static function generateAPIKey(): string {
		$db = self::dbConnect();
		
		do {
			$key = implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 20), 5));
			
			$check =  $db->select('users', '*', ['api_key' => $key]);
		} while(!empty($check));
		
		unset($db);
		return $key;
	}
	
	public static function validateAPIKey(string $key): int|bool {
		$db = self::dbConnect();
		
		$user = $db->select('users', 'id', ['api_key' => $key]);
		unset($db);
		
		if(empty($user)) {
			return false;
		} else {
			return $user[0];
		}
	}
}
