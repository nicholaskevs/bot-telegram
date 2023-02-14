# bot-telegram

Simple Telegram bot to get message content from database and forward it to telegram channel

## How to use

### Requirement

- PHP >=8.0
- MySQL
- For windows, add php folder path to system variables `path`, follow this [guide](https://www.computerhope.com/issues/ch000549.htm)

### How to install

1. Download [here](https://github.com/nicholaskevs/bot-telegram/archive/refs/heads/master.zip)
2. Extract
3. Install dependency with `composer`
4. Go to `config` folder
5. Change `cons.php-template` into `cons.php`
6. Fill in `cons.php` with your data
7. Run `vendor\longman\telegram-bot\structure.sql`
8. Run all sql files in `schema` folder
9. Give execute permission with `chmod +x telegrambot.php`
10. Run `./telegrambot.php` or open `telegrambot.bat` for windows
