$(document).ready(function() {
  $("#tipus_select").on("change", function() {
    $(".plusz_mezok").hide() ;
    switch ($(this).val()) {
      case 'tankönyv': $(".tankonyv_mezok").show();
        break ;
      case 'magazin': $(".magazin_mezok").show();
        break ;
    }
  }) ;
  
  $(document).on("click", ".felhasznalo_modosit_gomb", function() {
    var modositas_id = $(this).attr("id") ;
    modositas_id = modositas_id.substring(modositas_id.indexOf("_") + 1) ;
    $.ajax({
      method: "POST",
      url: "users.php",
      data: { id: modositas_id, felhasznalo_kereses: 1 },
      dataType: "json"
    })
    .done(function(valasz) {
      $("#felhasznalo_modositas_id_hidden").val(modositas_id) ;
      $("#felhasznalo_modositas_nev_input").val(valasz[0].nev) ;
      $("#felhasznalo_modositas_email_input").val(valasz[0].email) ;
      $("#felhasznalo_modositas_jelszo_input").val("") ;
      $("#felhasznalo_modositas_jelszo_ismet_input").val("") ;
      $("#felhasznalo_modosito_urlap_befoglalo").show("slow") ;
    })
    .fail(function() {
      alert( "Sikertelen küldés" );
    })  
  }) ;

  $(document).on("click", ".felhasznalo_torol_gomb", function() {
    var torles_id = $(this).attr("id") ;
    torles_id = torles_id.substring(torles_id.indexOf("_") + 1) ;
    $.ajax({
      method: "POST",
      url: "users.php",
      data: { felhasznalo_id: torles_id, felhasznalo_torles: 1 },
    })
    .done(function(valasz) {
      if (valasz == "sikeres_torles") {
        $("#felhasznalo_valaszuzenet").addClass("sikeruzenet").html("Sikeres törlés").show( "slow" ).delay( 3000 ).fadeOut().removeClass(function() {
          $("#felhasznalo_valaszuzenet").removeClass("sikeruzenet").html();          
          $("#felhasznalo_modosito_urlap_befoglalo").delay( 3000 ).hide("slow") ; 
        }) ;
        felhasznalo_kereses() ;
      }
      else
      {
        $("#felhasznalo_valaszuzenet").addClass("hibauzenet").html(valasz).show( "slow" );
      }
    })
    .fail(function() {
      $("#felhasznalo_valaszuzenet").addClass("hibauzenet").html("Sikertelen küldés").show( "slow" );
    })
  }) ;

  $(document).on("click", ".kiadvany_modosit_gomb", function() {
    var modositas_id = $(this).attr("id") ;
    modositas_id = modositas_id.substring(modositas_id.indexOf("_") + 1) ;
    $.ajax({
      method: "POST",
      url: "index.php",
      data: { id: modositas_id, kiadvany_kereses: 1 },
      dataType: "json"
    })
    .done(function(valasz) {
      $("#kiadvany_felvetel_hidden").val("") ;
      $("#kiadvany_modositas_hidden").val("1") ;  
      $("#kiadvany_id_hidden").val(modositas_id) ;
      $("#cim_input").val(valasz[0].cim) ;
      $("#tipus_select").val(valasz[0].tipus) ;
      $("#tipus_select").attr('disabled', 'disabled');
      switch (valasz[0].tipus) {
        case 'tankönyv': 
          $(".tankonyv_mezok").show();
          $(".magazin_mezok").hide();
        break ;
        case 'magazin': 
          $(".magazin_mezok").show();
          $(".tankonyv_mezok").hide();
        break ;
        default:
          $(".tankonyv_mezok").hide();
          $(".magazin_mezok").hide();
        break ;
      }
      $("#ar_input").val(valasz[0].ar) ;
      $("#isbn_input").val(valasz[0].isbn) ;
      $("#szerzo_input").val(valasz[0].szerzo) ;
      $("#kulcsszavak_input").val(valasz[0].kulcsszavak) ;
      if (typeof valasz[0].tema != "undefined") {
        $("#tema_input").val(valasz[0].tema) ;  
      }
      if (typeof valasz[0].tema != "evfolyam") {
        $("#evfolyam_input").val(valasz[0].evfolyam) ;  
      }
      if (typeof valasz[0].szam != "undefined") {
        $("#szam_input").val(valasz[0].szam) ;  
      }
      $("#kiadvany_felveteli_urlap_befoglalo").show("slow") ;
    })
    .fail(function() {
      alert( "Sikertelen küldés" );
    })  
  }) ;

  $(document).on("click", ".kiadvany_torol_gomb", function() {
    var torles_id = $(this).attr("id") ;
    var tipus = $(this).data("tipus") ;
    torles_id = torles_id.substring(torles_id.indexOf("_") + 1) ;
    $.ajax({
      method: "POST",
      url: "index.php",
      data: { kiadvany_id: torles_id, kiadvany_tipus: tipus, kiadvany_torles: 1 },
    })
    .done(function(valasz) {
      if (valasz == "sikeres_torles") {
        $("#kiadvany_valaszuzenet").addClass("sikeruzenet").html("Sikeres törlés").show( "slow" ).delay( 3000 ).fadeOut().removeClass(function() {          
          $("#kiadvany_felveteli_urlap_befoglalo").delay( 3000 ).hide("slow") ; 
        }) ;
        kereses() ;
      }
      else
      {
        $("#kiadvany_valaszuzenet").addClass("hibauzenet").html(valasz).show( "slow" );
      }
    })
    .fail(function() {
      $("#kiadvany_valaszuzenet").addClass("hibauzenet").html("Sikertelen küldés").show( "slow" );
    })
    $("#kiadvany_valaszuzenet").removeClass("sikeruzenet").html();          
  }) ;


  $("#kiadvany_mentes_gomb").on("click", function() {
      $("#kiadvany_valaszuzenet").hide().removeClass("sikeruzenet").html() ;
      $('#tipus_select').removeAttr('disabled');  //A disabled form elemek nem kerülnek elküldésre a postolásnál, ezért előbb engedélyeznünk kell a mezőt
      $.ajax({
          method: "POST",
          url: "index.php",
          data: $('#kiadvany_felveteli_urlap').serialize()
      })
      .done(function(valasz) {
          if (valasz == "sikeres_mentes") {
            $("#kiadvany_valaszuzenet").addClass("sikeruzenet").html("Sikeres mentés").show( "slow" ).delay( 3000 ).fadeOut();
            $("#kiadvany_felveteli_urlap").trigger('reset') ;
            $("#kiadvany_felveteli_urlap_befoglalo").delay( 3000 ).hide("slow") ; 
            kereses() ;
          }
          else
          {
            $("#kiadvany_valaszuzenet").addClass("hibauzenet").html(valasz).show( "slow" );
          }
      })
      .fail(function() {
        $("#kiadvany_valaszuzenet").addClass("hibauzenet").html("Sikertelen küldés").show( "slow" );
      })
      $("#kiadvany_valaszuzenet").removeClass("sikeruzenet").html();
  }) ;

  $("#felhasznalo_mentes_gomb").on("click", function() {
    $("#felhasznalo_valaszuzenet").hide().removeClass("sikeruzenet").html() ;
    $.ajax({
        method: "POST",
        url: "users.php",
        data: $('#felhasznalo_felveteli_urlap').serialize()
    })
    .done(function(valasz) {
        if (valasz == "sikeres_mentes") {
          $("#felhasznalo_valaszuzenet").addClass("sikeruzenet").html("Sikeres mentés").show( "slow" ).delay( 3000 ).fadeOut();
          $("#felhasznalo_felveteli_urlap").trigger('reset') ;
          felhasznalo_kereses() ;
        }
        else
        {
          $("#felhasznalo_valaszuzenet").addClass("hibauzenet").html(valasz).show( "slow" );
        }
    })
    .fail(function() {
      $("#felhasznalo_valaszuzenet").addClass("hibauzenet").html("Sikertelen küldés").show( "slow" );
    })
    $("#felhasznalo_valaszuzenet").removeClass("sikeruzenet").html();
  }) ;

  $("#felhasznalo_modositas_mentes_gomb").on("click", function() {
    $("#felhasznalo_valaszuzenet").hide().removeClass("sikeruzenet").html() ;
    $.ajax({
        method: "POST",
        url: "users.php",
        data: $('#felhasznalo_modositas_urlap').serialize()
    })
    .done(function(valasz) {
        if (valasz == "sikeres_mentes") {
          $("#felhasznalo_modositas_urlap").trigger('reset') ;
          $("#felhasznalo_valaszuzenet").addClass("sikeruzenet").html("Sikeres mentés").show( "slow" ).delay( 3000 ).fadeOut().removeClass(function() {            
            $("#felhasznalo_modosito_urlap_befoglalo").delay( 3000 ).hide("slow") ; 
          }) ;
          felhasznalo_kereses() ;
        }
        else
        {
          $("#felhasznalo_valaszuzenet").addClass("hibauzenet").html(valasz).show( "slow" );
        }
    })
    .fail(function() {
      $("#felhasznalo_valaszuzenet").addClass("hibauzenet").html("Sikertelen küldés").show( "slow" );
    })
    $("#felhasznalo_valaszuzenet").removeClass("sikeruzenet").html();
  }) ;  

  $("#kereses_gomb").on("click", function() {
    kereses() ;
  }) ;
}) ;

function kiadvany_felvetele_urlap() {
  $("#tipus_select").attr('disabled', false);
  $(".tankonyv_mezok").hide();
  $(".magazin_mezok").hide();
  $("#kiadvany_felvetel_hidden").val("1") ;
  $("#kiadvany_modositas_hidden").val("") ;
  $("#kiadvany_felveteli_urlap_befoglalo").toggle() ;  
}

function kiadvany_keresese_urlap() {
  $("#kiadvany_kereso_urlap_befoglalo").toggle() ;
}

function kereses() {
  $.ajax({
    method: "POST",
    url: "index.php",
    data: $('#kiadvany_kereso_urlap').serialize()
  })
  .done(function(valasz) {
      $("#talalati_lista").html(valasz) ;
  })
  .fail(function() {
    alert( "Sikertelen küldés" );
  })
}

function felhasznalo_kereses() {
  $.ajax({
    method: "POST",
    url: "users.php",
    data: { felhasznalo_kereses: 1 },
    dataType: "json"
  })
  .done(function(valasz) {
    $("#felhasznalok_lista").html('<table><tr><th colspan="6">A rendszerbe felvett felhasználók</th></tr><tr><th>ID</th><th>Név</th><th>E-mail cím</th><th>&nbsp;</th><th>&nbsp;</th></tr>') ;
    $.each(valasz,function(index,felhasznalo){
      $("#felhasznalok_lista").find("table").append('<tr><td>' + felhasznalo.id + '</td><td>' + felhasznalo.nev + '</td><td>' + felhasznalo.email + '</td><td><input type="button" name="modosit" id="modosit_' + felhasznalo.id + '" class="felhasznalo_modosit_gomb" value="Módosítás"></td><td><input type="button" name="torol" id="torol_' + felhasznalo.id + '" class="felhasznalo_torol_gomb" value="Törlés"></td></tr>') ;
    })
  })
}