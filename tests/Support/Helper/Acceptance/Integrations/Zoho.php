<?php

namespace Tests\Support\Helper\Acceptance\Integrations;

use com\zoho\crm\api\HeaderMap;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\record\GetRecordsParam;
use com\zoho\crm\api\record\RecordOperations;

trait Zoho
{
    public function fetchZohoData()
    {
        //Get instance of RecordOperations Class that takes moduleAPIName as parameter
        $recordOperations = new RecordOperations();
        $paramInstance = new ParameterMap();
        $paramInstance->add(GetRecordsParam::fields(), (object)"id");
        $paramInstance->add(GetRecordsParam::page(), (object)1);
        $paramInstance->add(GetRecordsParam::perPage(), (object)3);
        $startdatetime = date_create("2020-06-27T15:10:00+05:30")->setTimezone(new \DateTimeZone(date_default_timezone_get()));
        $headerInstance = new HeaderMap();
        return $recordOperations->getRecords('Email');
    }

}