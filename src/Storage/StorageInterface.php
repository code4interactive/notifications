<?php
namespace Code4\Notifications\Storage;

interface StorageInterface {

    /**
     * Gets data from store
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Puts data in store
     * @param string $key
     * @param string $value
     */
    public function set($key, $value);

    /**
     * Removes data from store
     * @param string $key
     */
    public function clear($key);

}