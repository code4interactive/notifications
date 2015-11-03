<?php

namespace Code4\Notifications\Test;

use Code4\Notifications\Facades\Notifications;

class NotificationsTest extends \PHPUnit_Framework_TestCase {

    private $notifications;
    private $engine;

    public function setUp()
    {
        parent::setUp();

        //$this->store = $this->getMockBuilder('Illuminate\Session\Store')
        //    ->setMethods(['get', 'set', 'clear'])
        //    ->getMock();

        //$notifications = $this->getMockBuilder('Code4\Notifications\Notifications')->setMethods();

        //$engine = $this->getMockBuilder('Code4\Notifications\Engines\EngineInterface')->getMock();
        //$engine->setMethods(['put','get','count','clear'])->method('get')->willReturn('foo');

        //$config = ['defaultStore' => 'session', 'autoCleanOnGet' => true, 'engine' => $this->engine];

        //$this->notifications = new Notifications($config);

    }

    public function testBasic() {
        //$this->engine->expects()->method('get')->will($this->returnValue([]));

        //$this->notifications->error('test');

        //$notification->make('error')->alert('Komunikat');

        //Notifications::error('Komunikat');
        //Notifications::success('Komunikat');
        //Notifications::warning('Komunikat');
        //Notifications::form('Komunikat', 'fieldId');
        //Notifications::send('Temat', 'Wiadomość', $userId);

        //Notifications::get('error')
        //Notifications::get('error')->all();
        //Notifications::get('error')->add('Komunikat');

        //$this->assertSame('','');


    }

}