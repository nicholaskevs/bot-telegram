<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class MyidCommand extends UserCommand
{
	protected $name = 'myid';
	protected $description = 'Get chatter user id';
	protected $usage = '/myid';
	protected $version = '1.0.0';
	
	public function execute(): ServerResponse
	{
		return $this->replyToChat('Your user ID is ' . $this->getMessage()->getFrom()->getId());
	}
}
