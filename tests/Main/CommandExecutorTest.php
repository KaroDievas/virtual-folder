<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 21:58
 */

namespace KD\VirtualFolder\tests\Main;


use KD\VirtualFolder\Exception\CommandNotFoundException;
use PHPUnit\Framework\TestCase;

class CommandExecutorTest extends TestCase
{
    public function testCommandNotFound()
    {
        //$this->expectException(CommandNotFoundException::class);
    }
}