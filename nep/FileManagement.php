<?php
declare(strict_types=1);

namespace nep;

define("MUNKAKONYVTAR", getcwd() . "/") ;
define("ALAP_URL", "HTTP://" . $_SERVER["HTTP_HOST"] . "/SZE-PHP/Orarend-PHP/") ;
define("U_MAPPA", MUNKAKONYVTAR . "uploads/");
define("U_MAPPA_LETOLT", ALAP_URL . "uploads/");

class FileManagement {


    public static function feltolt(int $userID, array $files) {
        if (!empty($files)) {
          $filename = $files['name'];
          $extension = pathinfo($filename, PATHINFO_EXTENSION);
      
          $destination = U_MAPPA . $filename;
          $file = $files['tmp_name'];
          $size = $files['size'];
      
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

    public static function letolt(string $fileName){
        
            $filepath = U_MAPPA . $fileName ;
        
            if (file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . basename($filepath));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));
                readfile($filepath);
                exit;
            }
            else {
                throw new \Exception("Fájl nem található vagy nem olvasható.");
            }
        
        }
    
}

?>