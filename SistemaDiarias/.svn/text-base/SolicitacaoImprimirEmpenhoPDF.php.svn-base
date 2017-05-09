<?php
include "../Include/Inc_Configuracao.php";
include "../Include/Inc_DadosBancariosGER.PHP";
include "fpdf.php";

$UsuarioCod  = $_SESSION['UsuarioCodigo'];
$UsuarioNome = $_SESSION["UsuarioNome"];

$ImpressaoMultipla = $_GET["Multiplos"];

$pdf= new FPDF();
$pdf->Open();
	
$sqlConsulta = "SELECT Distinct d.diaria_id, d.diaria_numero, d.projeto_cd, d.acao_cd, d.territorio_cd,
		d.fonte_cd,d.diaria_valor, d.diaria_processo, d.diaria_qtde, d.diaria_valor_ref,
		d.diaria_unidade_custo, d.diaria_st, d.diaria_dt_saida, d.diaria_empenho, d.diaria_descricao,
		d.convenio_id, d.indenizacao, d.ger_id, pf.pessoa_fisica_cpf,
		p.pessoa_nm, f.funcionario_matricula, f.pessoa_id
		FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.funcionario_tipo ft, dados_unico.pessoa p,dados_unico.pessoa_fisica pf 
		WHERE (d.diaria_beneficiario = f.pessoa_id) AND
		(d.diaria_beneficiario = pf.pessoa_id) AND
		(d.diaria_beneficiario = p.pessoa_id) AND
		(f.funcionario_tipo_id = ft.funcionario_tipo_id) AND
		(d.diaria_st = 2 OR d.diaria_st = 6)
		AND d.diaria_id in (".$ImpressaoMultipla.")";

$rsConsulta = pg_query(abreConexao(),$sqlConsulta);

function Update($ImpressaoMultipla)
{
    $sqlAltera = "UPDATE diaria.diaria SET diaria_extrato_empenho = '1'
                            WHERE diaria_id in (".$ImpressaoMultipla.")";
    pg_query(abreConexao(),$sqlAltera);
}

function Cabecalho(FPDF $pdf, $UsuarioCod, $UsuarioNome, $VarEmpenho, $Indenizacao, $Convenio)
{   $pdf->AddPage();
    $pdf->Cell (55,15,"",1,0,"C");
    $pdf->image ("../Imagens/logo.jpg",14,13,40);
    $pdf->SetFont ("Times", "B",10);
    $pdf->Cell (135,7,Titulo($VarEmpenho, $Indenizacao, $Convenio),0,0,"C");
    $pdf->SetXY(65,10);
    $pdf->Cell (135,15,"",1,1,"C");
    $pdf->SetFont ("Times", "",7);
    $pdf->Text (112, 19 ,"EMITIDO: " .date("d/m/Y")." às ".date("H:i:s"),1,1,"C");
    $pdf->Text (103,22 ,"Matr.: " .f_MatriculaPessoa($UsuarioCod),0,0);
    $pdf->Text (121, 22 ,"  - ".$UsuarioNome,1,1,"C");
}

function Titulo($VarEmpenho, $Indenizacao, $Convenio)
{
    if  ($VarEmpenho  == 2)
    {
         $VarEmpenho = "1º ";
    }
    else
    {
        $VarEmpenho = "2º ";
    }
    //Monta título de impressão conforme sua situação
    if ($Convenio == 0 and $Indenizacao == 0)
    {
        $Var1 = "Empenho de Diarias";
    }
    elseif ($Convenio != 0 and $Indenizacao == 0)
    {
        $Var1 = "Empenho de Diarias / Convênio";
    }
    elseif ($Convenio == 0 and $Indenizacao != 0)
    {
        $Var1 = "Empenho de Diarias / Indenização";
    }
    elseif ($Convenio != 0 and $Indenizacao != 0)
    {
        $Var1 = "Empenho de Diarias / Convênio / Indenização";
    }
    //Monta título de impressão conforme sua situação
    $Var2 = "Extrato para o ";
    $Var = $Var2 .$VarEmpenho .$Var1;
    return $Var;
}

function Roteiro ($Diaria_id)
{
    $sqlRoteiro     = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$Diaria_id;
    $rsRoteiro      = pg_query(abreConexao(),$sqlRoteiro);
    $qtdDeRegistro  = pg_num_rows($rsRoteiro);

    $Contador = $qtdDeRegistro;
    $i =1;
    $Roteiro = "";
    $Meio = "";

    While($linharsRoteiro = pg_fetch_assoc($rsRoteiro))
    {
        $sqlRoteiroOrigem 	= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_origem'];
        $rsRoteiroOrigem 	= pg_query(abreConexao(),$sqlRoteiroOrigem);
        $linharsRoteiroOrigem	= pg_fetch_assoc($rsRoteiroOrigem);

        $sqlRoteiroDestino 	= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_destino'];
        $rsRoteiroDestino 	= pg_query(abreConexao(),$sqlRoteiroDestino);
        $linharsRoteiroDestino	= pg_fetch_assoc($rsRoteiroDestino);

        If ($i == 1)
        {
            $Inicio = $linharsRoteiroOrigem['municipio_ds']." - (".$linharsRoteiroOrigem['estado_uf'].")" . " / ".$linharsRoteiroDestino['municipio_ds']." - (" .$linharsRoteiroDestino['estado_uf'].")";
        }
        Elseif ($i != 1)
        {  $Meio = $Meio." / ".$linharsRoteiroDestino['municipio_ds']. " - (".$linharsRoteiroDestino['estado_uf']. ")";

        }
        Elseif ($i == $Contador)
        {
            $Final = " / ".$linharsRoteiroDestino['municipio_ds']." - (".$linharsRoteiroDestino['estado_uf']. ")";
        }
        $i++;
}
$Roteiro = $Inicio.$Meio.$Final;
return $Roteiro;
}
//echo $Diaria_id;
//EXIT();
// *************************** Fim das funções ***************************

while ($linhars = pg_fetch_assoc($rsConsulta))
    {
        $VarEmpenho  = $linhars['diaria_st'];
        $Convenio    = $linhars['convenio_id'];
        $Indenizacao = $linhars['indenizacao'];

        Cabecalho($pdf, $UsuarioCod, $UsuarioNome, $VarEmpenho, $Indenizacao, $Convenio);

        $pdf->SetFont ("Times", "B",9);
        $pdf->Cell (20,5,"CHECK",1,0,"L");
        $pdf->Cell (35,5,"AÇÃO",1,0,"L");
        $pdf->Cell (72,5,"DESCRIÇÃO DA AÇÃO ",1,0,"L");
        $pdf->Cell (63,5,"NOME DA AÇÃO",1,1);

        $CPF                = $linhars['pessoa_fisica_cpf'];
        $ProjetoCOD         = $linhars['projeto_cd'];
        $Diaria_id          = $linhars['diaria_id'];
        $DiariaValor        = $linhars['diaria_valor'];
        $DiariaProcessoNum  = $linhars['diaria_processo'];
        $DiariaDS           = $linhars['diaria_descricao'];
        $DiariaSD           = $linhars['diaria_numero'];
        $DiariaValorTotal   = $linhars['diaria_valor'];
        $DiariaQTDE         = $linhars['diaria_qtde'];
        $DiariaValorRef     = $linhars['diaria_valor_ref'];
        $DiariaDT_Saida     = $linhars['diaria_dt_saida'];
        $DiariaNumEmpenho   = $linhars['diaria_empenho'];
        $Acao               = $linhars['acao_cd'];
        $Territorio         = $linhars['territorio_cd'];
        $Fonte              = $linhars['fonte_cd'];
        $ElementoDespesa    = $linhars['funcionario_tipo_ds'];
        $FuncionarioMat     = $linhars['funcionario_matricula'];
        $FuncionarioNM      = $linhars['pessoa_nm'];
        $PessoaID           = $linhars['pessoa_id'];
        $GerID              = $linhars['ger_id'];
        $DadosBancarios     = buscarDadosBancarios($PessoaID);
        $GERContaContabil   = buscarDadosGer($GerID, 1);
        $DadosGER           = buscarDadosGer($GerID, 0);
        $UnidadeExecutora   = $linhars['est_organizacional_unidade_executora'];
        $CentroCusto        = $linhars['est_organizacional_centro_custo_num'];
        $UnidadeCusto       = $linhars['diaria_unidade_custo'];

        if ($ElementoDespesa=="EVENTUAL")
        {
            $ElementoDespesaCOD = "339036";
        }
        else
        {
            $ElementoDespesaCOD = "339014";
        }
        
        $pdf->SetFont ("Times", "",8);

        $pdf->Cell (20,5,"1",1,0, "C");
        $pdf->Cell (35,5,$CPF,1,0);
        $pdf->Cell (72,5,"CREDOR - CPF / CNPJ",1,0);
        $pdf->Cell (63,5,"",1,1);

        $pdf->Cell (20,5,"2",1,0, "C");
        $pdf->Cell (35,5,"03",1,0);
        $pdf->Cell (72,5,"TIPO",1,0);
        $pdf->Cell (63,5,"ESTIMATIVA",1,1);

        $pdf->Cell (20,5,"3",1,0, "C");
        $pdf->Cell (35,5,"01",1,0);
        $pdf->Cell (72,5,"FINALIDADE",1,0);
        $pdf->Cell (63,5,"NORMAL",1,1);

        $pdf->Cell (20,5,"4",1,0, "C");
        $pdf->Cell (35,5,$ProjetoCOD,1,0);
        $pdf->Cell (72,5,"PROJETO / ATIVIDADE",1,0);
        $pdf->Cell (63,5,"",1,1);

        $pdf->Cell (20,5,"5",1,0, "C");
        $pdf->Cell (35,5,"?",1,0);
        $pdf->Cell (72,5,"CONTA DESPESA ORÇAMENTARIA",1,0);
        $pdf->Cell (63,5,"",1,1);

        $pdf->Cell (20,5,"6",1,0, "C");
        $pdf->Cell (35,5,$DiariaValor,1,0);
        $pdf->Cell (72,5,"VALOR",1,0);
        $pdf->Cell (63,5,"",1,1);

        $pdf->Cell (20,5,"7",1,0, "C");
        $pdf->Cell (35,5,date("d/m/Y"),1,0);
        $pdf->Cell (72,5,"DATA DO DIA",1,0);
        $pdf->Cell (63,5,"",1,1);

        $pdf->Cell (20,5,"8",1,0, "C");
        $pdf->Cell (35,5,"07",1,0);
        $pdf->Cell (72,5,"MODALIDADE LICITAÇÃO",1,0);
        $pdf->Cell (63,5,"INAPLICAVEL",1,1);

        $pdf->Cell (20,5,"9",1,0, "C");
        $pdf->Cell (35,5,substr($DiariaProcessoNum, 7, 6),1,0);
        $pdf->Cell (72,5,"NÚMERO DO DOCUMENTO",1,0);
        $pdf->Cell (63,5,"",1,1);

        $pdf->Cell (20,5,"10",1,0, "C");
        $pdf->Cell (35,5,"11",1,0);
        $pdf->Cell (72,5,"TIPO DE INSTRUMENTO",1,0);
        $pdf->Cell (63,5,"DIÁRIAS",1,1);

        $pdf->Cell (20,5,"11",1,0, "C");
        $pdf->Cell (35,5,substr($DiariaProcessoNum, 7, 6),1,0);
        $pdf->Cell (72,5,"NÚMERO DO DOCUMENTO",1,0);
        $pdf->Cell (63,5,"",1,1);

        $pdf->Cell (20,5,"12",1,0, "C");
        $pdf->Cell (35,5,$ElementoDespesaCOD,1,0);
        $pdf->Cell (72,5,"ELEMENTO DE DESPESA",1,0);
        $pdf->Cell (63,5,$ElementoDespesa,1,1);

        $pdf->Cell (190,1,"",0,1); //Espaçamento entre uma tabela e a outra

        $pdf->SetFont ("Times", "B",9);
        $pdf->Cell(190,4,"MOTIVO DA VIAGEM : ",0,1 );
        $pdf->SetFont ("Times", "",8);
        //$pdf->Text (47,95,substr($DiariaDS, 0, 80)."...");
        $pdf->MultiCell (190,4,$DiariaDS,0,1);
        $pdf->SetY(90);
        $pdf->Cell(190,19,"",1,1 );

        $pdf->SetFont ("Times", "B",9);
        $pdf->Cell(190,4,"DESTINO : ",0,1 );
        $pdf->SetFont ("Times", "",8);
        $pdf->MultiCell (190,4,Roteiro ($Diaria_id),0,1);
        $pdf->SetY(109);
        $pdf->Cell(190,19,"",1,1 );

        $pdf->Cell (190,1,"",0,1); //Espaçamento entre uma tabela e a outra
        $pdf->SetFont ("Times", "B",9);
        $pdf->Cell (190,5,"DADOS ADICIONAIS, INFORMAÇÕES PARA OS SETORES: FINANCEIRO E ORÇAMENTARIO",1,1,"C");

        $pdf->Cell (20,5,"SD",1,0);
        $pdf->Cell (35,5,"PROCESSO",1,0);
        $pdf->Cell (72,5,"NOME",1,0);
        $pdf->Cell (33,5,"MATRICULA",1,0);
        $pdf->Cell (30,5,"TIPO DE FUNC",1,1);
        
        $pdf->SetFont ("Times", "",8);
        $pdf->Cell (20,5,$DiariaSD,1,0);
        $pdf->Cell (35,5,$DiariaProcessoNum,1,0);
        $pdf->Cell (72,5,$FuncionarioNM,1,0);
        $pdf->Cell (33,5,$FuncionarioMat,1,0);
        $pdf->Cell (30,5,$ElementoDespesa,1,1);

        $pdf->SetFont ("Times", "B",9);
        $pdf->Cell (20,5,"QTDE",1,0);
        $pdf->Cell (35,5,"VALOR UNITÁRIO",1,0);
        $pdf->Cell (72,5,"VALOR TOTAL",1,0);
        $pdf->Cell (33,5,"PARTIDA PREVISTA",1,0);
        $pdf->Cell (30,5,"NUM. EMPENHO",1,1);

        $pdf->SetFont ("Times", "",8);
        $pdf->Cell (20,5,$DiariaQTDE,1,0);
        $pdf->Cell (35,5,$DiariaValorRef,1,0);
        $pdf->Cell (72,5,$DiariaValorTotal,1,0);
        $pdf->Cell (33,5,$DiariaDT_Saida,1,0);
        $pdf->Cell (30,5,$DiariaNumEmpenho,1,1);

        $pdf->Cell (190,1,"",0,1); //Espaçamento entre uma tabela e a outra

        if ($GERContaContabil != "")
        {
            $Projeto = "PROJETO: "."Unid Exec. ".$UnidadeExecutora." - ACP: ".$CentroCusto." - Projeto: ".$ProjetoCOD .", Produto: ".$Acao.", Território: ".$Territorio.", Fonte: ".$Fonte;
            $Convenio = "C/Contabil - ".$GERContaContabil." / ACP ".$CentroCusto." ".$DadosGER;
            $pdf->SetFont ("Times", "",8);
            $pdf->MultiCell (55,5,"DADOS BANCÁRIOS: ". $DadosBancarios,1,1);
            $pdf->SETXY (65,155);
            $pdf->MultiCell (72,5,$Projeto,1,1);
            $pdf->SETXY (137,155);
            $pdf->Cell (63,10,"",1,0);
            $pdf->SETXY (137,155);
            $pdf->MultiCell (63,5,"CONV. ".$Convenio,0,1);
        }
        else
        {
            $Projeto = "PROJETO: "."Unid Exec. ".$UnidadeExecutora." - ACP: ".$CentroCusto." - Projeto: ".$ProjetoCOD .", Produto: ".$Acao.", Território: ".$Territorio.", Fonte: ".$Fonte;
            $pdf->SetFont ("Times", "",8);
            $pdf->Cell (95,10,"",1,0);
            $pdf->SETXY (10,155);
            $pdf->MultiCell (95,5,"DADOS BANCÁRIOS: ". $DadosBancarios,0,1);
            $pdf->SETXY (105,155);
            $pdf->MultiCell (95,5,$Projeto,1,1);
        }
     
    }
Update($ImpressaoMultipla);
$pdf->Close();
$pdf->Output();
?>
