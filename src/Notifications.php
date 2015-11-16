<?php
namespace Code4\Notifications;

use Code4\Notifications\Engines\BasicNotifications;
use Code4\Notifications\Storage\StorageInterface;
use Illuminate\Session\Store;

class Notifications {

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var array
     */
    private $stores = [];

    /**
     * @var array
     */
    private $notifications = [];

    /**
     * @param array $config
     */
    public function __construct($config) {
        $this->config = $config;
    }

    /**
     * Adds storage type use in bags
     *
     * @param string $storeName
     * @param StorageInterface $store
     */
    public function addStore($storeName, StorageInterface $store) {
        $this->stores[$storeName] = $store;
    }

    /**
     * Creates new notifications bag
     *
     * @param string $storeName
     * @param string $bag
     * @param bool|null $autoCleanOnGet
     * @throws \Exception Store not found
     */
    public function make($storeName, $bag = 'default', $autoCleanOnGet = null) {

        if (!array_key_exists($storeName, $this->stores)) {
            throw new \Exception('Store "' . $storeName . '" not found!');
        }

        $this->notifications[$bag] = new $this->config['engine']($storeName, $this->stores[$storeName], !is_null($autoCleanOnGet) ? $autoCleanOnGet : $this->config['autoCleanOnGet']);
        //$this->notifications[$bag] = new BasicNotifications('default', $this->stores[$storeName], !is_null($autoCleanOnGet) ? $autoCleanOnGet : $this->config['autoCleanOnGet']);
    }

    /**
     * Gets requested or default bag (if bag don't exist - creates it)
     * @param $bag
     */
    public function bag($bag = 'default') {
        if (!array_key_exists($bag, $this->notifications)) {
            $this->make($this->config['defaultStore'], $bag);
        }

        return $this->notifications[$bag];
    }


    /**
     * Shortcut method for default bag
     * @return mixed
     */
    public function all() {
        return $this->bag()->get();
    }

    /**
     * Shortcut message for default bag
     * @param null|string $type
     * @param null|bool $clear
     * @return mixed
     */
    public function get($type = null, $clear = null) {
        return $this->bag()->get($type, $clear);
    }

    /**
     * Dynamically passes alerts to the view.
     * Notification::error('Message')
     * Notification::error('Message', 'bag')
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return BasicNotifications
     */
    public function __call($method, $parameters)
    {
        list($message, $bag) = $this->parseParameters($parameters);
        $icon = null;
        if (array_key_exists($method, $this->config['icons'])) {
            $icon = $this->config['icons'][$method];
        }

        return $this->bag($bag)->put($method, $message, $icon);
    }


    /**
     * Parses parameters.
     *
     * @param  array  $parameters
     * @return array
     */
    protected function parseParameters($parameters)
    {
        $message = isset($parameters[0]) ? $parameters[0] : null;

        $bag = isset($parameters[1]) ? $parameters[1] : 'default';

        return [ $message, $bag ];
    }
}