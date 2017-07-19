<?php

namespace Nerd\Framework\Http\IO;

use Nerd\Framework\Http\Request\Request;
use Nerd\Framework\Http\Request\RequestContract;

class GenericHttpInput implements InputContract
{
    /**
     * Get HTTP Request Object.
     *
     * @return RequestContract
     */
    public function getRequest()
    {
        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $method = $_SERVER["REQUEST_METHOD"];

        return new Request($path, $method, $_GET, $_POST, $_FILES, $_COOKIE, $_SERVER);
    }

    /**
     * Get HTTP Request Body as string.
     *
     * @return string
     */
    public function getBody()
    {
        try {
            $stream = $this->getStream();
            return stream_get_contents($stream);
        } finally {
            fclose($stream);
        }
    }

    /**
     * Get HTTP Request Body Stream.
     *
     * @return resource
     */
    public function getStream()
    {
        return fopen("php://input", "rb");
    }
}
