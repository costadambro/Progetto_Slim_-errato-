<?php
class FuncDati{
    static function token(){
        if(isset($_COOKIE['ciao'])){
            $token=$_COOKIE['ciao'];
            $sql = DB::conn()->prepare( "SELECT email FROM token WHERE token=?");
            $sql->bind_param("s", $token);
            $sql->execute();
            $result = $sql->get_result();
            while ($obj = $result->fetch_object()) {
                $email = $obj->email;
            }
            return false;
        }
        return true;
    }
}