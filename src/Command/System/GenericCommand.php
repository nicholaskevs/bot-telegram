<?php

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class GenericCommand extends SystemCommand
{
	protected $name = Telegram::GENERIC_COMMAND;
	protected $description = 'Handles generic commands or is executed by default when a command is not found';
	protected $version = '1.0.0';
	
	public function execute(): ServerResponse
	{
		// if($this->getChannelPost() || $this->getMyChatMember() || $this->getChatMember()) { // dont process channel post, my chat member, and chat member updates
		// 	return Request::emptyResponse();
		// }
		
		if($message = $this->getMessage()) {
			return $this->replyToChat(
				"Command /{$message->getCommand()} not found". PHP_EOL .
				"Type /help to see all commands"
			);
		}
	}
}
