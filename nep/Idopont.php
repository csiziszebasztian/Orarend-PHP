<?php
    declare(strict_types=1);

    namespace nep;
    
    class Idopont {
        private $id;
        private $dateTime;
        private $text;
        private $file;

        public function getID() : int {
            return $this->id;
        }
        
        public function getDateTime() : string {
            return $this->dateTime;
        }

        public function getText() : string {
            return $this->text;
        }

        public function getFile() : string {
            return $this->file;
        }
    

        public function setDateTime(string $dateTime) {
            $this->dateTime = $dateTime;
        }

        public function setText(string $text) {
            $this->text = $text;
        }

        public function setFile(string $file) {
            $this->file = $file;
        }


        
        public function __construct(string $dateTime, string $text=null, string $file=null, int $id = null) 
        {
            if (is_numeric($id)) {
                $this->id = $id ;
                $this->betolt() ;
            }
            else
            {
                $this->dateTime=$dateTime;
                $this->text = $text;
                $this->file = $file;
            }
        }

        private function betolt() {
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            if ($query = $mysqli->prepare("select idopont, leiras, csatolmany from idopontok where id = ?")) {       
                $query->bind_param("i", $this->id);
                $query->execute() ;
                $query->store_result();
                if($query->num_rows > 0) {
                    $query->bind_result($this->idopont, );
                    $query->fetch();
                }
                else
                {
                    throw new \Exception("Nem található időpont az adatbázisban ezzel az azonosítóval.");
                }
                $query->close() ;
            }
            else
            {
                throw new \Exception("Nem sikerült létrehozni az SQL kifejezést. ");
            }
        }

        public function mentes(int $tanarID) {
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            if (isset($this->id)) {
                $sql = "update idopontok set idopont = ?, tanar_id=? , leiras = ?,  csatolmany=? where id = ?" ;
                if ($query = $mysqli->prepare($sql)) {
                    $query->bind_param("sissi", $this->dateTime, $tanarID, $this->text, $this->file, $this->id);
                    if(!$query->execute()) {
                        throw new \Exception("Időpont adatok frissítése sikertelen.");
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
                if ($query = $mysqli->prepare("insert into idopontok (idopont, tanar_id, leiras, csatolmany) values (?, ?, ?, ?)")) {
                    $query->bind_param("siss", $this->dateTime, $tanarID,$this->text, $this->file);
                    if(!$query->execute()  || $query->affected_rows == 0) {
                        throw new \Exception("Időpont felvétele sikertelen.");
                    }
                    $query->close() ;
                }
                else
                {
                    throw new \Exception("Nem sikerült létrehozni az SQL kifejezést.");
                }
            }
        }
        

        public function torles() {
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 
            if (isset($this->id)) {
                    if ($query = $mysqli->prepare("delete from idopontok where id = ?")) {    
                        $query->bind_param("i", $this->id);
                        if(!$query->execute()  || $query->affected_rows == 0) {
                            throw new \Exception("Időpont törlése sikertelen.");
                        }
                        $query->close() ;
                    }
                
            }
            else
            {
                throw new \Exception("Nincs megadva időpont azonosító.");
            }

        }
                
        public function __toString() : string {
            $str = "<pre>Időpont: ".$this->dateTime.
                   "\nLeírás: ". $this->text.
                   "\nCsatolmány: ". $this->file;
            $str .= "</pre>\n";
            return $str;
        }

        public static function IdopontokListaja(int $tanarID) {
            $return = array() ;
            $db = \MySqliDB::getInstance();
            $mysqli = $db->getConnection(); 

            if ($result = $mysqli->query("select idopont, csatolmany, leiras from idopontok where id=". $tanarID. " order by idopont")) {
                while ($sor = $result->fetch_assoc()) {
                    $return[] = $sor ;
                }
                $result->close() ;
            }
            return $return;
        }
}