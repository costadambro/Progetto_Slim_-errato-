<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class Controller_Get
{
    function getLogin(Request $request, Response $response, $args) {
        if(FuncDati::token()){
            $view = new View('pages/Login');
            $error=$request->getQueryParams()['error']??null;
            $view->setData(['error' => $error]);
            $response->getBody()->write($view->render());
            return $response->withStatus(200);
        }else{
            return $response
                ->withHeader('Location', 'http://www.localhost:81/Playlist')
                ->withStatus(302);
        }
    }
    function getSignin(Request $request, Response $response, $args) {
        $view = new View('pages/Signin');
        $error=$request->getQueryParams()['error']??null;
        $error2=$request->getQueryParams()['error2']??null;
        if(isset($error)){
            $view->setData(['error' => $error]);
        }else{
            $view->setData(['error2' => $error2]);
        }
        $response->getBody()->write($view->render());
        return $response->withStatus(200);
    }
    function getPlaylist(Request $request, Response $response, $args) {
        $view = new View('pages/Playlist');
        $error=$request->getQueryParams()['error']??null;
        $error2=$request->getQueryParams()['error2']??null;
        if(isset($error)){
            $view->setData(['error' => $error]);
        }else{
            $view->setData(['error2' => $error2]);
        }
        $response->getBody()->write($view->render());
        return $response->withStatus(200);
    }
}