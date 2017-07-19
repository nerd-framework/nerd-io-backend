<?php

namespace Nerd\Framework\Http\IO;

use Nerd\Framework\Http\Response\CookieContract;

class GenericHttpOutput implements OutputContract
{
    /**
     * @var resource
     */
    private $output;

    public function __construct()
    {
        $this->output = fopen('php://output', 'w');
    }

    public function sendCookie(CookieContract $cookie)
    {
        $set = $cookie->isRaw() ? 'setrawcookie' : 'setcookie';

        $set(
            $cookie->getName(),
            $cookie->getValue(),
            $cookie->getExpire(),
            $cookie->getPath(),
            $cookie->getDomain(),
            $cookie->isSecure(),
            $cookie->isHttpOnly()
        );
    }

    public function sendHeader($header)
    {
        header($header);
    }

    public function sendData($data)
    {
        if (is_resource($data)) {
            stream_copy_to_stream($data, $this->output);
        } else {
            fwrite($this->output, $data);
        }
    }

    public function isHeadersSent()
    {
        return headers_sent();
    }

    public function flush()
    {
        fflush($this->output);
    }

    public function close()
    {
        fclose($this->output);
    }
}
