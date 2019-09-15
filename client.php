<?php

require 'vendor/autoload.php';
require 'GPBMetadata/Service.php';
require 'PDSClient.php';
require 'Init.php';
require 'PutTask.php';
require 'Statistic.php';
require 'ErrRate.php';
require 'RequestMessage.php';
require 'ServiceMessage.php';
require 'InitResponse.php';
require 'GetTask.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$tasks= [];

$client = new PDSClient('pds.voximplant.com:3000', ['credentials' => Grpc\ChannelCredentials::createInsecure()]);

$init = new Init();
$init->setAccountId($_ENV['ACCOUNT_ID']);
$init->setApiKey($_ENV['API_KEY']);
$init->setRuleId($_ENV['RULE_ID']);
$init->setQueueId($_ENV['QUEUE_ID']);
$init->setMaximumErrorRate($_ENV['MAXMIMUM_ERROR_RATE']);


$statistic = new Statistic();
$statistic->setAvgTimeTalkSec($_ENV['AVG_TIME_TALK_SEC']);
$statistic->setPercentSuccessful($_ENV['PERCENT_SUCCESSFUL']);
$init->setInitStat($statistic);


$requestMessage = new RequestMessage();
$requestMessage->setInit($init);
$requestMessage->setType(1);


//инитим стрим-клиента
$streamingCall = $client->Start();

$streamingCall->write($requestMessage);

while (true){
  if ($data = $streamingCall->read()) {
    /** @var ServiceMessage $data */
    $type = $data->getType();
    if ($type === 1/*Type::INIT_RESPONSE*/) {
      $sessionID = $data->getInit()->getSessionId();
      echo "INIT_RESPONSE = {$type}\n";
      echo "SESSION_ID = {$sessionID}\n";
    } elseif ($type == 0/*Type::GET_TASK*/) {
      echo "GET_TASK = {$type}\n";
      echo "COUNT = {$data->getRequest()->getCount()}\n";
      receiveTasks();
      $count = $data->getRequest()->getCount();

      if ($count) {
        for ($i = 0; $i < $count; $i++) {
          if (!$tasks) break;
          $task = array_pop($tasks);
          $buildRequestMessageTask = buildRequestMessageTask($task);
          $streamingCall->write($buildRequestMessageTask);
        }
      }
    }
  }
}


function receiveTasks() {
  global $tasks;
  $tasks[] = [
    'test' => 'test',
    'test1' => 'test1',
  ];
  //тут дерагем метод, который вернет нам список задач
  //далее этот список добавляем к в $tasks
}


/**
 * @param $task
 * @return RequestMessage
 */
function buildRequestMessageTask($task) {
  $task = (new PutTask())
    ->setTaskUUID(getGUID())
    ->setCustomData(is_array($task) ? json_encode($task) : $task);
  return (new RequestMessage())->setTask($task);
}

function getGUID(){
  if (function_exists('com_create_guid')){
    return com_create_guid();
  }else{
    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = chr(123)// "{"
      .substr($charid, 0, 8).$hyphen
      .substr($charid, 8, 4).$hyphen
      .substr($charid,12, 4).$hyphen
      .substr($charid,16, 4).$hyphen
      .substr($charid,20,12)
      .chr(125);// "}"
    return $uuid;
  }
}
