<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>ErrRate</code>
 */
class ErrRate extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>double maximum_error_rate = 1;</code>
     */
    private $maximum_error_rate = 0.0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type float $maximum_error_rate
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>double maximum_error_rate = 1;</code>
     * @return float
     */
    public function getMaximumErrorRate()
    {
        return $this->maximum_error_rate;
    }

    /**
     * Generated from protobuf field <code>double maximum_error_rate = 1;</code>
     * @param float $var
     * @return $this
     */
    public function setMaximumErrorRate($var)
    {
        GPBUtil::checkDouble($var);
        $this->maximum_error_rate = $var;

        return $this;
    }

}

