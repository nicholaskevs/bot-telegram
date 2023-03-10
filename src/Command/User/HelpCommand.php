<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\Command;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;

class HelpCommand extends UserCommand
{
	protected $name = 'help';
	protected $description = 'Show command list';
	protected $usage = '/help or /help <command name>';
	protected $version = '1.0.0';
	
	public function execute(): ServerResponse
	{
		$bot = $this->getTelegram();
		$message = $this->getMessage();
		
		$arg = trim($message->getText(true));
		$isAdmin = $bot->isAdmin($message->getFrom()->getId());
		$isPrivateChat = $message->getChat()->isPrivateChat();
		$text = [];
		
		$commandList = $bot->getCommandsList();
		$commandList = array_filter($commandList, function (Command $command) {
			return !$command->isSystemCommand() && $command->showInHelp() && $command->isEnabled();
		});
		ksort($commandList);
		
		if($arg == '') {
			$userCommands = array_filter($commandList, function (Command $command) {
				return $command->isUserCommand();
			});
			
			$text[] = '*Command list:*';
			
			foreach($userCommands as $command) {
				if($command instanceof Command) {
					$text[] = '/' . $command->getName() .' - '. $command->getDescription();
				}
			}
			
			if($isAdmin && $isPrivateChat) {
				$text[] = '';
				$text[] = '*Admin Command list:*';
				
				$adminCommands = array_filter($commandList, function (Command $command) {
					return $command->isAdminCommand();
				});
				
				foreach($adminCommands as $command) {
					if($command instanceof Command) {
						$text[] = '/' . $command->getName() .' - '. $command->getDescription();
					}
				}
			}
			
			return $this->replyToChat(implode(PHP_EOL, $text), ['parse_mode' => 'Markdown']);
		} else {
			$text[] = 'Command not found';
			
			if(isset($commandList[$arg])) {
				$command = $commandList[$arg];
				
				if($command instanceof Command) {
					if(($command->isAdminCommand() && $isAdmin && $isPrivateChat) || $command->isUserCommand()) {
						$text[] = 'Command: ' . $command->getName();
						$text[] = 'Usage: ' . $command->getUsage();
						$text[] = 'Description: ' . $command->getDescription();
					}
				}
			}
			return $this->replyToChat(implode(PHP_EOL, $text));
		}
	}
}
