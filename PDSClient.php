<?php
// GENERATED CODE -- DO NOT EDIT!

//namespace ;

/**
 */
class PDSClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Start($metadata = [], $options = []) {
        return $this->_bidiRequest('/PDS/Start',
        ['\ServiceMessage','decode'],
        $metadata, $options);
    }

}
