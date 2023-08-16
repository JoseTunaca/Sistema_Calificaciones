<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testFullName()
    {
        $user = new User('John', 'Doe');
        $this->assertEquals('John Doe', $user->getFullName());
    }
}
