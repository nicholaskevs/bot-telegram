<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class StartCommand extends UserCommand
{
	protected $name = 'start';
	protected $description = 'Start command';
	protected $usage = '/start';
	protected $version = '1.0.0';
	protected $private_only = true;
	
	public function execute(): ServerResponse
	{
		return $this->replyToChat(
			"Hello\n".
			"Type /help to see all commands"
		);
	}
}
