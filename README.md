StreamDefenseBot - One bot to rule them all 
========================================

StreamDefenseBot helps you to manage  your accounts in hard fights of [streamdefense.com](http://streamdefense.com)

[![Build Status](https://travis-ci.org/KonstantinKuklin/StreamDefenseBot.svg?branch=master)](https://travis-ci.org/KonstantinKuklin/StreamDefenseBot)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/konstantin-kuklin/stream-defense-bot.svg)](https://php.net/)
[![License](https://img.shields.io/github/license/konstantin-kuklin/stream-defense-bot.svg)](https://github.com/KonstantinKuklin/StreamDefenseBot/blob/master/LICENSE)


![bot screen](https://raw.githubusercontent.com/KonstantinKuklin/StreamDefenseBot/master/bot_screen.png)

Installation / Usage
--------------------

Install PHP 7.1.3 or above. [PHP.net](http://php.net/manual/en/install.php).

Download SdBot.phar file [here](https://raw.githubusercontent.com/KonstantinKuklin/StreamDefenseBot/master/sdbot.phar).

Update the bot to the latest version:
```
php sdbot.phar self-update
```

Create `config.yaml` file near the sdbot.phar file. File signature example with descriptions /config/config.yml.dst

That is it! The bot is ready:
```
php sdbot.phar run
```

Documentation
---------

Bot knows about 4 message types:
- message from bot `owner` (set owner in config.yml)
- message from bot `leader` (set follow_to in config.yml)
- message from anybody else (always will be ignored)
- special messages from TTDbot

## Owner
You can't become a bot owner except by config.yml.
You have additional bot command which are always starts from special char `$`:
- Follow command variations allowed if the bot not yet following somebody:
    - `$follow` all the bots for whom you own the owner will repeat your messages
    - `@bot1 $follow` the concrete `bot1` will repeat your messages if you are the owner for it
    - `@bot1 $follow @somebody` the concrete `bot1` will start following `somebody` if your are the owner of `bot1`
    - `group$follow` each bot in `group` will start following you if your are his owner 
    (so if in chat 2 different bot have group OP, but different owners - behavior will be different, I hope I was clear here in explanation)
    - `group$follow @somebody` same as previous, but will follow `somebody` 
- Unfollow command has the same syntax
- `$init` all your bots init their game by writing `!class` message from `config.yml`

Game commands:
- You have all grants as a leader plus !leave for bot.
- If your twitch nick has owner+leader grants when you !leave the bot will leave too.

## Leader
As a leader of some bots you can:
- `$unfollow` to stop following all bots from you
- `@bot $unfollow` to stop following you for concrete `bot`
- `group$unfollow` each bot in `group` stop following you if you are his leader

All followed you bots will repeat that commands:
- !t !train
- !p !pd !sp
- !1 !2 !3 !4 !5 !6 !7 !8 !9 !10 !11 !12
- !a !altar
- !fill
- ! - simple ping command

Also you are able to give an order:
- `@bot1 !a` just `bot1` will repeat `!a` if you are his leader
- `group!a` each bot in `group` repeat `!a` if you are his leader

The allowed order list is all commands from repeat section plus:
- !map1 !map2 !map3 !map4 !map5 !map6 !map7 !map8 !map9
- !archer !bard !frostmage !firemage !rogue !alchemist
- !hireshade !hireicelo !hireadara !hiremoor !hiremolan !hiregunnar !hirejubal !hirecortez
- !mfollow !unfollow
- !mfill !ma !mt !m1 !m2 !m3 !m4 !m5 !m6 !m7 !m8 !m9 !m10 !m11 !m12
- !mp !mpd !msp

Afterword
---------
It may not stable in some cases, because was written like in hackathon style without spending lot times.
So feel free to open bug issues or ask questions!
Have a good game!
