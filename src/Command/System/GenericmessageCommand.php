<?php

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Telegram;

class GenericmessageCommand extends SystemCommand
{
	protected $name = Telegram::GENERIC_MESSAGE_COMMAND;
	protected $description = 'Handles generic message';
	protected $version = '1.0.0';
	protected $private_only = true;
	
	public function execute(): ServerResponse
	{
		// Try to continue any active conversation.
        if($active_conversation_response = $this->executeActiveConversation()) {
            return $active_conversation_response;
        }
		
		return $this->replyToChat(
			"Hello\n".
			"Type /help to see all commands"
		);
	}
}
