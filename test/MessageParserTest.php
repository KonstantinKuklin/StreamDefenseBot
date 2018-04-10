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
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => 'ololo inda house',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'text to somebody' => [
                'input' => ':nick!:@nick2 ololo inda house',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => '@nick2 ololo inda house',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'unknown command' => [
                'input' => ':nick!:!command',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [],
                    'isCommandForGame' => true,
                    'text' => '!command',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'two unknown command' => [
                'input' => ':nick!:!command !fly',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [],
                    'isCommandForGame' => true,
                    'text' => '!command !fly',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'command' => [
                'input' => ':nick!:!t',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => ['!t'],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [],
                    'isCommandForGame' => true,
                    'text' => '!t',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'three command' => [
                'input' => ':nick!:!t !p !bard',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => ['!t', '!p', '!bard'],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [],
                    'isCommandForGame' => true,
                    'text' => '!t !p !bard',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'command for person' => [
                'input' => ':nick!:@bot !t',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => ['!t'],
                    'botCommandList' => [],
                    'commandForNick' => 'bot',
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => '@bot !t',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'two command for person' => [
                'input' => ':nick!:@bot !t !p',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => ['!t', '!p'],
                    'botCommandList' => [],
                    'commandForNick' => 'bot',
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => '@bot !t !p',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'one known command and one unknown' => [
                'input' => ':nick!:@bot !hello !t',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => ['!t'],
                    'botCommandList' => [],
                    'commandForNick' => 'bot',
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => '@bot !hello !t',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'group command' => [
                'input' => ':nick!:test!t',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [
                        'test' => ['!t'],
                    ],
                    'isCommandForGame' => false,
                    'text' => 'test!t',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'two group command' => [
                'input' => ':nick!:test!t !p',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => ['!p'],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [
                        'test' => ['!t'],
                    ],
                    'isCommandForGame' => false,
                    'text' => 'test!t !p',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'bot command' => [
                'input' => ':nick!:$init',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => '$init',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'bot two command' => [
                'input' => ':nick!:$init $remove',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => '$init $remove',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'bot command for bot' => [
                'input' => ':nick!:@bot $init',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => 'bot',
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => '@bot $init',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'two bot command for bot' => [
                'input' => ':nick!:@bot $init $remove',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => 'bot',
                    'commandForGroup' => [],
                    'isCommandForGame' => false,
                    'text' => '@bot $init $remove',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'bot command for group' => [
                'input' => ':nick!:test$init',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => 'test',
                    'isCommandForGame' => false,
                    'text' => 'test$init',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'two bot command for group' => [
                'input' => ':nick!:test$init $remove',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => 'test',
                    'isCommandForGame' => false,
                    'text' => 'test$init $remove',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'common command plus commands to group' => [
                'input' => ':nick!:!archer !3 d!bard d!2',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => ['!archer', '!3'],
                    'botCommandList' => [],
                    'commandForNick' => null,
                    'commandForGroup' => [
                        'd' => [
                            '!bard',
                            '!2',
                        ],
                    ],
                    'isCommandForGame' => true,
                    'text' => '!archer !3 d!bard d!2',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => false,
                ],
            ],
            'two bot command for group with ignore attr' => [
                'input' => ':nick!:test$init $remove xx',
                'expected' => [
                    'author' => 'nick',
                    'gameCommandList' => [],
                    'botCommandList' => ['$init'],
                    'commandForNick' => null,
                    'commandForGroup' => 'test',
                    'isCommandForGame' => false,
                    'text' => 'test$init $remove xx',
                    'gameCommandTar' => null,
                    'hasIgnoreAttribute' => true,
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
