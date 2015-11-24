<?php
namespace Code4\Notifications\Storage;

use Illuminate\Session\Store;

class SessionStore implements StorageInterface {

    /**
     * Session store object.
     *
     * @var \Illuminate\Session\Store
     */
    protected $session;

    public function __construct(Store $session) {
        $this->session = $session;
    }

    /**
     * @inheritdoc
     */
    public function get($key, $default = null)
    {
        return $this->session->get($key, $default);
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        $this->session->set($key, $value);
    }

    /**
     * @inheritdoc
     */
    public function clear($key) {
        $this->session->forget($key);
    }

}