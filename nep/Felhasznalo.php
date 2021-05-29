<?php
    declare(strict_types=1);

    namespace nep;
    
    class Felhasznalo {
        private $name;
        private $email;
        private $password;
        private $id;
        private $role;
        private $subject;
        private $color;
        
        public function getName() : string {
            return $this->name;
        }

        public function getEmail() : string {
            return $this->email;
        }

        public function getPassword() : string {
            return $this->password;
        }

        public function getID() : int {
            return $this->id;
        }

        public function getRole() : string {
            return $this->role;
        }

        public function getSubject() : string {
            return $this->subject;
        }

        public function getColor() : string {
            return $this->color;
        }

        public function setName(string $name) {
            $this->name = $name;
        }

        public function setEmail(string $email) {
            $this->email = $email;
        }

        public function setPassword(string $password) {
            $this->password = $password;
        }

        public function setRole(string $role) {
            $this->role = $role;
        }

        public function setSubject(string $subject) {
            $this->subject = $subject;
        }

        public function setColor(string $color) {
            $this->color = $color;
        }
        
        public function __construct(
            string $name, string $email, string $password, 
            string $role, string $subject=null, string $color=null,int $id = null) 
        {
            if (is_numeric($id)) {
                $this->id = $id ;
                $this->betolt() ;
            }
            else
            {
                $this->name = $name;
                $this->email = $email;
                $this->password = $password;
                $this->subject = $subject;
                $this->role = $role;
                $this->color = $color;
            }
        }

        private function betolt() {
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            if ($query = $mysqli->prepare("select nev, email, szerep, tantargy, szin from felhasznalok where id = ?")) {       
                $query->bind_param("i", $this->id);
                $query->execute() ;
                $query->store_result();
                if($query->num_rows > 0) {
                    $query->bind_result($this->name, $this->email, $this->role, $this->subject, $this->szin);
                    $query->fetch();
                }
                else
                {
                    throw new \Exception("Nem található felhasználó az adatbázisban ezzel az azonosítóval.");
                }
                $query->close() ;
            }
            else
            {
                throw new \Exception("Nem sikerült létrehozni az SQL kifejezést.");
            }
        }

        //Felhasználó adatok mentése
        public function mentes() {
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            //Ha ismert volt az ID, akkor update, ha nem, akkor insert
            if (isset($this->id)) {
                //Ha van megadva jelszó, akkor azt is módosítjuk, ha nem adtak meg, akkor ahhoz nem nyúlunk
                $jelszo_sql = "" ;
                if ($this->password != "") {
                    $jelszo_sql = ", jelszo = '" . password_hash($this->password, PASSWORD_DEFAULT) . "'" ;
                }
                $sql = "update felhasznalok set nev = ?, email = ? " . $jelszo_sql . " szerep=?, tantargy=?, szin=? where id = ?" ;
                if ($query = $mysqli->prepare($sql)) {
                    $query->bind_param("ssssi", $this->name, $this->email, $this->role, $this->subject, $this->color, $this->id);
                    if(!$query->execute()) {
                        throw new \Exception("Felhasználó adatok frissítése sikertelen.");
                    }
                    $query->close() ;
                }
                else
                {
                    throw new \Exception("Nem sikerült létrehozni az SQL kifejezést.");
                }
            }
            else
            {
                if ($query = $mysqli->prepare("insert into felhasznalok (nev, email, jelszo, szerep, tantargy, szin) values (?, ?, ?, ?, ?, ?)")) {
                    $jelszo_kodolt = password_hash($this->password, PASSWORD_DEFAULT) ;
                    $query->bind_param("ssssss", $this->name, $this->email, $jelszo_kodolt, $this->role, $this->subject, $this->color);
                    if(!$query->execute()  || $query->affected_rows == 0) {
                        throw new \Exception("Felhasználó felvétele sikertelen.");
                    }
                    $query->close() ;
                }
                else
                {
                    throw new \Exception("Nem sikerült létrehozni az SQL kifejezést.");
                }
            }
        }
        
        //Felhasználó törlése a rendszerből
        public function torles() {
            //Csak akkor futhat le, ha ID van benne, és a bejelentkezett felhasználó nem a törlendő felhasználó
            //Ha valamelyikkel gond van, hibaüzenetet küldeni róla
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            //Ha ismert volt az ID, akkor update, ha nem, akkor insert
            if (isset($this->id)) {
                if ($this->id != $_SESSION["belepett_user"]->getID()) {
                    if ($query = $mysqli->prepare("delete from felhasznalok where id = ?")) {    
                        $query->bind_param("i", $this->id);
                        if(!$query->execute()  || $query->affected_rows == 0) {
                            throw new \Exception("Felhasználó törlése sikertelen.");
                        }
                        $query->close() ;
                    }
                }
                else
                {
                    throw new \Exception("A felhasználó nem törölheti saját magát.");    
                }
            }
            else
            {
                throw new \Exception("Nincs megadva felhasználó azonosító.");
            }

        }
                
        public function __toString() : string {
            $str = "<pre>Name: ".$this->name.
                   "\nE-mail: ".$this->email.
                   "\nRole: ". $this->role. 
                   "\nSubject: ". $this->subject. 
                   "\nColor: ". $this->color;
            $str .= "</pre>\n";
            return $str;
        }

       
        public static function emailFoglaltsagEllenorzes(string $email, int $felhasznalo_id = null) {
            $return = false ;
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            $id_where = "" ;
            if (is_numeric($felhasznalo_id)) {
                $id_where = " and id != '" . $felhasznalo_id . "'";
            }
            if ($query = $mysqli->prepare("select id from felhasznalok where email = ?" . $id_where)) {       
                $query->bind_param("s", $email);
                $query->execute() ;
                $query->store_result();
                if($query->num_rows > 0)
                    $return = true ;
                $query->close() ;
            }
            else
            {
                throw new \Exception("Nem sikerült létrehozni az SQL kifejezést.");
            }
            return $return ;
        }

        //A rendszerbe felvett felhasználók listáját adja vissza
        public static function felhasznalokListaja(array $keresesi_opciok = null) {
            $return = array() ;
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            $where_query = "" ;
            if (is_array($keresesi_opciok)) {
                $where_query = "where 1 = 1 " ;                
                foreach ($keresesi_opciok as $opcio_name => $opcio_ertek) {                    
                    switch ($opcio_name) {
                        case "id": 
                            $where_query .= " and $opcio_name = $opcio_ertek " ;
                            break ;
                    }                    
                }
            }
            if ($result = $mysqli->query("select id, nev, email, szerep, tantargy, szin from felhasznalok " . $where_query . " order by nev")) {
                while ($sor = $result->fetch_assoc()) {
                    $return[] = $sor ;
                }
                $result->close() ;
            }
            return $return ;
        }

        //Belépteti az e-mail + jelszónak megfelelő felhasználót a rendszerbe
        //A visszatérési érték egy string, amely akkor üres, ha sikerült a beléptetés. Ha nem üres, akkor hibaüzenetet tartalmaz.
        public static function bejelentkezes($felhasznalo_email, $felhasznalo_jelszo) {
            $return = "" ;
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            if ($query = $mysqli->prepare("select id, nev, jelszo, szerep, tantargy, szin from felhasznalok where email = ?")) {
                $query->bind_param("s", $felhasznalo_email);
                $query->execute() ;
                $query->store_result();
                if($query->num_rows > 0) {                    
                    $query->bind_result($id, $name, $jelszo_hash, $role, $subject, $szin);
                    $query->fetch() ;
                    if (password_verify($felhasznalo_jelszo, $jelszo_hash)) {    
                        $user = new Felhasznalo($name, $felhasznalo_email, $felhasznalo_jelszo, $role, $subject, $szin, $id) ;
                        $_SESSION["belepett_user"] = $user ;
                        $return = "" ;
                    }
                    else
                    {
                        $return = "Nem stimmel a jelszó." ;
                    }
                }
                else
                {
                    $return = "Nincs felhasználó a rendszerben ezzel az e-mail címmel." ;
                }
                $query->close() ;
            }
            else
            {
                $return = "Nem sikerült létrehozni az SQL kifejezést." ;
            }
            return $return ;
        }

    }