<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class Controller_Post
{
    function postLogin(Request $request, Response $response, $args) {
        $email = $request->getParsedBody()['email'];
        $pass = $request->getParsedBody()['pass'];
        if(isset($request->getParsedBody()['login'])){
            if(Func::accesso($email, $pass)){
                return $response
                ->withHeader('Location', 'http://www.localhost:81/Playlist')
                ->withStatus(302);
            }
            else{
                return $response
                ->withHeader('Location', 'http://www.localhost:81/?error=1')
                ->withStatus(302);
            }
            return $response;
        }
        else{
            return $response
            ->withHeader('Location', 'http://www.localhost:81/Signin')
            ->withStatus(302);
        }
    }
    function postSignin(Request $request, Response $response, $args) {
        $nome = $request->getParsedBody()['nome'];
        $cognome = $request->getParsedBody()['cognome'];
        $email = $request->getParsedBody()['email'];
        $pass = $request->getParsedBody()['pass'];
        if(isset($request->getParsedBody()['signin'])){
            if(Func::registrati($nome, $cognome ,$email, $pass)==1){
                return $response
                ->withHeader('Location', 'http://www.localhost:81')
                ->withStatus(302);
            }else if(Func::registrati($nome, $cognome ,$email, $pass)==2){
                return $response
                ->withHeader('Location', 'http://www.localhost:81/Signin?error=1')
                ->withStatus(302);
            }else{
                return $response
                ->withHeader('Location', 'http://www.localhost:81/Signin?error2=1')
                ->withStatus(302);
            }
        }
        else{
            return $response
            ->withHeader('Location', 'http://www.localhost:81')
            ->withStatus(302);
        }
    }
    function postPlaylist(Request $request, Response $response, $args) {
        $email=$_SESSION['email'];
        $titolo = ucwords($request->getParsedBody()['titolo']);
        $artista = ucwords($request->getParsedBody()['artista']);
        $feat = ucwords($request->getParsedBody()['titolo']);
        $genere = $request->getParsedBody()['artista'];
        $durata = $request->getParsedBody()['durata'];
        if(isset($request->getParsedBody()['aggiungi'])){
            if(Func::aggiungi($email, $titolo, $artista, $feat, $genere, $durata)==1){
                return $response
                ->withHeader('Location', 'http://www.localhost:81/Playlist?error=1')
                ->withStatus(302);
            }
            else if(Func::aggiungi($email, $titolo, $artista, $feat, $genere, $durata)==2){
                return $response
                ->withHeader('Location', 'http://www.localhost:81/Playlist?error2=1')
                ->withStatus(302);
            }
            return $response;
        }
        else{
            return $response
            ->withHeader('Location', 'http://www.localhost:81/Signin')
            ->withStatus(302);
        }
    }
}