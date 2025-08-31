<?php

namespace Longman\TelegramBot\Commands\AdminCommands;

use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class SendtochannelCommand extends AdminCommand
{
	protected $name = 'sendtochannel';
	protected $description = 'Update message to channel';
	protected $usage = '/sendtochannel <channel_id> <message>';
	protected $version = '1.0.0';
	
	public function execute(): ServerResponse
	{
		$args = explode(' ', trim($this->getMessage()->getText(true)));
		
		if(count($args) < 2) {
			return $this->replyToChat('Need more arguments');
		}
		
		$channel = DB::selectChats([
			'channels'		=> true,
			'users'			=> false,
			'groups'		=> false,
			'supergroups'	=> false,
			'chat_id'		=> $args[0]
		]);
		
		if(empty($channel)) {
			return $this->replyToChat('Channel not found');
		}
		
		$response = Request::sendMessage([
			'chat_id'	=> $args[0],
			'text'		=> $args[1]
		]);
		
		if($response->isOk()) {
			return $this->replyToChat('Message sent');
		} else {
			return $this->replyToChat('Failed to send message');
		}
	}
}
