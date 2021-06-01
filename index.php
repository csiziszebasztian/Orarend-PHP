<?php
    ini_set('display_errors', 1);
    require_once("include/common_include.php") ;


    function tablazat() {
        $napok = ["Hétfő", "Kedd", "Szerda", "csütrötök", "Péntek", "Szombat", "Vasárnap"];
        echo "<table class=orarend>\n";
        echo "\t<tr><th>Óra</th>";
        foreach($napok as $nap) {
          echo "<th>$nap</th>";
        }
        echo "</tr>\n";
        for($ora=0; $ora<24; $ora++) {
          echo "\t<tr><th>$ora</th>";
          for($nap=0; $nap<7; $nap++) {
            echo "<td class=\"";
            /*if(($megnevezes=foglalt($ora, $perc))===false) {
              echo "szabad";
            } else {
              echo "foglalt\" title=\"$megnevezes";
            }*/
            echo "\"></td>";
          }
          echo "</tr>\n";
        }
        echo "</table>\n";
      }

?>


<!DOCTYPE html>
<html>
    <head>
        <title>
            Órarend alkalmazás :: Órarend
        </title>
        <meta charset="utf-8" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/orarend.js"></script>      
        <link rel='stylesheet' href="style/stilus.css" type='text/css' media='all' />     

        <!-- A részletes oldalt megjelenítő modal ablakhoz az alábbi két sor -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> 
    </head>
<body>
<?php
    require_once("include/menu_include.php") ;
    tablazat();    
?>
    
</body>
</html>