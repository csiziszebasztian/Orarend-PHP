
<?php

declare(strict_types=1);

define("MUNKAKONYVTAR", getcwd() . "/") ;
define("ALAP_URL", "HTTP://" . $_SERVER["HTTP_HOST"] . "/SZE-PHP/Orarend-PHP/") ;
define("U_MAPPA", MUNKAKONYVTAR . "uploads/");
define("U_MAPPA_LETOLT", ALAP_URL . "uploads/");


namespace nep;


class FileManagement {


    public static function feltolt($userID) {
        if (!empty($_FILES['csatolmany'])) {
          $filename = $_FILES['csatolmany']['name'];
          $extension = pathinfo($filename, PATHINFO_EXTENSION);
      
          $destination = U_MAPPA . $userID . $filename;
          $file = $_FILES['csatolmany']['tmp_name'];
          $size = $_FILES['csatolmany']['size'];
      
          if (!in_array($extension, ['zip', 'pdf', 'docx', 'text'])) {
              throw new \Exception("A fájl típusa csak zip pdf docx és text lehet.");
          } 
          else if ($size > 1000000) { 
              throw new \Exception("Fájl mérete túl nagy.");
          } 
          else if (!move_uploaded_file($file, $destination)){
              throw new \Exception("Nem sikeres a fájl mentése");
          }
      }
    }
  
    public static function torles(string $fileName) {
        if(!unlink(U_MAPPA . $fileName))
        throw new \Exception("Nem lehet törölni a fájlt");
    }

    public static function tanarTorles($tanarID){
        $files = scandir(U_MAPPA);
        foreach($files as $file){
            if($file[0] === $tanarID)
             FileManagement::torles($file);
        }
    }

    public static function letolt($fileName){

    }


}

?>