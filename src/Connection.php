<?php 

namespace Vorbind\InfluxAnalytics;

 use InfluxDB\Client;
 use InfluxDB\Database;
 use Vorbind\InfluxAnalytics\Exception\AnalyticsException;

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
  private $username;
  private $password;

  public function __construct($username = '', $password = '', $host = 'localhost', $port = '8086') {
    $this->host = $host;
    $this->port = $port;
    $this->username = $username;
    $this->password = $password;
  }

  public function getDatabase($name) {
    try {      
      if (!isset($name)) {
        throw InvalidArgumentException::invalidType('"db name" driver option', $name, 'string');
      }

      if (null == $this->client) {
        $this->client = new \InfluxDB\Client($this->host, $this->port, $this->username, $this->password);
      }

      if (!isset($this->dbs[$name])) {
        $db = $this->client->selectDB($name);
        // if(!$db->exists()) {
        //   $db->create(null, false);
        // }
        $this->dbs[$name] = $db;
      }
    } catch(Exception $e) {
        throw new AnalyticsException("Connecting influx db faild", 0, $e);
    }
    return $this->dbs[$name];
  }
}
