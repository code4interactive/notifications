<?php
namespace Code4\Notifications\Engines;

use Code4\Notifications\Storage\StorageInterface;

interface EngineInterface {

    /**
     * @param string $name
     * @param StorageInterface $store
     * @param bool|false $autoClearOnGet
     */
    public function __construct($name, StorageInterface $store, $autoClearOnGet = false);


    /**
     * @param string $type
     * @param string $notification
     * @return EngineInterface
     */
    public function put($type, $notification);

    /**
     * @param null $type
     * @param null $clear
     * @return array
     */
    public function get($type = null, $clear = null);

    /**
     * @param null|string $type
     * @return int
     */
    public function count($type = null);

    /**
     * @param null|string $type
     */
    public function clear($type = null);
}