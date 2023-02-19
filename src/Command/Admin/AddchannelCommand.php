<?php

namespace Longman\TelegramBot\Commands\AdminCommands;

use Longman\TelegramBot\Commands\AdminCommand;
use Longman\TelegramBot\DB;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class AddchannelCommand extends AdminCommand
{
	protected $name = 'addchannel';
	protected $description = 'Add channel to database';
	protected $usage = '/addchannel <channel_title> or /addchannel <channel_id>';
	protected $version = '1.0.0';
    protected $need_mysql = true;

	public function execute(): ServerResponse
	{
		$args = trim($this->getMessage()->getText(true));
		
		if($args == '') {
			return $this->replyToChat('Please put channel title or id');
		}
		
		$select = [
			'channels'		=> true,
			'groups'		=> false,
			'supergroups'	=> false,
			'users'			=> false
		];
		
		if(is_int($args)) {
			$select['chat_id'] = $args;
		} else {
			$select['text'] = $args;
		}
		
		$channelList = DB::selectChats($select);
		
		// give channel list to admin then process selected channel
		
		return Request::emptyResponse();
	}
}
