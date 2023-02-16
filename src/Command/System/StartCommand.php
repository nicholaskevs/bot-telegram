<?php

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class StartCommand extends SystemCommand
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
