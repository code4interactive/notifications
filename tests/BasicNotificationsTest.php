<?php
namespace Code4\Notifications\Test;

use Code4\Notifications\Engines\BasicNotifications;
use Mockery as m;

class BasicNotificationsTest extends \PHPUnit_Framework_TestCase {

    private $store;
    /**
     * @var BasicNotifications
     */
    private $notifications;

    public function setUp()
    {
        parent::setUp();

        $this->store = $this->getMockBuilder('Code4\Notifications\Storage\StorageInterface')
            ->setMethods(['get', 'set', 'clear'])
            ->getMock();

        $this->notifications = new BasicNotifications('customName', $this->store, false);
    }

    public function testPut() {
        $this->notifications->put('error', 'error1');
        $this->notifications->put('error', 'error2');
        $this->notifications->put('notice', 'notice1');
        $this->assertEquals([['type'=>'error', 'notification'=>'error1', 'icon' => null],['type'=>'error', 'notification'=>'error2', 'icon' => null]], $this->notifications->get('error', false));
        $this->assertEquals([], $this->notifications->get('notExistingType'));
        $this->assertSame([
            ['type'=>'error', 'notification'=>'error1', 'icon' => null],
            ['type'=>'error', 'notification'=>'error2', 'icon' => null],
            ['type'=>'notice', 'notification'=>'notice1', 'icon' => null]
        ], $this->notifications->get());
    }

    public function testAll() {
        $this->notifications->put('error', 'error1');
        $this->notifications->put('error', 'error2');
        $this->notifications->put('notice', 'notice1');
        $this->assertSame([
            ['type'=>'error', 'notification'=>'error1', 'icon' => null],
            ['type'=>'error', 'notification'=>'error2', 'icon' => null],
            ['type'=>'notice', 'notification'=>'notice1', 'icon' => null]
        ], $this->notifications->all());
    }

    public function testCount() {
        $this->notifications->put('error', 'error1');
        $this->notifications->put('error', 'error2');
        $this->notifications->put('error', 'error3');
        $this->notifications->put('notice', 'notice1');
        $this->notifications->put('notice', 'notice2');

        $this->assertEquals(3, $this->notifications->count('error'));
        $this->assertEquals(5, $this->notifications->count()); //Count all
    }

    public function testClear() {
        $this->notifications->put('error', 'error1');
        $this->notifications->put('error', 'error2');
        $this->notifications->put('error', 'error3');
        $this->notifications->put('notice', 'notice1');
        $this->notifications->put('notice', 'notice2');

        $this->notifications->clear('error');
        $this->assertEquals(2, $this->notifications->count());

        $this->notifications->clear();
        $this->assertEquals(0, $this->notifications->count());
    }

    public function testAutoClean() {
        $notifications = new BasicNotifications('customName', $this->store, true);

        $notifications->put('error', 'error1');
        $notifications->put('error', 'error2');
        $notifications->put('error', 'error3');
        $notifications->put('notice', 'notice1');
        $notifications->put('notice', 'notice2');

        $notifications->get('error');
        $this->assertEquals(2, $notifications->count());

        $notifications->get();
        $this->assertEquals(0, $notifications->count());
    }

    public function testSavingToStore() {
        /*$store = \Mockery::mock('Code4\Notifications\Storage\StorageInterface');
        $store->shouldReceive('get');
        $store->shouldReceive('set');
        $store->shouldReceive('clear');*/
    }

}