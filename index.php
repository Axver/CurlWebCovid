<?php
header('Content-Type: application/json');

$nama=$_GET['nama'];

data($nama);

function data($nama)
{
  if($nama=="bekasi")
  {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://corona.bekasikota.go.id/");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      $output = curl_exec($ch);
      curl_close($ch);
      $terkonfirmasi=explode("<h4>TERKONFIRMASI</h4>",$output);
      $positif=explode('<div class="align-right">',$terkonfirmasi[1]);
      $positif=explode('<div class="row">',$positif[1]);
      $positif=explode('</div>',$positif[0]);
      $positif=explode(' ',$positif[0]);
      $array = array(
        "kab_kot" => "Bekasi",
        "positif" => $positif[48],
        "sembuh"=>'Kosong',
        "meninggal"=>'Kosong'
    );
    
    // Mencari data sembuh
    $sembuh=explode('<div class="align-right">',$terkonfirmasi[1]);
    $sembuh=explode('</div>',$sembuh[2]);
    $sembuh=explode(' ',$sembuh[0]);
    $array['sembuh']=$sembuh[48];
    // Mencari data meninggal
    $meninggal=explode('Total Meninggal  <strong>P+ :',$terkonfirmasi[1]);
    $meninggal=explode('</strong>',$meninggal[1]);
    $meninggal=explode(' ',$meninggal[0]);
    $array['meninggal']=$meninggal[1];
    echo json_encode($array);
  }
}

