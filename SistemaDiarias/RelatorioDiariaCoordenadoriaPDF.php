<?php
include "../Include/Inc_Configuracao.php";
//include "classe/ClasseRelatorioSaldoProjeto.php";
include "fpdf.php";
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

$filtro = 'FILTRO(s) ';
$where  = '';

if($tipoRelatorio == 'todas')
{
    $filtro .= '';
}
else
{
    $filtro .= '  Coordenadoria: '.utf8_decode($dsLocal).'  ';
}

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

$pdf = new FPDF();
$pdf->SetFont('Times','B',16);
$pdf->Open();
$pdf->AddPage();
$RelatorioTipo = "";

/*Cabeçalho
****************************************************************************************** 
 */
 
function Cabecalho(FPDF $pdf,$coordenadoria,$dataInicio,$dataFim,$filtro)
{
    $pdf->Cell (55,22,"",1,0,"C");
    $pdf->SETX (65);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,11,  utf8_decode("RELATÓRIO DIÁRIA "),1,1,"C");
    $pdf->SetFont ("Times", "",8);
    $pdf->Text (114, 20 ,"EMITIDO : " .date("d/m/Y")." ".date("H:i:s"));
    $pdf->SetFont ("Times", "B",8);
    $pdf->SETX (65);    
    $pdf->Cell(135, 6,utf8_decode("Diárias de  ".$dataInicio."  à  ".$dataFim),1,1,"C");
    $pdf->SETX (65);
    $pdf->Cell(135, 5,$filtro,1,1,"C");    
    $pdf->SetFont ("Times", "B",8);
    $pdf->image ("../Imagens/logo.jpg",14,16,40);
    $pdf->Cell (0,5,"",0,1);	
}

Cabecalho($pdf,$coordenadoria,$dataInicio,$dataFim,$filtro);
$contador = 1;
$pagina = 1;
$pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
$pdf->Text (196, 285 , $pagina);
$contatorReg = 45;

if($tipoRelatorio == "coordenadoria")
{     
    function cabecalhoCoord(FPDF $pdf)
    {
        $pdf->SetFont ("Times", "B",8);
        $pdf->Cell (34,5,"DIRETORIA",1,0,"C");
        $pdf->Cell (17,5,"SD",1,0,"C");
        $pdf->Cell (75,5,utf8_decode("BENEFICIÁRIO"),1,0);
        $pdf->Cell (17,5,utf8_decode("SAÍDA"),1,0,"C");
        $pdf->Cell (17,5,"CHEGADA",1,0,"C");        
        $pdf->Cell (10,5,"QTDE",1,0,"C");
        $pdf->Cell (20,5,"VALOR",1,1);   
        $pdf->SetFont ("Times", "",8);
    }
    
    function cabecalhoCoordResu(FPDF $pdf)
    {
        $pdf->SetFont ("Times", "B",8);
        $pdf->Cell (105,5,utf8_decode("BENEFICIÁRIO"),1,0);      
        $pdf->Cell (55,5,utf8_decode("PERÍODO ENTRE ÀS DIÁRIAS"),1,0,"C");        
        $pdf->Cell (30,5,"VALOR",1,1);   
        $pdf->SetFont ("Times", "",8);
    }        
    
    $sqlConsulta =   "SELECT 
                             p.pessoa_nm, 
                             p.pessoa_id, 
                             diaria_dt_saida, 
                             diaria_dt_chegada,
                             diaria_numero,
                             f.fonte_ds, 
                             projeto_ds, 
                             diaria_qtde, 
                             d.diaria_beneficiario, 
                             d.diaria_valor,
                             d.diaria_valor_ref,
                             nome, 
                             d.projeto_cd,
                             d.fonte_cd,
                             d.diaria_dt_criacao, 
                             est_organizacional_ds, 
                             est_organizacional_sigla,
                             d.etapa_id
                        FROM diaria.diaria d 
                        JOIN dados_unico.pessoa p 
                          ON p.pessoa_id = d.diaria_beneficiario 
                        JOIN dados_unico.est_organizacional est
                          ON est.est_organizacional_id = diaria_unidade_custo
                        JOIN diaria.projeto pr
                          ON pr.projeto_cd = d.projeto_cd
                        JOIN diaria.fonte f
                          ON f.fonte_cd = d.fonte_cd
                   LEFT JOIN diaria.coordenadoria c 
                          ON d.id_coordenadoria = c.id_coordenadoria
                       WHERE d.diaria_excluida = 0 
                         AND d.id_coordenadoria = ".$idCoordenadoria." 
                         ".$where."
                         AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN TO_DATE('$dataInicio', 'DD/MM/YYYY') AND TO_DATE('$dataFim', 'DD/MM/YYYY')) 
                    ORDER BY fonte_cd, TO_DATE(diaria_dt_saida, 'DD/MM/YYYY'), est_organizacional_ds, pessoa_nm, diaria_valor";	

    $rsConsulta   = pg_query(abreConexao(),$sqlConsulta);							 
    $numeroLinhas = pg_num_rows($rsConsulta);
    $valor        = 0;    
    $fonte_cd     = '';
    $valorAcao    = 0;
    
    if($numeroLinhas > 0)
    {        
        for ($i = 0; $i < $numeroLinhas; $i++)
        {             
            $linhaConsulta = pg_fetch_array($rsConsulta,$i,PGSQL_ASSOC);
            
            if(strlen(utf8_decode($linhaConsulta['pessoa_nm']))> 40)
            {
                $nome = substr(utf8_decode($linhaConsulta['pessoa_nm']), 0, 39).'...';
            }           
            else
            {
                $nome = utf8_decode($linhaConsulta['pessoa_nm']);
            }
            
            if(trim($fonte_cd) == '')
            {
                $pdf->SetFont ("Times", "B",8);
                $fonte_cd = trim($linhaConsulta['fonte_cd']);
                $fonte_ds = trim($linhaConsulta['fonte_ds']);
                $pdf->Cell (20,5,utf8_decode('FONTE:'),1,0,"L");                
                $pdf->Cell (170,5,$fonte_cd.' - '.$fonte_ds,1,1,"L");             
                cabecalhoCoord($pdf);
                $pdf->SetFont ("Times", "",8);
                $pdf->Cell (34,5,$linhaConsulta['est_organizacional_sigla'],1,0,"C");   
                $pdf->Cell (17,5,$linhaConsulta['diaria_numero'],1,0,"C");
                $pdf->Cell (75,5,$nome,1,0);
                $pdf->Cell (17,5,$linhaConsulta['diaria_dt_saida'],1,0,"C");
                $pdf->Cell (17,5,$linhaConsulta['diaria_dt_chegada'],1,0,"C");
                $pdf->Cell (10,5,$linhaConsulta['diaria_qtde'],1,0,"C");
                $pdf->Cell (20,5,'R$ '.number_format($linhaConsulta['diaria_valor'],2,',','.'),1,1);  
            }
            else if(trim($fonte_cd) == trim($linhaConsulta['fonte_cd']))
            {                              
                $pdf->Cell (34,5,$linhaConsulta['est_organizacional_sigla'],1,0,"C");   
                $pdf->Cell (17,5,$linhaConsulta['diaria_numero'],1,0,"C");
                $pdf->Cell (75,5,$nome,1,0);
                $pdf->Cell (17,5,$linhaConsulta['diaria_dt_saida'],1,0,"C");
                $pdf->Cell (17,5,$linhaConsulta['diaria_dt_chegada'],1,0,"C");
                $pdf->Cell (10,5,$linhaConsulta['diaria_qtde'],1,0,"C");
                $pdf->Cell (20,5,'R$ '.number_format($linhaConsulta['diaria_valor'],2,',','.'),1,1);                
            }
            else if(trim($fonte_cd) != trim($linhaConsulta['fonte_cd']))
            {
                $pdf->SetFont ("Times", "B",8);
                $pdf->Cell (160,5,'TOTAL:   ',1,0,"R"); 
                $pdf->Cell (30,5,'R$ '.number_format($valorFonte,2,',','.'),1,1,"L"); 
                $pdf->SetFont ("Times", "",8);
                $pdf->Cell (1,5,'',0,1,"C");
                $pdf->SetFont ("Times", "B",8);
                $fonte_cd = trim($linhaConsulta['fonte_cd']); 
                $fonte_ds = trim($linhaConsulta['fonte_ds']);
                $pdf->Cell (20,5,utf8_decode('FONTE:'),1,0,"L");                
                $pdf->Cell (170,5,$fonte_cd.' - '.$fonte_ds,1,1,"L");                
                cabecalhoCoord($pdf);
                $pdf->SetFont ("Times", "",8);
                $pdf->Cell (34,5,$linhaConsulta['est_organizacional_sigla'],1,0,"C"); 
                $pdf->Cell (17,5,$linhaConsulta['diaria_numero'],1,0,"C");
                $pdf->Cell (75,5,$nome,1,0);
                $pdf->Cell (17,5,$linhaConsulta['diaria_dt_saida'],1,0,"C");
                $pdf->Cell (17,5,$linhaConsulta['diaria_dt_chegada'],1,0,"C");
                $pdf->Cell (10,5,$linhaConsulta['diaria_qtde'],1,0,"C");
                $pdf->Cell (20,5,'R$ '.number_format($linhaConsulta['diaria_valor'],2,',','.'),1,1);  
                $valorFonte = 0;
            }         
            
            $valorFonte = $valorFonte + trim($linhaConsulta['diaria_valor']);            
            $valor      = $valor + trim($linhaConsulta['diaria_valor']);    
            
            if($idEtapa != '')
            {
                if($linhaConsulta['diaria_valor_ref'] == '83')
                {
                    $valorNivelMedio = $valorNivelMedio + trim($linhaConsulta['diaria_valor']);
                }
                elseif($linhaConsulta['diaria_valor_ref'] == '115')
                {
                    $valorNivelSuperior = $valorNivelSuperior + trim($linhaConsulta['diaria_valor']);
                }
            }
            
            $novaPagina = $pdf -> page;
            if($novaPagina > $pagina)
            {                                          
                $pdf->SetFont ("Times", "B",8);
                $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
                $pdf->Text (196, 285 , $novaPagina);   
                $pagina = $novaPagina;
                $pdf->SetFont ("Times", "",8);
            }
        }    
    }
    
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (160,5,'TOTAL:   ',1,0,"R"); 
    $pdf->Cell (30,5,'R$ '.number_format($valorFonte,2,',','.'),1,1,"L"); 
    $pdf->SetFont ("Times", "",8);
    $total = 'R$ '.number_format($valor,2,',','.');    
    
    if($linhaConsulta["nome"] == null)
    {
        $nome = 'SEDE';
    }
    else
    {
        $nome = strtoupper($linhaConsulta["nome"]);
    }
    $coordenadoria = $nome;	
        
    if(($idEtapa == '')||($idEtapa == 0))
    {
        $pdf->Cell (190,5,"",0,1);
        $pdf->SetFont ("Times", "B",8);
        $pdf->Cell (160,5,"COORDENADORIA",1,0);
        $pdf->Cell (30,5,"TOTAL",1,1);
        $pdf->SetFont ("Times", "",8);	
        $pdf->Cell (160,5,utf8_decode($coordenadoria),1,0);
        $pdf->Cell (30,5,$total,1,1);       
    }
    else
    {
        $totalNivelMedio = 'R$ '.number_format($valorNivelMedio,2,',','.');
        $totalNivelSuperior = 'R$ '.number_format($valorNivelSuperior,2,',','.');
        
        $pdf->Cell (190,5,"",0,1);
        $pdf->SetFont ("Times", "B",8);
        $pdf->Cell (80,5,"COORDENADORIA",1,0);
        $pdf->Cell (40,5,utf8_decode("NÍVEL MÉDIO"),1,0);
        $pdf->Cell (40,5,utf8_decode("NÍVEL SUPERIOR"),1,0);
        $pdf->Cell (30,5,"TOTAL",1,1);
        $pdf->SetFont ("Times", "",8);	
        $pdf->Cell (80,5,utf8_decode($coordenadoria),1,0);
        $pdf->Cell (40,5,$totalNivelMedio,1,0);
        $pdf->Cell (40,5,$totalNivelSuperior,1,0);
        $pdf->Cell (30,5,$total,1,1); 
    }
    
    $novaPagina = $pdf -> page;
    $pdf->SetFont ("Times", "B",8);
    $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
    $pdf->Text (196, 285 , $novaPagina);  
    
}
else if(($tipoRelatorio == 'todas')&&($idProjeto != 0))
{    
    $sqlCooreg = "SELECT * FROM diaria.coordenadoria";
    $rsCooreg  = pg_query(abreConexao(),$sqlCooreg);
    $numeroLinhas = (pg_num_rows($rsCooreg));    

    if($numeroLinhas > 0)
    {        
        $i = 0;
        $valor = 0;
        $arrayFonte[$i] = 0;
        $valorNivelMedio = 0;
        $arrayNivelMedio[$i] = 0;
        $valorNivelSuperior = 0;
        $arrayNivelSuperior[$i] = 0;
        
        While ($i <= $numeroLinhas)
        {  
            $sqlConsulta =   "SELECT 
                             p.pessoa_nm, 
                             p.pessoa_id, 
                             diaria_dt_saida, 
                             diaria_dt_chegada,
                             diaria_numero,
                             f.fonte_ds, 
                             projeto_ds, 
                             diaria_qtde, 
                             d.diaria_beneficiario, 
                             d.diaria_valor,
                             d.diaria_valor_ref,
                             nome, 
                             d.projeto_cd,
                             d.fonte_cd,
                             d.diaria_dt_criacao, 
                             est_organizacional_ds, 
                             est_organizacional_sigla,
                             d.etapa_id
                        FROM diaria.diaria d 
                        JOIN dados_unico.pessoa p 
                          ON p.pessoa_id = d.diaria_beneficiario 
                        JOIN dados_unico.est_organizacional est
                          ON est.est_organizacional_id = diaria_unidade_custo
                        JOIN diaria.projeto pr
                          ON pr.projeto_cd = d.projeto_cd
                        JOIN diaria.fonte f
                          ON f.fonte_cd = d.fonte_cd
                   LEFT JOIN diaria.coordenadoria c 
                          ON d.id_coordenadoria = c.id_coordenadoria 
                       WHERE d.diaria_excluida = 0 
                         ".$where."
                         AND d.id_coordenadoria = ".$i."
                         AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN TO_DATE('$dataInicio', 'DD/MM/YYYY') AND TO_DATE('$dataFim', 'DD/MM/YYYY')) 
                    ORDER BY fonte_cd, nome, TO_DATE(diaria_dt_saida, 'DD/MM/YYYY'), est_organizacional_ds, pessoa_nm, diaria_valor";	
            
            $rsConsulta   = pg_query(abreConexao(),$sqlConsulta);                
            $fonte_cd     = '';
            $valorFonte   = 0;
            $valorFonCor  = 0;
            
            if(($idEtapa != '')&&($idEtapa != 0))
            {
                $valorNivelMedio    = 0;
                $valorNivelSuperior = 0;
            }
            
            for ($a = 0; $a < pg_num_rows($rsConsulta); $a++) 
            {                              
                $linhaConsulta = pg_fetch_array($rsConsulta,$a,PGSQL_ASSOC);            
                
                if($fonte_cd == '')
                {
                    if($linhaConsulta["nome"] == null)
                    {
                        $nome = 'SEDE';
                    }
                    else
                    {
                        $nome = utf8_decode(strtoupper($linhaConsulta["nome"]));
                    }
                    $coordenadoria = mb_strtoupper($nome);	
                    $pdf->SetFont ("Times", "B",8);
                    $pdf->Cell (190,5,"COORDENADORIA: ".$coordenadoria,1,1);
                    $pdf->SetFont ("Times", "",8);
                    $fonte_cd = trim($linhaConsulta['fonte_cd']);
                    $fonte_ds = trim($linhaConsulta['fonte_ds']);
                    $pdf->Cell (20,5,utf8_decode('FONTE:'),1,0,"L");                
                    $pdf->Cell (170,5,$fonte_cd.' - '.$fonte_ds,1,1,"L");
                    
                    if($a == pg_num_rows($rsConsulta)-1)
                    {       
                        (float)$valorFonte  = (float)$valorFonte + (float)trim($linhaConsulta['diaria_valor']);
                        $arrayFonte[$fonte_cd] = $valorFonte + $arrayFonte[$fonte_cd];
                        
                        if(($idEtapa != '')&&($idEtapa != 0))
                        {
                            if($linhaConsulta['diaria_valor_ref'] == '83')
                            {
                                (float)$valorNivelMedio  = (float)$valorNivelMedio + (float)trim($linhaConsulta['diaria_valor']);
                            }
                            elseif($linhaConsulta['diaria_valor_ref'] == '115')
                            {
                                (float)$valorNivelSuperior  = (float)$valorNivelSuperior + (float)trim($linhaConsulta['diaria_valor']);                            
                            }
                        }                        
                        
//                        $pdf->SetFont ("Times", "",8);
//                        $pdf->Cell (160,5,'TOTAL:   ',1,0,"R"); 
//                        $pdf->Cell (30,5,'R$ '.number_format($valorFonte,2,',','.'),1,1,"L"); 
                        
                        if(($idEtapa != '')&&($idEtapa != 0))
                        {
                            $pdf->SetFont ("Times", "B",8);
                            $pdf->Cell (95,5,utf8_decode("DIÁRAS DE NÍVEL MÉDIO"),1,0,"C");
                            $pdf->Cell (95,5,utf8_decode("DIÁRAS DE NÍVEL SUPERIOR"),1,1,"C");
                            $pdf->SetFont ("Times", "B",8);
                            $pdf->Cell (95,5,'R$ '.number_format($valorNivelMedio,2,',','.'),1,0,"C");  
                            $pdf->Cell (95,5,'R$ '.number_format($valorNivelSuperior,2,',','.'),1,1,"C");  
                        }
                    }
                }
                else if(trim($fonte_cd) == trim($linhaConsulta['fonte_cd']))
                {                              
                    if($a == pg_num_rows($rsConsulta)-1)
                    {                        
                        (float)$valorFonte  = (float)$valorFonte + (float)trim($linhaConsulta['diaria_valor']);
                        $arrayFonte[$fonte_cd] = $valorFonte + $arrayFonte[$fonte_cd];
                        
                        if(($idEtapa != '')&&($idEtapa != 0))
                        {
                            if($linhaConsulta['diaria_valor_ref'] == '83')
                            {
                                (float)$valorNivelMedio  = (float)$valorNivelMedio + (float)trim($linhaConsulta['diaria_valor']);
                            }
                            elseif($linhaConsulta['diaria_valor_ref'] == '115')
                            {
                                (float)$valorNivelSuperior  = (float)$valorNivelSuperior + (float)trim($linhaConsulta['diaria_valor']);                            
                            }
                        } 
                        
//                        $pdf->SetFont ("Times", "",8);
//                        $pdf->Cell (160,5,'TOTAL:   ',1,0,"R"); 
//                        $pdf->Cell (30,5,'R$ '.number_format($valorFonte,2,',','.'),1,1,"L"); 
                        
                        if(($idEtapa != '')&&($idEtapa != 0))
                        {
                            $pdf->SetFont ("Times", "B",8);
                            $pdf->Cell (95,5,utf8_decode("DIÁRAS DE NÍVEL MÉDIO"),1,0,"C");
                            $pdf->Cell (95,5,utf8_decode("DIÁRAS DE NÍVEL SUPERIOR"),1,1,"C");
                            $pdf->SetFont ("Times", "B",8);
                            $pdf->Cell (95,5,'R$ '.number_format($valorNivelMedio,2,',','.'),1,0,"C");  
                            $pdf->Cell (95,5,'R$ '.number_format($valorNivelSuperior,2,',','.'),1,1,"C");  
                        }
                    }
                }
                else if(trim($fonte_cd) != trim($linhaConsulta['fonte_cd']))
                {
                    $pdf->SetFont ("Times", "",8);
                    $pdf->Cell (160,5,'TOTAL:   ',1,0,"R"); 
                    $pdf->Cell (30,5,'R$ '.number_format($valorFonte,2,',','.'),1,1,"L"); 
                    $pdf->SetFont ("Times", "",8);
                    
                    $arrayFonte[$fonte_cd] = $valorFonte + $arrayFonte[$fonte_cd];                    
                    $fonte_cd = trim($linhaConsulta['fonte_cd']); 
                    $fonte_ds = trim($linhaConsulta['fonte_ds']);
                    $valorFonte = 0;
                    
                    if(($idEtapa != '')&&($idEtapa != 0))
                    {
                        (float)$valorNivelMedio  = 0;
                        (float)$valorNivelSuperior  = 0;
                    } 
                    
                    $pdf->Cell (20,5,utf8_decode('FONTE:'),1,0,"L");                
                    $pdf->Cell (170,5,$fonte_cd.' - '.$fonte_ds,1,1,"L");                                                                                                     
                    
                    if($a == pg_num_rows($rsConsulta)-1)
                    {                        
                        (float)$valorFonte  = (float)$valorFonte + (float)trim($linhaConsulta['diaria_valor']);
                        $arrayFonte[$fonte_cd] = $valorFonte + $arrayFonte[$fonte_cd];
                        
                        if(($idEtapa != '')&&($idEtapa != 0))
                        {
                            if($linhaConsulta['diaria_valor_ref'] == '83')
                            {
                                (float)$valorNivelMedio  = (float)$valorNivelMedio + (float)trim($linhaConsulta['diaria_valor']);
                            }
                            elseif($linhaConsulta['diaria_valor_ref'] == '115')
                            {
                                (float)$valorNivelSuperior  = (float)$valorNivelSuperior + (float)trim($linhaConsulta['diaria_valor']);                            
                            }
                        } 
                        
//                        $pdf->SetFont ("Times", "",8);
//                        $pdf->Cell (160,5,'TOTAL:   ',1,0,"R"); 
//                        $pdf->Cell (30,5,'R$ '.number_format($valorFonte,2,',','.'),1,1,"L"); 
                        
                        if(($idEtapa != '')&&($idEtapa != 0))
                        {
                            $pdf->SetFont ("Times", "B",8);
                            $pdf->Cell (95,5,utf8_decode("DIÁRAS DE NÍVEL MÉDIO"),1,0,"C");
                            $pdf->Cell (95,5,utf8_decode("DIÁRAS DE NÍVEL SUPERIOR"),1,1,"C");
                            $pdf->SetFont ("Times", "B",8);
                            $pdf->Cell (95,5,'R$ '.number_format($valorNivelMedio,2,',','.'),1,0,"C");  
                            $pdf->Cell (95,5,'R$ '.number_format($valorNivelSuperior,2,',','.'),1,1,"C");  
                        }
                    }                                                            
                }  
                                
                (float)$valorFonte  = (float)$valorFonte + (float)trim($linhaConsulta['diaria_valor']); 
                (float)$valorFonCor = (float)$valorFonCor + (float)trim($linhaConsulta['diaria_valor']);  
                (float)$valor       = (float)$valor + (float)trim($linhaConsulta['diaria_valor']);    
                
                if(($idEtapa != '')&&($idEtapa != 0))
                {
                    if($linhaConsulta['diaria_valor_ref'] == '83')
                    {
                        (float)$valorNivelMedio  = (float)$valorNivelMedio + (float)trim($linhaConsulta['diaria_valor']);
                        (float)$totalNivelMedio  = (float)$totalNivelMedio + (float)trim($linhaConsulta['diaria_valor']);
                    }
                    elseif($linhaConsulta['diaria_valor_ref'] == '115')
                    {
                        (float)$valorNivelSuperior  = (float)$valorNivelSuperior + (float)trim($linhaConsulta['diaria_valor']);
                        (float)$totalNivelSuperior  = (float)$totalNivelSuperior + (float)trim($linhaConsulta['diaria_valor']);                            
                    }                                        
                } 
                
                $novaPagina = $pdf -> page;
                if($novaPagina > $pagina)
                {                                          
                    $pdf->SetFont ("Times", "B",8);
                    $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
                    $pdf->Text (196, 285 , $novaPagina);   
                    $pagina = $novaPagina;
                    $pdf->SetFont ("Times", "",8);
                }                
            }             
            
            if(pg_num_rows($rsConsulta) > 0)
            {                
                $total = 'R$ '.number_format($valorFonCor,2,',','.');
                                
                $pdf->SetFont ("Times", "B",8);
                $pdf->Cell (160,5,"TOTAL: ",1,0);
                $pdf->Cell (30,5,$total,1,1);
                $pdf->Cell (190,5,"",0,1); 
            }
            $i++;
        }        
    }    
    
    $sqlConsultaFonte ="SELECT 
                             d.fonte_cd,
                             f.fonte_ds
                        FROM diaria.diaria d 
                        JOIN dados_unico.pessoa p 
                          ON p.pessoa_id = d.diaria_beneficiario 
                        JOIN dados_unico.est_organizacional est
                          ON est.est_organizacional_id = diaria_unidade_custo
                        JOIN diaria.projeto pr
                          ON pr.projeto_cd = d.projeto_cd
                        JOIN diaria.fonte f
                          ON f.fonte_cd = d.fonte_cd
                   LEFT JOIN diaria.coordenadoria c 
                          ON d.id_coordenadoria = c.id_coordenadoria
                       WHERE d.diaria_excluida = 0 
                         ".$where."
                         AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN TO_DATE('$dataInicio', 'DD/MM/YYYY') AND TO_DATE('$dataFim', 'DD/MM/YYYY')) 
                    ORDER BY fonte_cd, nome, TO_DATE(diaria_dt_saida, 'DD/MM/YYYY'), est_organizacional_ds, pessoa_nm, diaria_valor";
    
    $rsConsultaFonte   = pg_query(abreConexao(),$sqlConsultaFonte);  
    $fonte = '';
    for($a = 0; $a < pg_num_rows($rsConsultaFonte); $a++)
    {            
        $linhaFonte = pg_fetch_array($rsConsultaFonte,$a); 
        if($fonte == '')
        {
            $fonte   = trim($linhaFonte['fonte_cd']);
            $fonteDs = trim($linhaFonte['fonte_ds']);
        }
        elseif($fonte != trim($linhaFonte['fonte_cd']))
        {                                                
            if(($idEtapa != '')&&($idEtapa != 0))
            {
                $pdf->Cell (190,5,"",0,1);
                $pdf->SetFont ("Times", "B",8);
                $pdf->Cell (190,5,"FONTE ".$fonte." - ".$fonteDs,1,1);
                $pdf->SetFont ("Times", "",8);
                $pdf->Cell (160,5,"TOTAL UTILIZADO PELA FONTE",1,0);
                $pdf->SetFont ("Times", "B",8);
                $pdf->Cell (30,5,'R$ '.number_format($arrayFonte[$fonte],2,',','.'),1,1);  
                $pdf->Cell (190,5,"",0,1);
                $pdf->SetFont ("Times", "B",8);
                $pdf->Cell (95,5,utf8_decode("TOTAL DE DIÁRAS DE NÍVEL MÉDIO"),1,0,"C");
                $pdf->Cell (95,5,utf8_decode("TOTAL DE DIÁRAS DE TOTAL NÍVEL SUPERIOR"),1,1,"C");
                $pdf->SetFont ("Times", "B",8);
                $pdf->Cell (95,5,'R$ '.number_format($totalNivelMedio,2,',','.'),1,0,"C");  
                $pdf->Cell (95,5,'R$ '.number_format($totalNivelSuperior,2,',','.'),1,1,"C");  
            }
            else
            {
                $pdf->Cell (190,5,"",0,1);
                $pdf->SetFont ("Times", "B",8);
                $pdf->Cell (190,5,"FONTE ".$fonte." - ".$fonteDs,1,1);
                $pdf->SetFont ("Times", "",8);
                $pdf->Cell (160,5,"TOTAL UTILIZADO PELA FONTE",1,0);
                $pdf->SetFont ("Times", "B",8);
                $pdf->Cell (30,5,'R$ '.number_format($arrayFonte[$fonte],2,',','.'),1,1);                
            }    
            
            $fonte   = trim($linhaFonte['fonte_cd']);
            $fonteDs = trim($linhaFonte['fonte_ds']);
        }   
        elseif($fonte == trim($linhaFonte['fonte_cd']))
        {
            if($a == (pg_num_rows($rsConsultaFonte)-1))
            {
                if(($idEtapa != '')&&($idEtapa != 0))
                {
                    $pdf->Cell (190,5,"",0,1);
                    $pdf->SetFont ("Times", "B",8);
                    $pdf->Cell (190,5,"FONTE ".$fonte." - ".$fonteDs,1,1);
                    $pdf->SetFont ("Times", "",8);
                    $pdf->Cell (160,5,"TOTAL UTILIZADO PELA FONTE",1,0);
                    $pdf->SetFont ("Times", "B",8);
                    $pdf->Cell (30,5,'R$ '.number_format($arrayFonte[$fonte],2,',','.'),1,1);
                    $pdf->Cell (190,5,"",0,1);
                    $pdf->SetFont ("Times", "B",8);
                    $pdf->Cell (95,5,utf8_decode("TOTAL DE DIÁRAS DE TOTAL NÍVEL MÉDIO"),1,0,"C");
                    $pdf->Cell (95,5,utf8_decode("TOTAL DE DIÁRAS DE TOTAL NÍVEL SUPERIOR"),1,1,"C");
                    $pdf->SetFont ("Times", "B",8);
                    $pdf->Cell (95,5,'R$ '.number_format($totalNivelMedio,2,',','.'),1,0,"C");  
                    $pdf->Cell (95,5,'R$ '.number_format($totalNivelSuperior,2,',','.'),1,1,"C");  
                }
                else
                {
                    $pdf->Cell (190,5,"",0,1);
                    $pdf->SetFont ("Times", "B",8);
                    $pdf->Cell (190,5,"FONTE ".$fonte." - ".$fonteDs,1,1);
                    $pdf->SetFont ("Times", "",8);
                    $pdf->Cell (160,5,"TOTAL UTILIZADO PELA FONTE",1,0);
                    $pdf->SetFont ("Times", "B",8);
                    $pdf->Cell (30,5,'R$ '.number_format($arrayFonte[$fonte],2,',','.'),1,1);                
                }
            }
        }
    }
    
    $pdf->Cell (1,5,'',0,1);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (190,5,'PROJETO '.$linhaConsulta['projeto_cd'].' - '.utf8_decode($linhaConsulta['projeto_ds']),1,1);
    $pdf->SetFont ("Times", "",8);
    $pdf->Cell (160,5,'TOTAL UTILIZADO NO PROJETO',1,0);
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (30,5,'R$ '.number_format($valor,2,',','.'),1,1,"L"); 
    $pdf->SetFont ("Times", "",8);        

    $novaPagina = $pdf -> page;
    $pdf->SetFont ("Times", "B",8);
    $pdf->Text (180, 285 ,utf8_decode("PÁGINA: "));
    $pdf->Text (196, 285 , $novaPagina);   
}
elseif(($tipoRelatorio == 'todas')&&($idProjeto == 0))
{
    $pdf->SetFont ("Times", "B",8);
    $pdf->Cell (160,5,"COORDENADORIA",1,0);
    $pdf->Cell (30,5,"TOTAL",1,1);    
    
    $sqlConsulta = "  SELECT d.id_coordenadoria,nome,d.diaria_valor,d.diaria_dt_criacao
                        FROM diaria.diaria d
                        JOIN dados_unico.est_organizacional est
                          ON est.est_organizacional_id = diaria_unidade_custo
                        JOIN diaria.projeto pr
                          ON pr.projeto_cd = d.projeto_cd
                        JOIN diaria.fonte f
                          ON f.fonte_cd = d.fonte_cd
                   LEFT JOIN diaria.coordenadoria c
                          ON d.id_coordenadoria = c.id_coordenadoria
                       WHERE d.diaria_excluida = 0
                         ".$where."
                         AND (TO_DATE(diaria_dt_saida, 'DD/MM/YYYY') BETWEEN TO_DATE('".$dataInicio."', 'DD/MM/YYYY') AND TO_DATE('".$dataFim."', 'DD/MM/YYYY'))
                    ORDER BY id_coordenadoria,diaria_dt_criacao, nome, diaria_valor";
 
    $rsConsulta       = pg_query(abreConexao(),$sqlConsulta);							 
    $numeroLinhas     = pg_num_rows($rsConsulta);		
    (string)$linhaOld = 'null';    
    $grupo            = '';  
    $valor            = '';
    
    if($numeroLinhas > 0)
    {        
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
        
        for($i = 0; $i <= $coordenadorias; $i++)
        { 
            if($coordenadoria[$i]["nome"] == 'Sede')
            {
                $pdf->SetFont ("Times", "",8); 
                $pdf->Cell (160,5, utf8_decode($coordenadoria[$i]["nome"]),1,0);
                $pdf->Cell (30,5,'R$ '.number_format($coordenadoria[$i]["valor"],2,',','.'),1,1);
                $total_todos = $total_todos + $coordenadoria[$i]["valor"];
            }
            elseif(($coordenadoria[$i]["nome"] != 'Sede')&&($coordenadoria[$i]["nome"] != ''))
            {
                $pdf->SetFont ("Times", "",8); 
                $pdf->Cell (160,5, utf8_decode($coordenadoria[$i]["nome"]),1,0);
                $pdf->Cell (30,5,'R$ '.number_format($coordenadoria[$i]["valor"],2,',','.'),1,1);
                $total_todos = $total_todos + $coordenadoria[$i]["valor"];
            }
        }
    }
    else
    {
        $pdf->SetFont ("Times", "B",8);	
        $pdf->Cell (160,5,'',1,0);
        $pdf->Cell (30,5,'',1,1);
        $total_todos = 0;
        $pdf->Text (165,60,utf8_decode("NÃO EXISTEM REGISTROS."));
    }
    $pdf->SetFont ("Times", "",10);	
    $pdf->Cell (160,5,"TOTAL",1,0);
    $pdf->Cell (30,5,'R$ '.number_format($total_todos,2,',','.'),1,1);        
}
$pdf->Close();
$pdf->Output();
?>