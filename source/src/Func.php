<?php
class Func{
    static function accesso($email,$pass){
        $pass=hash("sha256",$pass);
        $sql = DB::conn()->prepare( "SELECT email, nome FROM accesso WHERE email=? AND pass=?");
        $sql->bind_param("ss", $email, $pass);
        $sql->execute();
        $result = $sql->get_result();
        while ($obj = $result->fetch_object()) {
            $_SESSION['nome'] = $obj->nome;
        }
        if ($result->num_rows > 0) {
            $token=bin2hex(random_bytes(48));
            $sql = DB::conn()->prepare( "INSERT INTO token (email, token)
            VALUES (?, ?)");
            $sql->bind_param("ss", $email, $token);
            $sql->execute();
            setcookie("ciao", $token, time()+ (86400*30), "/");
            $_SESSION['email']=$email;
            return true;
        } else {
            return false;
        }
    }
    static function registrati($nome, $cognome, $email, $pass){
        $pass=hash("sha256",$pass);
        $bool=true;
        if ($cognome != "" && $nome != "" && $email != "" && $pass != "") {
            $sql = DB::conn()->prepare( "SELECT * FROM accesso");
            $sql->execute();
            $result = $sql->get_result();
            while ($obj = $result->fetch_object()) {
                if($obj->email==$email){
                    $bool = false;
                }
            }
            if($bool){
                $sql = DB::conn()->prepare("INSERT INTO accesso (email, nome, cognome, pass) 
                VALUES (?, ?, ?, ?)");
                $sql->bind_param("ssss", $email, $nome, $cognome, $pass);
                $sql->execute();
                $result = $sql->get_result();
                return 1;
            }else{
                return 2;
            }
        } else {
            return 3;
        }
    }
    function aggiungi($email,$titolo,$artista,$feat,$genere,$durata) {
        if($titolo!="" && $artista!= "" && $genere!= "" && $durata!=""){
        $bool=true;
        $sql = DB::conn()->prepare( "SELECT * FROM canzone WHERE email=? ");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        while ($obj = $result->fetch_object()) {
            if($obj->titolo==$titolo && $obj->artista==$artista){
            $bool = false;
            }
        }
        if($bool){
            $sql = "SELECT * FROM canzone where email='$email'";
            $sql = DB::conn()->prepare( "INSERT INTO canzone (titolo, artista, feat, genere, durata, email) 
            VALUES ( ?, ?, ?,
            ?, ?, ?)");
            $sql->bind_param("ssssss", $titolo, $artista, $feat, $genere, $durata, $email);
            $sql->execute();
            $result = $sql->get_result();
            return 1;
        }else{
            return 2;
            echo '<p>la canzone inserita esiste gia nella lista</p>';
        }
        }else{
        echo '"<p>Inserisci tutti i dati</p>"';
        }
    }
    function cancella() {
        global $conn;
        $titolo = ucwords($_POST['titolo']);
        $artista = ucwords($_POST['artista']);
        $email =$_SESSION['email'];
        $bool = false;

        $sql = $conn->prepare( "SELECT * FROM canzone WHERE email=? ");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        while ($obj = $result->fetch_object()) {
        if($obj->titolo==$titolo && $obj->artista==$artista){
            $bool = true;
        }
        }
        if($bool){
        $sql = $conn->prepare( "DELETE FROM canzone WHERE titolo=? and artista=?");
        $sql->bind_param("ss", $titolo, $artista);
        $sql->execute();
        $result = $sql->get_result();
        echo "<p>canzone cancellata</p>";
        }else{
        echo "<p>nessuna canzone trovata</p>";
        }
    }
    function stamp(){
        global $conn;
        $email =$_SESSION['email'];
        $sql = $conn->prepare( "SELECT * FROM canzone WHERE email=?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
        echo '<table>
                <thead>
                <tr><th>Titolo</th><th>Artista</th><th>Featuring</th><th>Genere</th><th>Durata</th></tr>
                <thead><tbody>';
        while ($obj = $result->fetch_object()) {
            echo "
            <tr>
            <td><a href='https://www.google.com/search?q=$obj->titolo+$obj->artista' target='_blank'> $obj->titolo</a></td>
            <td><a href='https://it.wikipedia.org/wiki/$obj->artista' target='_blank'> $obj->artista </a></td>
            ";
            if($obj->feat==""){
            echo "<td>XXXXX</td>";
            }
            else{
            echo "<td><a href='https://it.wikipedia.org/wiki/$obj->feat' target='_blank'> $obj->feat </a></td>";
            }
            echo "
            <td>$obj->genere</td>
            <td>$obj->durata</td>
            </tr>";
        }
        echo '</tbody></table>';
        }
    }
    function modifica() {
        if($_POST['titolo']!="" && $_POST['artista'] != ""){
        global $conn;
        $titolo = ucwords($_POST['titolo']);
        $artista = ucwords($_POST['artista']);
        $sql = $conn->prepare( "SELECT * FROM canzone WHERE titolo=? and artista=?");
        $sql->bind_param("ss", $titolo, $artista);
        $sql->execute();
        $result = $sql->get_result();
        while ($obj = $result->fetch_object()) {
            $feat= $obj->feat;
            $genere= $obj->genere;
            $durata= $obj->durata;
        }
        if ($result->num_rows > 0) {
            echo "
            <script>
            titolo.value = '$titolo'
            artista.value = '$artista'
            feat.value = '$feat'
            document.getElementById('$genere').selected = true;
            durata.value = '$durata'
            document.getElementById('titolo').readOnly = true;
            document.getElementById('artista').readOnly = true;
            let sparisci = document.getElementById('sparisci')
            let sparisci2 = document.getElementById('sparisci2')
            let sparisci3 = document.getElementById('sparisci3')
            let sparisci4 = document.getElementById('sparisci4')
            let out = document.getElementById('out')
            sparisci2.innerHTML=' '
            sparisci3.innerHTML=' '
            sparisci4.innerHTML=' '
            out.innerHTML=\"<button type='submit' name='conferma'>conferma</button><a> </a><button type='submit' name='annulla'>annulla</button>\"
            </script>";
        } else {
            echo "la canzone non esiste";
        }
        }else{
        echo "<p>Riempire i campi Titolo e Artista</p>";
    
    }
    function conferma() {
        global $conn;
        if($_POST['genere'] != "" && $_POST['durata']!=""){
        $titolo = ucwords($_POST['titolo']);
        $artista = ucwords($_POST['artista']);
        $feat = ucwords($_POST['feat']);
        $genere = $_POST['genere'];
        $durata = $_POST['durata'];
        $email =$_SESSION['email'];
        $sql = $conn->prepare( "UPDATE canzone SET genere=?, durata=?, feat=? WHERE titolo=? && artista=? && email=?");
        $sql->bind_param("ssssss", $genere, $durata, $feat, $titolo, $artista, $email);
        $sql->execute();
        $result = $sql->get_result();
        echo '<p>canzone modificata</p>';
        }
    }
}
}