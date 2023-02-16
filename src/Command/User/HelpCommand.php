<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Telegram;

class HelpCommand extends UserCommand
{
	protected $name = 'help';
	protected $description = 'Show command list';
	protected $usage = '/help';
	protected $version = '1.0.0';
	
	public function execute(): ServerResponse
	{
		$bot = $this->getTelegram();
		$isAdmin = $bot->isAdmin($this->getMessage()->getFrom()->getId());
		$commandList = '';
		
		foreach($bot->getCommandsList() as $command) {
			if($command instanceof Command) {
				if($isAdmin && $command->isAdminCommand()) {
					$commandList .= $command->getUsage() . ' - '. $command->getDescription() . PHP_EOL;
					
				} elseif($command->isUserCommand()) {
					$commandList .= $command->getUsage() . ' - '. $command->getDescription() . PHP_EOL;
				}
			}
		}
		
		return $this->replyToChat($commandList);
	}
}
