<?php
/**
  * 2017
  * Bootstrap for Venture Oak HR Test
  * Used Phalcon as ORM + Routing habilities
  *
  * Custom brewed for testing purposes
  * @author Carrola
  */
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

error_reporting(E_ALL);
ini_set("display_errors","on");
ini_set("display_startup_errors","on");

use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Config\Adapter\Ini as IniConfig;

$loader = new Loader();
$loader->registerDirs(
    [
       __DIR__."/app/models/",
       __DIR__."/app/helpers/",
    ]
);
$loader->register();
$di = new FactoryDefault();

$di->set(
    "config",
    function () {
        return new IniConfig("config.ini");
    }
);

$di->set('db', function ()  {
    $config = Phalcon\DI::getDefault()->get("config");
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});

$app = new Micro();
$app->setDI($di);


$app->get(
    "/translate",
    function () {
      $output = new OutputHelper();
      try{
        $request = new RequestHandler();
        $user    = UserAuthenticationFactory::getByRequest($request);
        if ($user){
          $translation = TranslationFactory::get($request->getLanguage());
          $output->setResults(
                    array(
                      "original"=>$request->getTranslationString(),
                      "language"=>$request->getLanguage(),
                      "translation"=> $translation->get($request->getTranslationString())
                    )
          );
        }
      }catch(InvalidRequestException $e){
        $output->setErrors($e->getMessage());
      }catch(InvalidUserException $e){
        $output->setErrors($e->getMessage());
      }catch(Exception $e){
        $output->setErrors($e->getMessage());
      }finally{
        $output->send($request->getFormat());
      }
    }
);

$app->get(
    "/token",
    function () {
      $output = new OutputHelper();
      try{
        $request = new RequestHandler();
        $user    = UserAuthenticationFactory::getByRequest($request);
        if ($user){
          //we want a token for this user
          $token = Token::getTokenForUser($user);
          if ($token)
            $output->setResults(array("token"=>$token->getToken(),"validity"=>$token->getValidity()));
        }
      }catch(InvalidRequestException $e){
        $output->setErrors($e->getMessage());
      }catch(InvalidUserException $e){
        $output->setErrors($e->getMessage());
      }catch(Exception $e){
        $output->setErrors($e->getMessage());
      }finally{
        $output->send($request->getFormat());
      }
    }
);

$app->notFound(function(){
  $output = new OutputHelper();
  $output->setErrors("ROUTE_NOT_FOUND");
  $output->send($request->getFormat());
});

$app->handle();
