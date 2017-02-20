<?php

class UserAuthenticationFactory{
  
  static function getByRequest(RequestHandler $request){
    $user = false;

    if ($request->getType() == RequestHandler::PLAIN)
        $user = Users::getUser($request->getUser(),$request->getPassword());
    if ($request->getType() == RequestHandler::TOKEN){
        $token = Token::findFirstByToken($request->getToken());
        if ($token)
          if ($token->isValid())
            $user = Users::getUser(null,null,$token->getUserId());
    }

    if (!$user)
      throw new InvalidUserException();

    return $user;
  }
}
