<?php
namespace Code4\Notifications\Engines;

use Code4\Notifications\Storage\StorageInterface;

class BasicNotifications implements EngineInterface {

    /**
     * @var string
     */
    private $name;

    /**
     * @var StorageInterface
     */
    private $store;

    /**
     * @var array
     */
    private $notifications = [];

    /**
     * list of closures. One for each type
     * @var array
     */
    private $closures = [];

    /**
     * @var bool
     */
    private $autoClearOnGet = false;

    /**
     * Constructs Notifications bag
     * @param string $name
     * @param StorageInterface $store
     * @param bool $autoClearOnGet
     */
    public function __construct($name, StorageInterface $store, $autoClearOnGet = false) {
        $this->name = $name;
        $this->store = $store;
        $this->autoClearOnGet = $autoClearOnGet;
        $this->load();
    }

    /**
     * Puts notification in bag. Stores after every change
     * Executes callback
     * @param string $type
     * @param string $notification
     * @param string|null $icon
     * @return EngineInterface
     */
    public function put($type, $notification, $icon = null) {
        $this->notifications[] = ['type' => $type, 'notification' => $notification, 'icon' => $icon];

        //Callback
        if (array_key_exists($type, $this->closures)) {
            $this->closures[$type]($notification);
        }

        $this->store();
        return $this;
    }

    /**
     * Gets notifications by type. If $clear flag is set - notifications are cleared
     * @param string $type
     * @param bool $clear
     * @return array
     */
    public function get($type = null, $clear = null) {
        $notifications = [];

        if ($type === null) {
            $notifications = $this->all();
        } else {
            foreach ($this->notifications as $notification) {
                if ($notification['type'] == $type) {
                    $notifications[] = $notification;
                }
            }
        }

        if($this->isDataHasToBeCleared($clear)) {
            $this->clear($type);
        }
        return $notifications;
    }

    /**
     * Counts notifications. If null - counts all
     * @param string|null $type
     * @return int
     */
    public function count($type = null) {
        if ($type === null) {
            return count($this->notifications);
        } else {
            return count($this->get($type));
        }
    }

    /**
     * Gets all notifications
     * @param bool $clear
     * @return array
     */
    public function all($clear = null) {
        $notifications = $this->notifications;
        if($this->isDataHasToBeCleared($clear)) {
            $this->clear();
        }
        return $notifications;
    }

    /**
     * Puts notification into store
     */
    public function store() {
        $this->store->set('notifications.'.$this->name, serialize($this->notifications));
    }

    /**
     * Gets notifications from store
     * @return array
     */
    public function retrieve() {
        $un = unserialize($this->store->get('notifications.'.$this->name));
        return $un === false ? [] : $un;
    }

    /**
     * Loads notifications from store to object
     */
    public function load() {
        $this->notifications = $this->retrieve();
    }

    /**
     * @param $type
     * @param \Closure $closure
     */
    public function addCallback($type, $closure) {
        if (is_object($closure) && ($closure instanceof \Closure)) {
            $this->closures[$type] = $closure;
        }
    }

    /**
     * Decides is data has to be cleared
     * @param bool|null $clear
     * @return bool
     */
    private function isDataHasToBeCleared($clear) {
        if ($clear === null) { $clear = $this->autoClearOnGet; }
        return $clear;
    }

    /**
     * Clears one type of notifications. If $type == null - clears all
     * @param string|null $type
     */
    public function clear($type = null) {
        if ($type !== null) {
            foreach($this->notifications as $key => $notification) {
                if ($notification['type'] == $type) {
                    unset($this->notifications[$key]);
                }
            }
            //Rebase all the keys
            $this->notifications = array_values($this->notifications);
        } else {
            $this->notifications = [];
        }
        $this->store->clear('notifications.'.$this->name);
        $this->store();
    }
}