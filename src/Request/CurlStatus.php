<?php

namespace Hschulz\FpmStatus\Request;

use function \curl_close;
use function \curl_error;
use function \curl_init;
use function \curl_setopt;
use const \CURLOPT_FOLLOWLOCATION;
use const \CURLOPT_RETURNTRANSFER;
use const \CURLOPT_URL;
use \Exception;
use function \get_resource_type;
use \Hschulz\FpmStatus\Model\Status;
use function \json_decode;
use function \json_last_error_msg;

/**
 * Uses curl to get the return from an fpm status page.
 */
class CurlStatus
{
    /**
     * A curl ressource.
     *
     * @var resource
     */
    protected $ch = null;

    /**
     * Creates and initializes the curl ressource.
     */
    public function __construct()
    {
        $this->open();
    }

    /**
     * Closes the curl ressource.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     *
     * @param string $url
     * @return Status
     * @throws Exception
     */
    public function getStatus(string $url): Status
    {
        try {
            $data = $this->getArray($url);
        } catch (Exception $e) {
            throw $e;
        }

        return new Status($data);
    }

    /**
     *
     * @param string $url
     * @return array
     * @throws Exception
     */
    public function getArray(string $url): array
    {
        try {
            $response = $this->get($url);
        } catch (Exception $e) {
            throw $e;
        }

        $data = json_decode($response, true, 4);

        if ($data === null) {
            throw new Exception(
                'There was an error decoding the received data' . PHP_EOL . json_last_error_msg()
            );
        }

        return $data;
    }

    /**
     * Tries to open the given url with curl and returns the data.
     * The json return format is mandatory for the request to work.
     *
     * @param string $url A url pointing to the php fpm status page
     * @return string The returned json data
     * @throws Exception
     */
    public function getJson(string $url): string
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);

        $response = curl_exec($this->ch);

        if ($response === '' || $response === false) {
            throw new Exception('CURL error: ' . curl_error($this->ch));
        }

        return $response;
    }

    /**
     * Initializes the underlying curl connection.
     *
     * @return void
     */
    public function open(): void
    {
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * Closes the underlying curl connection.
     *
     * @return void
     */
    public function close(): void
    {
        if ($this->ch !== null && get_resource_type($this->ch) === 'curl') {
            curl_close($this->ch);
        }
    }
}
