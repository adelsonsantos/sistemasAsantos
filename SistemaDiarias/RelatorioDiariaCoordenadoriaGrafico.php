<?php
include "../Include/Inc_Configuracao.php";
//Include the code
include "../graficos/classes/phplot.php";

$tipoRelatorio   = $_GET['tipoRelatorio'];
$idCoordenadoria = $_GET['comboCoordenadoria'];
$dsLocal         = $_GET['local'];
$dataInicio      = $_GET['txtDataInicio'];
$dataFim         = $_GET['txtDataFim'];
$idDiretoria     = $_GET['comboDiretoria'];
$dsDiretoria     = $_GET['dsDiretoria'];
$idProjeto       = $_GET['comboProjeto'];
$idFonte         = $_GET['comboFonte'];
$comboStatus     = $_GET['comboStatus'];
$idEtapa         = $_GET['cmbEtapa'];
$desEtapa        = $_GET['desEtapa'];

if($idDiretoria == '0')
{
    $idDiretoria = '';
}
else
{
    $where  .= " AND est.est_organizacional_id =".$idDiretoria." ";
    $filtro .= '  Diretoria: '.$dsDiretoria.'  ';
}

if(($idProjeto != '')&&($idProjeto != 0))
{
    $where .= " AND d.projeto_cd = ".$idProjeto." ";
    $filtro.= '  Projeto: '.$idProjeto.'  ';
}

if(($idFonte != '')&&($idFonte != '0'))
{
    $where  .= " AND d.fonte_cd = '".$idFonte."' ";
    $filtro .= '  Fonte: '.$idFonte.'  ';
}

if(($idEtapa != '')&&($idEtapa != 0))
{
    $where  .= " AND d.etapa_id = '".$idEtapa."' ";
    $filtro .= '  Etapa: '.$desEtapa.'  ';
}

if(($comboStatus == 0)||($comboStatus == 1))
{
    $where .= " AND (d.diaria_st > 2 AND d.diaria_st < 100)";
    $filtro.= utf8_decode('  Situação: Empenhadas  ');
}
elseif($comboStatus == 2)
{
    $where .= " AND (d.diaria_excluida = 0)";
    $filtro.= utf8_decode('  Situação: Solicitadas  ');
}
elseif($comboStatus == 3)
{
    $where .= " AND (d.diaria_st > 0 AND d.diaria_st < 3)";
    $filtro.= utf8_decode('  Situação: Autorizadas  ');
}

//Define the object
$plot = new PHPlot();

$sqlConsultaDados = "SELECT d.id_coordenadoria,nome,d.diaria_valor,d.diaria_dt_criacao 
                       FROM diaria.diaria d 
                       JOIN dados_unico.est_organizacional est ON est.est_organizacional_id = diaria_unidade_custo 
                       JOIN diaria.projeto pr ON pr.projeto_cd = d.projeto_cd 
                       JOIN diaria.fonte f ON f.fonte_cd = d.fonte_cd 
                  LEFT JOIN diaria.coordenadoria c ON d.id_coordenadoria = c.id_coordenadoria 
                      WHERE d.diaria_excluida = 0 AND (d.diaria_excluida = 0) 
                      ".$where."
                        AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN TO_DATE('".$dataInicio."', 'DD/MM/YYYY') AND TO_DATE('".$dataFim."', 'DD/MM/YYYY'))
                   ORDER BY id_coordenadoria,diaria_dt_criacao, nome, diaria_valor";
$rsConsulta = pg_query(abreConexao(),$sqlConsultaDados);
$numeroLinhas     = pg_num_rows($rsConsulta);		
(string)$linhaOld = 'null';    
$grupo            = '';  
$valor            = '';

for ($i = 0; $i < $numeroLinhas; $i++)
{             
    $linhaConsulta = pg_fetch_array($rsConsulta,$i);                         

    if((string)$linhaOld === (string)'null')
    {
        $linhaOld = $linhaConsulta['id_coordenadoria'];
        $valor    = trim($linhaConsulta['diaria_valor']);
    }
    elseif($linhaOld == $linhaConsulta['id_coordenadoria'])
    {                   
        $valor = $valor + trim($linhaConsulta['diaria_valor']);

        if($linhaConsulta['nome'] == null)
        {
            $grupo = 'Sede';
        }
        else
        {
            $grupo = $linhaConsulta['nome'];
        }    

        $array = array("nome" => $grupo,"valor" => $valor);                                                                  
    }
    else
    { 
        $coordenadoria[$linhaOld] = $array;           
        $array      = null;
        $linhaOld   = $linhaConsulta['id_coordenadoria'];
        $valor      = $linhaConsulta['diaria_valor'];
        $grupo      = $linhaConsulta['nome']; 
        $array = array("nome" => $grupo,"valor" => $valor);
    }   

    if($i == ($numeroLinhas-1))
    {                
        $coordenadoria[$linhaOld] = $array;                
    }
}                      
$sqlCoordenadorias  = "SELECT * FROM diaria.coordenadoria ORDER BY nome";
$rsCoordenadorias   = pg_query(abreConexao(),$sqlCoordenadorias);							 
$coordenadorias     = pg_num_rows($rsCoordenadorias);        
$total_todos        = 0;

$data = array();

for($i = 0; $i <= $coordenadorias; $i++)
{ 
    $data[] = array(utf8_decode($coordenadoria[$i]["nome"]),$coordenadoria[$i]["valor"]);
    $total_todos = $total_todos + $coordenadoria[$i]["valor"];
//    if($coordenadoria[$i]["nome"] == 'Sede')
//    {
//        $pdf->SetFont ("Times", "",8); 
//        $pdf->Cell (160,5, utf8_decode($coordenadoria[$i]["nome"]),1,0);
//        $pdf->Cell (30,5,'R$ '.number_format($coordenadoria[$i]["valor"],2,',','.'),1,1);
//        $total_todos = $total_todos + $coordenadoria[$i]["valor"];
//    }
//    elseif(($coordenadoria[$i]["nome"] != 'Sede')&&($coordenadoria[$i]["nome"] != ''))
//    {
//        $pdf->SetFont ("Times", "",8); 
//        $pdf->Cell (160,5, utf8_decode($coordenadoria[$i]["nome"]),1,0);
//        $pdf->Cell (30,5,'R$ '.number_format($coordenadoria[$i]["valor"],2,',','.'),1,1);
//        $total_todos = $total_todos + $coordenadoria[$i]["valor"];
//    }
}


//while($ver = pg_fetch_array($rsConsulta))
//{
//    $data[] = array($ver['nome'],$ver['diaria_valor']);
//}

$plot->SetTitleColor('blue');
$plot->SetTitle(utf8_decode("Valor total de diárias para o ano 2014 R$ ".number_format($total_todos,2,',','.')));

$plot->SetImageBorderType('plain');

//$plot->SetBackgroundColor('YellowGreen');

$plot->SetPlotType('pie');

$plot->SetDataType('text-data-single');

$plot->SetDataValues($data);
//$plot->SetXTickPos('none');
//$plot->SetPlotAreaWorld(NULL, 0);
//$plot->SetYTickIncrement(100);
//$plot->SetYDataLabelPos('plotin');
//$plot->SetLegendWorld(0, 0);
foreach ($data as $row) $plot->SetLegend($row[0]); // Copy labels to legend

$plot->DrawGraph();
?>
