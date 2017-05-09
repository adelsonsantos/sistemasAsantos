<?php
//na pagina SolicitacaoFinanceiraInicio.asp existe uma regra dos contadores para implementacao local para visualizacao
//var_dump($linhaDiaria['diaria_dt_chegada']);exit;

If (!$linhaDiaria['diaria_numero'])
{
    $sqlBloqueio = "SELECT diaria_id, diaria_dt_chegada, diaria_st, diaria_numero,diaria_comprovada 
                      FROM diaria.diaria 
                     WHERE  ((diaria_st >=3 ) AND (diaria_st < 6)) 
                       AND diaria_excluida = 0 
                       AND (diaria_beneficiario = ".$linhaDiaria['diaria_beneficiario']." )";
}
else
{	
    $sqlBloqueio = "SELECT diaria_id, diaria_dt_chegada, diaria_st, diaria_numero,diaria_comprovada 
                      FROM diaria.diaria 
                     WHERE  ((diaria_st >=3 ) AND (diaria_st < 6)) 
                       AND diaria_excluida = 0 
                       AND diaria_numero <> '".$linhaDiaria['diaria_numero']."' 
                       AND (diaria_beneficiario = ".$linhaDiaria['diaria_beneficiario']." )" ;
}

$rsBloqueio           = pg_query(abreConexao(),$sqlBloqueio);
$ContadorAtraso       = 0;
$ContadorVirtual      = 0;
$PossuiBloqueio       = 0;
$NumeroDiariaVirtual  = "";
$NumeroDiariaAtrasada = "";


While($linhaBloqueio = pg_fetch_assoc($rsBloqueio))
{
    //Diaria Pendente de Documentação.
    If ($linhaBloqueio['diaria_comprovada'] == "1")// diaria comprovada, mas nao autorizada nem aprovada
    {	
        $ContadorVirtual     = $ContadorVirtual + 1;
        $NumeroDiariaVirtual = $NumeroDiariaVirtual." (".$linhaBloqueio['diaria_numero'].") ";
    }
    Else
    {	
        $dataBanco          = $linhaBloqueio['diaria_dt_chegada'];
        $dataBanco          = explode("-", $dataBanco);
        //A função mktime recebe os argumentos (hora, minuto, segundos, mes, dia, ano).
        $diaBanco           = mktime(0,0,0,$dataBanco[1],$dataBanco[0],$dataBanco[2]);
        $dataAtual          = date("Y-m-d");
        $dataAtual          = explode("-", $dataAtual);
        $diaAtual           = mktime(0,0,0,$dataAtual[1],$dataAtual[0],$dataAtual[2]);
        $diferencaDataTempo = ($diaAtual-$diaBanco);
        //converte o tempo em dias
        $DiferencaDias      = round(($diferencaDataTempo/60/60/24));

        If ($DiferencaDias > 5)
        {
            $ContadorAtraso       = $ContadorAtraso + 1;
            $NumeroDiariaAtrasada = $NumeroDiariaAtrasada." (".$linhaBloqueio['diaria_numero'].") ";
        }
    }
}

If (($ContadorVirtual > 1)OR($ContadorAtraso > 1))
{
    $PossuiBloqueio = 1;
}
?>
