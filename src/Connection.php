<?php 

namespace Vorbind\InfluxAnalytics;

 use InfluxDB\Client;
 use InfluxDB\Database;

/**
*  Analytics
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author sasa.rajkovic
*/
class Connection {

    private $db;
    private $client;
    private $host;
    private $port;

    public function __construct($host = 'localhost', $port = '8186') {
    	$this->host = $host;
    	$this->port = $port;
    }

    public function getDatabase($name) {

      if (!isset($name)) {
            throw InvalidArgumentException::invalidType('"db name" driver option', $name, 'string');
        }

      if (null == $this->client) {
            $this->client = new \InfluxDB\Client($this->host, $this->port);
      }

      if (!isset($this->dbs[$name])) {
          $this->dbs[$name] = $this->client->selectDB($name);
      }

      return $this->dbs[$name];
    }
}