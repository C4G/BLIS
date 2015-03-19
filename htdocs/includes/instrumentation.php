<?php

namespace KBLIS\Instrumentation;
 
interface InstrumentorInterface
{
	/**
	* Returns information about an instrument 
	*
	* @return array('name' => '', 'description' => '', 'testTypes' => array()) 
	*/
    public function getEquipmentInfo();

	/**
	* Returns test results obtained from an instrument 
	*
	* @param int testTypeIdentifier
	* @return array('SAMPLE_ID' => id, measureName => measureValue, ...)
	*/
    public function getResult($testTypeID = 0);
}

namespace KBLIS\Instrumentation;
 
abstract class AbstractInstrumentor implements InstrumentorInterface
{
    protected $ip;
    protected $hostname;
 
    public function __construct($ip, $hostname = null) {
        if ($ip !== null) {
            $this->setIP($ip);
        }
        if ($hostname !== null) {
            $this->setHost($hostname);
        }
    }
 
    /**
    * Sets the IP Address of the instrument 
    *
    * @param int ip
    * @return AbstractInstrumentor implementation
    */
    public function setIP($ip) {
        $this->checkIP($ip);
        $this->ip = $ip;
        return $this;    
    }
 
    /**
    * Sets the Hostname of the instrument 
    *
    * @param String hostname
    * @return AbstractInstrumentor implementation
    */
    public function setHost($hostname) {
        $this->checkHost($hostname);
        $this->hostname = $hostname;
        return $this;    
    }
 
    /**
    * Validates the IP Address of the instrument 
    *
    * @param int ip
    * @return void
    * @throws InvalidArgumentException
    */
    protected function checkIP($value) {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException(
                "The ip address is invalid.");
        }
    }
 
    /**
    * Validates the hostname of the instrument 
    *
    * @param String hostname
    * @return void
    * @throws InvalidArgumentException
    */
    protected function checkHost($value) {
        if (!preg_match('/^[a-z0-9_-]+$/', $value)) {
            throw new InvalidArgumentException(
                "This hostname is invalid.");
        }
    }
}