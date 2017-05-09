<?php

include "../Include/Inc_Configuracao.php";
include "../Include/Inc_DadosBancariosGER.PHP";
include "../Include/conecta.php";
include "fpdf.php";

// Pega parâmetros da Sessão
$UsuarioCod = $_SESSION['UsuarioCodigo'];
$UsuarioNome = $_SESSION["UsuarioNome"];

$ImpressaoMultipla = $_GET["cod"];
//$diaria_agrup_imp = $ImpressaoMultipla;

// Cria objeto PDF
$pdf = new FPDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->Open();
$pdf->AddPage();

/**
 * Retorna o Roteiro da Diária cujo id foi recebido como parâmetro
 * @param int $Diaria_id <p>Id da Diária da qual se deseja buscar o roteiro</p>
 * @return string <p>Roteiro da Diária</p>
 */
function Roteiro($Diaria_id) {
    $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = " . $Diaria_id;
    $rsRoteiro = pg_query(abreConexao(), $sqlRoteiro);
    $qtdDeRegistro = pg_num_rows($rsRoteiro);

    $Contador = $qtdDeRegistro;
    $i = 1;
    $Roteiro = "";
    $Meio = "";

    While ($linharsRoteiro = pg_fetch_assoc($rsRoteiro)) {
        $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linharsRoteiro['roteiro_origem'];
        $rsRoteiroOrigem = pg_query(abreConexao(), $sqlRoteiroOrigem);
        $linharsRoteiroOrigem = pg_fetch_assoc($rsRoteiroOrigem);

        $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linharsRoteiro['roteiro_destino'];
        $rsRoteiroDestino = pg_query(abreConexao(), $sqlRoteiroDestino);
        $linharsRoteiroDestino = pg_fetch_assoc($rsRoteiroDestino);

        If ($i == 1) {
            $Inicio = $linharsRoteiroOrigem['municipio_ds'] . " - (" . $linharsRoteiroOrigem['estado_uf'] . ")" . " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
        } Elseif ($i != 1) {
            $Meio = $Meio . " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
        } Elseif ($i == $Contador) {
            $Final = " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
        }
        $i++;
    }
    $Roteiro = $Inicio . $Meio . $Final;
    return $Roteiro;
}

/**
 * Insere o rodapé da página
 * @param FPDF $pdf 
 */
function RodaPe($pdf,$sd) {
    //Posi��o: a 1,5 cm do final
    if($pdf->GetY()<266){
       $pdf->SetY(266); 
    }
    $pdf->SetX(10);
    $pdf->SetFontSize(8);
    $pdf->Cell(50, 3, iconv("utf-8", "iso-8859-1", "Página") . $pdf->PageNo() . "/{nb}", 0, 0, "L");
    $pdf->SetX(120);
    $pdf->Cell(50, 3, iconv("utf-8", "iso-8859-1", "Número da SD: ").$sd, 0, 0, 'C');

}

// *************************************** BUSCA INFORMAÇÕES E GERA VALORES QUE SERÃO UTILIZADOS *************************/

/* Busca Informações das Diárias Agrupadas */
$sqlConsulta = "SELECT Distinct 
                    d.diaria_id, d.diaria_numero, d.projeto_cd, d.acao_cd, d.territorio_cd,
                    d.fonte_cd,d.diaria_valor, d.diaria_processo, d.diaria_qtde, d.diaria_valor_ref,
                    d.diaria_unidade_custo, d.diaria_st, d.diaria_dt_saida, d.diaria_empenho, d.diaria_descricao,
                    d.convenio_id, d.indenizacao, d.ger_id, pf.pessoa_fisica_cpf,
                    p.pessoa_nm, f.funcionario_matricula, f.pessoa_id,diaria_hr_saida, diaria_dt_chegada, diaria_hr_chegada,funcionario_tipo_ds
		FROM 
                    diaria.diaria d, dados_unico.funcionario f, dados_unico.funcionario_tipo ft, dados_unico.pessoa p,dados_unico.pessoa_fisica pf
		WHERE 
                    (d.diaria_beneficiario = f.pessoa_id) AND
                    (d.diaria_beneficiario = pf.pessoa_id) AND
                    (d.diaria_beneficiario = p.pessoa_id) AND
                    (f.funcionario_tipo_id = ft.funcionario_tipo_id) AND	
                    d.super_sd = '$ImpressaoMultipla' ";

$rsConsulta = pg_query(abreConexao(), $sqlConsulta);
$qtdDiarias = pg_num_rows($rsConsulta);

/* Guarda número de projeto e fonte para o cabeçalho */
$sqlProjetoFonte = "SELECT Distinct d.projeto_cd, d.fonte_cd
                    FROM   diaria.diaria d
                    WHERE  d.super_sd = '$ImpressaoMultipla'";
$consultaProjetoFonte = pg_query(abreConexao(), $sqlProjetoFonte);
$projetoFonte = pg_fetch_object($consultaProjetoFonte);

/*  Gerando o Número de SD e Processo do Agrupamento e o valor total e o nome do setor */
$sql = "SELECT diaria_processo, super_sd FROM diaria.diaria WHERE super_sd = '$ImpressaoMultipla' ";
$consulta = pg_query(abreConexao(), $sql);
$tupla = pg_fetch_assoc($consulta);
$Numero_SD = $tupla["super_sd"];
$Numero_processo = $tupla["diaria_processo"];

/* Busca Valor Total */
$Total_Diarias = 0.0;
$UnidadeCusto = "";
$sql = "SELECT diaria_valor,diaria_unidade_custo  From diaria.diaria WHERE super_sd = '$ImpressaoMultipla'";
$consulta = pg_query(abreConexao(), $sql);
While ($tupla = pg_fetch_assoc($consulta)) {
    $dinheiro = $tupla["diaria_valor"];
    $dinheiro = str_replace('R$', "", $dinheiro);
    $dinheiro = moedaBanco($dinheiro);
    $Total_Diarias += $dinheiro;
    $UnidadeCusto = $tupla["diaria_unidade_custo"];
}

/* Busca unidade de Custo */
$sql = "SELECT est_organizacional_sigla, est_organizacional_ds, est_organizacional_centro_custo_num FROM dados_unico.est_organizacional WHERE est_organizacional_id = " . $UnidadeCusto;
$Consulta = pg_query(abreConexao(), $sql);
$linhaConsulta = pg_fetch_assoc($Consulta);

If ($linhaConsulta) {
    $UnidadeCustoNome = $linhaConsulta['est_organizacional_ds'];
    $UnidadeCustoNumero = $linhaConsulta['est_organizacional_centro_custo_num'];
}

// ****************************** CABEÇALHO ******************************/

/* CABEÇALHO IMAGEM */
$pdf->Cell(55, 15, "", 1, 0, "C");
$pdf->image("../Imagens/logo.jpg", 14, 13, 40);
$pdf->SetFont("Times", "B", 10);
$pdf->Cell(135, 7, iconv("utf-8", "iso-8859-1", "Solicitação de Diárias Administrativas"), 0, 0, "C");
$pdf->SetXY(65, 10);
/* CABEÇALHO DADOS EMISSÃO */
$pdf->Cell(135, 15, "", 1, 1, "C");
$pdf->SetFont("Times", "", 7);
$pdf->Text(112, 19, "EMITIDO: " . date("d/m/Y") . iconv("utf-8", "iso-8859-1", " às ") . date("H:i:s"), 1, 1, "C");
$pdf->Text(103, 22, "Matr.: " . f_MatriculaPessoa($UsuarioCod), 0, 0);
$pdf->Text(121, 22, "  - " . $UsuarioNome, 1, 1, "C");
/* DADOS DO GRUPO */
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont("Times", "B", 10);
$pdf->Text($pdf->GetX()+2,$pdf->GetY(), iconv("utf-8", "iso-8859-1", "Número da Solicitação:")); //Espa?amento entre uma tabela e a outra
//$pdf->Cell(120, 25, iconv("utf-8", "iso-8859-1", "Número da Solicitação:"), 1, 1); //Espa?amento entre uma tabela e a outra
$pdf->Text($pdf->GetX()+40,$pdf->GetY(), $Numero_SD);
$pdf->Text($pdf->GetX()+2,$pdf->GetY()+4, iconv("utf-8", "iso-8859-1", "Número do Processo:       ") . $Numero_processo);
$pdf->Text($pdf->GetX()+2,$pdf->GetY()+8, "Valor Total:                      R$ " . formatoMoeda($Total_Diarias));
$pdf->Text($pdf->GetX()+2,$pdf->GetY()+12, iconv("utf-8", "iso-8859-1", "Área Beneficiária:            ") .$UnidadeCustoNumero." - ". $UnidadeCustoNome);
$pdf->Text($pdf->GetX()+2,$pdf->GetY()+16, "Projeto :  " . $projetoFonte->projeto_cd);
$pdf->Text($pdf->GetX()+2,$pdf->GetY()+20, "Fonte: " . $projetoFonte->fonte_cd);

// *************************************** CORPO *********************************************/

// Variáveis auxiliares
$num_servidor = 1; // Número que será exibido antes das informações de cada diária para facilitar identificação

/* Para cada diária encontrada */
while ($linhars = pg_fetch_assoc($rsConsulta)) {
    // Coleta os dados de cada diária
    $VarEmpenho = $linhars['diaria_st'];
    $Convenio = $linhars['convenio_id'];
    $Indenizacao = $linhars['indenizacao'];

    $CPF = $linhars['pessoa_fisica_cpf'];
    $ProjetoCOD = $linhars['projeto_cd'];
    $Diaria_id = $linhars['diaria_id'];
    $Diaria_numero = $linhars['diaria_numero'];
    $DiariaValor = $linhars['diaria_valor'];
    $DiariaProcessoNum = $linhars['diaria_processo'];
    $DiariaDS = $linhars['diaria_descricao'];
    $DiariaSD = $linhars['diaria_numero'];
    $DiariaValorTotal = $linhars['diaria_valor'];
    $DiariaQTDE = $linhars['diaria_qtde'];
    $DiariaValorRef = $linhars['diaria_valor_ref'];
    $DiariaDT_Saida = $linhars['diaria_dt_saida'];
    $DiariaHR_Saida = $linhars['diaria_hr_saida'];
    $DiariaDT_Retorno = $linhars['diaria_dt_chegada'];
    $DiariaHR_Retorno = $linhars['diaria_hr_chegada'];
    $DiariaNumEmpenho = $linhars['diaria_empenho'];
    $Acao = $linhars['acao_cd'];
    $Territorio = $linhars['territorio_cd'];
    $Fonte = $linhars['fonte_cd'];
    $FuncionarioMat = $linhars['funcionario_matricula'];
    $FuncionarioNM = $linhars['pessoa_nm'];
    $PessoaID = $linhars['pessoa_id'];
    $GerID = $linhars['ger_id'];
    $DadosBancarios = buscarDadosBancarios($PessoaID);
    $GERContaContabil = buscarDadosGer($GerID, 1);
    $DadosGER = buscarDadosGer($GerID, 0);
    $UnidadeExecutora = $linhars['est_organizacional_unidade_executora'];
    $CentroCusto = $linhars['est_organizacional_centro_custo_num'];
    $UnidadeCusto = $linhars['diaria_unidade_custo'];
    $tipo_servidor = $linhars['funcionario_tipo_ds'];
    
    // Verifica se o cargo é temporário ou permanente
    $sql_cargo = "SELECT cargo_temporario, cargo_permanente FROM dados_unico.funcionario WHERE pessoa_id = $PessoaID";
    $rs_cargo = pg_query(abreConexao(), $sql_cargo);
    $linha_cargo = pg_fetch_assoc($rs_cargo);

    if (($linha_cargo['cargo_temporario'] != 0) && ($linha_cargo['cargo_temporario'] != "")) {
        $Cargo = $linha_cargo['cargo_temporario'];
    } else {
        $Cargo = $linha_cargo['cargo_permanente'];
    }
    // Pega descrição do cargo
    $sql3 = "SELECT cargo_ds FROM dados_unico.cargo WHERE cargo_id = " . $Cargo;
    $rs_Sql3 = pg_query(abreConexao(), $sql3);
    $linhaConsulta = pg_fetch_assoc($rs_Sql3);
    $CargoNome = $linhaConsulta['cargo_ds'];
    
    if($num_servidor ==1){
        $pdf->SetY($pdf->GetY()+20);
    } else {
        $pdf->SetY($pdf->GetY()+5);
    }
    $pdf->SetFont("Times", "B", 9);
    $pdf->Cell(190, 1, "", 0, 1); //Espa?amento entre uma tabela e a outra		
    $pdf->Cell(190, 1, "", 0, 1); //Espa?amento entre uma tabela e a outra		
    $pdf->Cell(190, 5, "SERVIDOR: " . $num_servidor, 0, 1, "C"); //Espa?amento entre uma tabela e a outra
    $pdf->Cell(190, 1, "-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 0, 1,'C'); //Espa?amento entre uma tabela e a outra		
    $pdf->Cell(190, 1, "", 0, 1); //Espa?amento entre uma tabela e a outra
    $pdf->Cell(190, 1, "", 0, 1); //Espa?amento entre uma tabela e a outra

    $pdf->Cell(35, 5, "CPF/Matricula", 1, 0);
    $pdf->Cell(80, 5, "Nome", 1, 0, "C");
    $pdf->Cell(30, 5, "Tipo Servidor", 1, 0, "C");     
    $pdf->Cell(45, 5, iconv("utf-8", "iso-8859-1", "Dados Bancários"), 1, 1, "C");

    $pdf->SetFont("Times", "", 8);
    $pdf->Cell(35, 5, $CPF . "/" . $FuncionarioMat, 1, 0);
    $pdf->Cell(80, 5, iconv("utf-8", "iso-8859-1", substr($FuncionarioNM,0,42)), 1, 0);
    $pdf->Cell(30, 5, iconv("utf-8", "iso-8859-1", $tipo_servidor), 1, 0, "C");
    $pdf->Cell(45, 5, $DadosBancarios, 1, 1, "C");

    $pdf->SetFont("Times", "B", 9);
    $pdf->Cell(35, 5, iconv("utf-8", "iso-8859-1", "Cargo/Função"), 1, 0);
    $pdf->SetFont("Times", "", 8);
    $pdf->Cell(155, 5, iconv("utf-8", "iso-8859-1", $CargoNome), 1, 0);

    $pdf->SetFont("Times", "B", 9);
    $pdf->SetXY(10,$pdf->GetY()+7);
    $pdf->Cell(190, 5, "MOTIVO DA VIAGEM : ", 0, 1);
    $pdf->SetFont("Times", "", 8);
    $pdf->SetY($pdf->GetY()+2);
    $pdf->MultiCell(190, 6, iconv("utf-8", "iso-8859-1", $DiariaDS), 0, 1);
    
    $pdf->SetY($pdf->GetY()+3);
    $pdf->SetFont("Times", "B", 9);
    $pdf->Cell(190, 5, "ROTEIRO : ", 0, 1);
    $pdf->SetFont("Times", "", 8);
    $pdf->SetY($pdf->GetY()+2);
    $pdf->MultiCell(190, 5, Roteiro($Diaria_id), 0, 1);

    $pdf->SetFont("Times", "B", 9);
    $pdf->SetY($pdf->GetY()+3);
    $pdf->Cell(33, 5, iconv("utf-8", "iso-8859-1","Saída"), 1, 0, "C");
    $pdf->Cell(33, 5, "Retorno", 1, 0, "C");
    $pdf->Cell(25, 5, iconv("utf-8", "iso-8859-1","Valor Unitário"), 1, 0);
    $pdf->Cell(15, 5, "Qtde", 1, 0, "C");
    $pdf->Cell(20, 5, "Valor Trecho", 1, 0);

    $pdf->Cell(65, 5, "SD Individual", 1, 1, "C");

    $pdf->SetFont("Times", "", 8);
    $pdf->Cell(33, 5, $DiariaDT_Saida . "  " . $DiariaHR_Saida, 1, 0, "C");
    $pdf->Cell(33, 5, $DiariaDT_Retorno . "  " . $DiariaHR_Retorno, 1, 0, "C");
    $pdf->Cell(25, 5, $DiariaValorRef, 1, 0, "C");
    $pdf->Cell(15, 5, $DiariaQTDE, 1, 0, "C");
    $pdf->Cell(20, 5, $DiariaValorTotal, 1, 0, "C");
    $pdf->Cell(65, 5, $Diaria_numero, 1, 1, "C");

    if ($num_servidor % 3 == 0) {
      RodaPe($pdf,$Numero_SD);
      $pdf->AddPage();
    }
    $num_servidor++;
}   

// ********************************** CARIMBO ******************************************/
// Consulta data e hora da aprovação e autorização
// Autorização
$sql3 = "SELECT 
            diaria_autorizacao_dt,diaria_autorizacao_hr
         FROM 
            diaria.diaria_autorizacao a, diaria.diaria d
         WHERE 
            a.diaria_id = d.diaria_id AND 
            d.super_sd ='".$ImpressaoMultipla."'
            ORDER BY diaria_autorizacao_dt, diaria_autorizacao_hr desc limit 1";

$Consulta = pg_query(abreConexao(), $sql3);
$linhaConsulta = pg_fetch_assoc($Consulta);
If ($linhaConsulta) {
    $diaria_autorizacao_dt = f_formatadata($linhaConsulta['diaria_autorizacao_dt']);
    $diaria_autorizacao_hr = $linhaConsulta['diaria_autorizacao_hr'];
}
// Aprovação
$sql3 = "SELECT 
            diaria_aprovacao_dt, diaria_aprovacao_hr
         FROM 
            diaria.diaria_aprovacao a,diaria.diaria d
         WHERE
            a.diaria_id = d.diaria_id AND
            d.super_sd ='".$ImpressaoMultipla."'
         ORDER BY diaria_aprovacao_dt, diaria_aprovacao_hr desc limit 1 ";
$rsConsulta = pg_query(abreConexao(), $sql3);
$linhaConsulta = pg_fetch_assoc($rsConsulta);
If ($linhaConsulta) {
    $diaria_aprovacao_dt = f_formatadata($linhaConsulta['diaria_aprovacao_dt']);
    $diaria_aprovacao_hr = $linhaConsulta['diaria_aprovacao_hr'];
}


/* Imprime data e hora da aprovação e autorização na página */

 // Dados da Autorização

$pdf->Rect(10, 225, 95, 33, "C"); // cria caixa onde estarão os dados do Autorizador
// Cargo
$pdf->SETXY(10, 248);
$pdf->SetFont("Times", "B", 9);
$pdf->Cell(95, 5, "Coordenador da Unidade", 0, 0,"C");
// Data
$Diaria_DT_Autorizacao = "Data da Autorização: " . $diaria_autorizacao_dt . ' ' . $diaria_autorizacao_hr;
$pdf->SetFont("Times", "", 7);
$pdf->SetXY(10,253);
$pdf->Cell(95, 5, iconv("utf-8", "iso-8859-1",$Diaria_DT_Autorizacao), 0, 0, "C");
    
// Dados da Aprovação

$pdf->Rect($pdf->GetX(), 225, 95, 33, "C"); // cria caixa onde estarão os dados do Aprovador
// Cargo
$pdf->SetXY(105,248);
$pdf->SetFont("Times", "B", 9);
$pdf->Cell(95, 5, "Diretor", 0, 0,'C');
// Data
$Diaria_DT_Aprovacao = "Data da Aprovação: " . $diaria_aprovacao_dt . ' ' . $diaria_aprovacao_hr; // Data e Hora da Aprova��o
$pdf->SetFont("Times", "", 7);
$pdf->SetXY(105,253);
$pdf->Cell(95, 5, iconv("utf-8", "iso-8859-1",$Diaria_DT_Aprovacao), 0, 0, "C");

// Data de Impressão
$pdf->SETXY(10, 260);
$pdf->SetFont("Times", "B");
$pdf->Cell(28, 4, iconv("utf-8", "iso-8859-1","Data da Impressão:"), 0, 0);
$pdf->SetFont("Times", "");
$pdf->Cell(28, 4, date("d/m/Y - H:i:s"), 0, 1);
//Rodapé
RodaPe($pdf, $Numero_SD);

/** Atualiza a Diária no BD */
$Sql_imp = "UPDATE diaria.diaria
            SET imp_diaria_agrupa = 1
            WHERE super_sd in ('$diaria_agrupa_imp')";
pg_query(abreConexao(), $Sql_imp);
/*
  // Diaria Impressa //
  $sqlAltera = "UPDATE diaria.diaria_aprovacao SET imp_processo_st = 1 WHERE diaria_id in (".$ImpressaoMultipla.")";
  pg_query(abreConexao(),$sqlAltera);
 */
$pdf->Close();
$pdf->Output();
?>