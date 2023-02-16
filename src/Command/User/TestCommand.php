<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class TestCommand extends UserCommand
{
	protected $name = 'test';
	protected $description = 'A command for test';
	protected $usage = '/test';
	protected $version = '1.0.0';
	
	public function execute(): ServerResponse
	{
		$message = $this->getMessage();
		
		$chat_id = $message->getChat()->getId();
		
		$data = [
			'chat_id'	=> $chat_id,
			'text'		=> 'This is just a Test...',
		];
		
		// return Request::sendMessage($data);
		// return $this->replyToChat(
		// 	'Hi there!' . PHP_EOL .
		// 	'This is just a Test!'
		// );
		return Request::emptyResponse();
	}
}
