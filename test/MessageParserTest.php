<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test;

use KonstantinKuklin\StreamDefenseBot\MessageParser;

class MessageParserTest extends \PHPUnit\Framework\TestCase
{
    public function dataParse()
    {
        return [
            'text' => [
                'input' => ':nick!:ololo inda house',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => 'ololo inda house',
                    'text' => 'ololo inda house',
                ],
            ],
            'text to somebody' => [
                'input' => ':nick!:@nick2 ololo inda house',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => '@nick2 ololo inda house',
                    'text' => '@nick2 ololo inda house',
                ],
            ],
            'unknown command' => [
                'input' => ':nick!:!command',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => null,
                    'isCommandForGame' => true,
                    'message' => '!command',
                    'text' => '!command',
                ],
            ],
            'two unknown command' => [
                'input' => ':nick!:!command !fly',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => null,
                    'isCommandForGame' => true,
                    'message' => '!command !fly',
                    'text' => '!command !fly',
                ],
            ],
            'command' => [
                'input' => ':nick!:!t',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => ['!t'],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => null,
                    'isCommandForGame' => true,
                    'message' => '!t',
                    'text' => '!t',
                ],
            ],
            'three command' => [
                'input' => ':nick!:!t !p !bard',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => ['!t', '!p', '!bard'],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => null,
                    'isCommandForGame' => true,
                    'message' => '!t !p !bard',
                    'text' => '!t !p !bard',
                ],
            ],
            'command for person' => [
                'input' => ':nick!:@bot !t',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => ['!t'],
                    'botCommandList' => [],
                    'commandForNick' => 'bot',
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => '@bot !t',
                    'text' => '@bot !t',
                ],
            ],
            'two command for person' => [
                'input' => ':nick!:@bot !t !p',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => ['!t', '!p'],
                    'botCommandList' => [],
                    'commandForNick' => 'bot',
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => '@bot !t !p',
                    'text' => '@bot !t !p',
                ],
            ],
            'one known command and one unknown' => [
                'input' => ':nick!:@bot !hello !t',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => ['!t'],
                    'botCommandList' => [],
                    'commandForNick' => 'bot',
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => '@bot !hello !t',
                    'text' => '@bot !hello !t',
                ],
            ],
            'group command' => [
                'input' => ':nick!:test!t',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => ['!t'],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => 'test',
                    'isCommandForGame' => false,
                    'message' => 'test!t',
                    'text' => 'test!t',
                ],
            ],
            'two group command' => [
                'input' => ':nick!:test!t !p',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => ['!t', '!p'],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => 'test',
                    'isCommandForGame' => false,
                    'message' => 'test!t !p',
                    'text' => 'test!t !p',
                ],
            ],
            'bot command' => [
                'input' => ':nick!:$init',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => '$init',
                    'text' => '$init',
                ],
            ],
            'bot two command' => [
                'input' => ':nick!:$init $remove',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => '$init $remove',
                    'text' => '$init $remove',
                ],
            ],
            'bot command for bot' => [
                'input' => ':nick!:@bot $init',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => 'bot',
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => '@bot $init',
                    'text' => '@bot $init',
                ],
            ],
            'two bot command for bot' => [
                'input' => ':nick!:@bot $init $remove',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => 'bot',
                    'commandForGroup' => null,
                    'isCommandForGame' => false,
                    'message' => '@bot $init $remove',
                    'text' => '@bot $init $remove',
                ],
            ],
            'bot command for group' => [
                'input' => ':nick!:test$init',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => 'test',
                    'isCommandForGame' => false,
                    'message' => 'test$init',
                    'text' => 'test$init',
                ],
            ],
            'two bot command for group' => [
                'input' => ':nick!:test$init $remove',
                'expected' => [
                    'nick' => 'nick',
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => 'test',
                    'isCommandForGame' => false,
                    'message' => 'test$init $remove',
                    'text' => 'test$init $remove',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataParse
     */
    public function testParse($inputString, $expectedResult)
    {
        $actualResult = MessageParser::getParsedMessage($inputString);
        $actualResult = \get_object_vars($actualResult);

        self::assertEquals($expectedResult, $actualResult);
    }
}
