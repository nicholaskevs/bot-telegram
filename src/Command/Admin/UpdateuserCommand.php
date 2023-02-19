<?php

namespace Longman\TelegramBot\Commands\AdminCommands;

use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Entities\ServerResponse;
use TelegramBot\Lib\Bot;

class UpdateuserCommand extends AdminCommand
{
	protected $name = 'updateuser';
	protected $description = 'Update user data on database';
	protected $usage = '/updateuser';
	protected $version = '1.0.0';
	protected $need_mysql = true;
	
	public function execute(): ServerResponse
	{
		$select = [
			'channels'		=> true,
			'users'			=> true,
			'groups'		=> false,
			'supergroups'	=> false
		];
		
		$data = DB::selectChats($select);
		
		if(Bot::updateUser($data)) {
			return $this->replyToChat('User data on database updated');
		} else {
			return $this->replyToChat('Something went wrong, user data on database not updated');
		}
	}
}
