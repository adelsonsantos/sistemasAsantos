<?php
include "../../Include/Inc_Configuracao.php";

$codigo = $_POST['pessoa_id'];

$sqlConsultaBloqueio = "SELECT * FROM diaria.diaria_bloqueio
                        WHERE pessoa_id = ".$codigo;
$rsConsultaBloqueio  = pg_query(abreConexao(),$sqlConsultaBloqueio);                   
$linhaConsultaBloqueio = pg_fetch_assoc($rsConsultaBloqueio);

if($linhaConsultaBloqueio != '')
{
    $sqlDeleta = "DELETE FROM diaria.diaria_bloqueio
                   WHERE pessoa_id = ".$codigo;
    pg_query(abreConexao(),$sqlDeleta); 
    
    $bloqueio = "$(#'$codigo').attr('value': 'Liberado','style': 'color: #065387')";
}
else
{
    $sqlInsere = "INSERT INTO diaria.diaria_bloqueio
                    (bloqueio_tipo,
                     bloqueio_data,
                     pessoa_id)
                  VALUES
                    (1,
                     '".date('d/m/Y')."',
                     $codigo)";
    pg_query(abreConexao(),$sqlInsere); 
    
    $bloqueio = "$(#'$codigo').attr('value': 'Bloqueado','style': 'color: #ff0000')";    
}

echo $bloqueio;
?>
