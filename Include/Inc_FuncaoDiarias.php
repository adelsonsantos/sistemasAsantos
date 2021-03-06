<?php
/*
Consulta os motivos das solicitacoes de diarias,
por isso passa o parametro tipo (1-cancelamento, 2-devolucao, 3-solicitacao)
 *

 *
 *
 */
function ComboMotivoDiaria($cod,$tipo,$javascript)
{  echo "<select name=cmbMotivoDiaria id=cmbMotivoDiaria style=width:310px ".$javascript.">";
    $sql = "SELECT * FROM diaria.motivo WHERE (motivo_tipo_id = '".$tipo."'". ") AND (motivo_st = 0) AND (motivo_id <> 0) ORDER BY UPPER(motivo_ds)";
    $rs=pg_query(abreConexao(),$sql);
    echo	 "<option value=0>[-------------------------------------- Selecione -------------------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {  if ((int)$cod==(int)($linha['motivo_id']))
    {  echo "<option value=" .$linha['motivo_id']." selected>".$linha['motivo_ds']."</option>";
    }
    else
    {  echo "<option value=".$linha['motivo_id'].">" .$linha['motivo_ds']. "</option>";
    }
    }
    echo "</select>";
}

function ComboMotivoDiariaCadastro($cod,$javascript)
{ echo "<select name=cmbMotivoDiaria style=width:310px " .$javascript.">";
    $sql = "SELECT * FROM diaria.motivo WHERE (motivo_st = 0) AND (motivo_id <> 0) ORDER BY UPPER(motivo_ds)";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[-------------------------------------- Selecione -------------------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {	 if ((int)$cod==(int)($linha['motivo_id']))
    {   echo "<option value=" .$linha['motivo_id']. " selected>" .$linha['motivo_ds']. "</option>";
    }
    else
    {  echo "<option value=".$linha['motivo_id'].">" .$linha['motivo_ds']. "</option>";
    }
    }
    echo "</select>";
}
/*

Consulta os submotivos das solicitacoes de diarias,
por isso passa o parametro motivo
 *
 * 
 */

function ComboSubMotivoDiaria($codigoEscolhido)
{  echo "<select name=cmbSubMotivoDiaria style=width:310px>";
    $sql = "SELECT * FROM diaria.sub_motivo WHERE (sub_motivo_st = 0) AND (sub_motivo_id <> 0) ORDER BY UPPER(sub_motivo_ds)";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[-------------------------------------- Selecione -------------------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {  if ((int)$codigoEscolhido==(int)($linha['sub_motivo_id']))
    {   echo "<option value=" .$linha['sub_motivo_id']. " selected>" .$linha['sub_motivo_ds']. "</option>";
    }
    else
    {  echo "<option value=".$linha['sub_motivo_id'].">" .$linha['sub_motivo_ds']. "</option>";
    }
    }
    echo "</select>";
}


function ComboMotivoTipo($cod)
{  echo "<select name=cmbMotivoTipo style=width:202px>";
    $sql = "SELECT motivo_tipo_id, motivo_tipo_ds FROM diaria.motivo_tipo WHERE (motivo_tipo_st = 0) AND (motivo_tipo_id <> 0) ORDER BY UPPER(motivo_tipo_ds)";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[-------------------- Selecione -------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {  if ((int)$cod==(int)($linha['motivo_tipo_id']))
    {   echo "<option value=" .$linha['motivo_tipo_id']. " selected>" .$linha['motivo_tipo_ds']. "</option>";
    }
    else
    {  echo "<option value=".$linha['motivo_tipo_id'].">" .$linha['motivo_tipo_ds']. "</option>";
    }
    }
    echo "</select>";
}
/*
**************************************************
função para carregar tipos de acao
**************************************************
 *
 */
function f_ComboAcaoTipo($codigoEscolhido)
{  switch ($codigoEscolhido)
{  case "D":
        $AcaoD = "selected";
        break;
    case "NDC":
        $AcaoNDC = "selected";
        break;
    case "NDNC":
        $AcaoNDNC = "selected";
        break;
}
    echo "<select name=cmbAcaoTipo style=width:114px>"	;
    echo "<option value=0>[----- Selecione -----]</option>";
    echo "<option value=D ".$AcaoD. ">D</option>";
    echo "<option value=NDC ".$AcaoNDC.">NDC</option>";
    echo "<option value=NDNC ".$AcaoNDNC. ">NDNC</option>";
    echo "</select>";
}
/*
**************************************************
projetos
**************************************************
 *
 */
function f_ComboProjeto($codigoEscolhido, $FuncaoJavaScript)
{
    echo "<select name=cmbProjeto id=cmbProjeto style=width:785px " .$FuncaoJavaScript. ">";
    $sql = "SELECT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_st = 0 ORDER BY projeto_cd";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------- Selecione ---------------------------------------------------------------------------------------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {
        if($codigoEscolhido==($linha['projeto_cd']))
        {
            echo "<option value=".$linha['projeto_cd']. " selected>" .$linha['projeto_cd']. " ----> ".$linha['projeto_ds']."</option>";//echo "<input type='hidden' name='cmbProjetoPC' value='".$linha['projeto_convenio']."'";	
        }
        else
        {
            echo "<option value=" .$linha['projeto_cd']. ">" .$linha['projeto_cd']. " ----> " .$linha['projeto_ds']. "</option>";// echo "<input type='hidden' name='cmbProjetoPC' value='".$linha['projeto_convenio']."'";
        }
    }
    echo "</select>";
}
/*
 Carrega todos os convênios válidos (que não estão vencidos)
*/
function f_Convenio($codigoEscolhido)
{
    echo "<select name=cmbConvenio style=width:785px >";
    $sqlConsulta = "SELECT projeto_cd, projeto_ds, convenio_dt_vencimento, projeto_convenio FROM diaria.projeto WHERE projeto_st = 0 AND convenio_dt_vencimento > to_date('".date("Y-m-d")."', 'YYYY-MM-DD') AND projeto_convenio = 1 ORDER BY projeto_cd";

    $rs=pg_query(abreConexao(),$sqlConsulta);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    echo "<option value=0></option>";
    while($linhars = pg_fetch_assoc($rs))
    {  if ($codigoEscolhido==($linhars['projeto_cd']))
    {
        echo "<option value=".$linhars['projeto_cd']. " selected>" .$linhars['projeto_cd']. " ----> ".$linhars['projeto_ds']."</option>";
    }
    else
    {
        echo "<option value=" .$linhars['projeto_cd']. ">" .$linhars['projeto_cd']. " ----> " .$linhars['projeto_ds']. "</option>";
    }
    }
    echo "</select>";
}

/*
**************************************************
acao
**************************************************
 *
 */
function f_ComboAcao($codigoEscolhido, $projeto, $FuncaoJavaScript)
{  echo "<select name=cmbAcao id=cmbAcao style=width:785px " .$FuncaoJavaScript.">";
    if($projeto=="")
    {  $sql = "SELECT DISTINCT acao_cd, acao_ds FROM diaria.acao WHERE acao_st = 0 ORDER BY acao_cd";
    }
    else
    {  $sql = "SELECT DISTINCT a.acao_cd, acao_ds FROM diaria.acao a, diaria.projeto_acao_territorio pat WHERE projeto_cd = '".$projeto."'". " AND (a.acao_cd = pat.acao_cd) AND acao_st = 0 and projeto_acao_territorio_st = 0 ORDER BY acao_cd";
    }
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------- Selecione ---------------------------------------------------------------------------------------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {  if ($codigoEscolhido==($linha['acao_cd']))
    {  echo "<option value=" .$linha['acao_cd']." selected>" .$linha['acao_cd']. " ----> " .$linha['acao_ds']. "</option>";
    }
    else
    {  echo "<option value=" .$linha['acao_cd'].">" .$linha['acao_cd']." ----> " .$linha['acao_ds']."</option>";
    }
    }
    echo "</select>";
}
/*
**************************************************
territorio
**************************************************
 *
 */
function f_ComboTerritorio($acao, $codigoEscolhido, $FuncaoJavaScript, $Tamanho)
{  echo "<select name='cmbTerritorio' id='cmbTerritorio' style='width:" .$Tamanho."' ".$FuncaoJavaScript.">";
    if ($acao == "")
    {
        $sql = "SELECT DISTINCT territorio_cd, territorio_ds FROM diaria.territorio WHERE territorio_st = 0 ORDER BY territorio_cd";
    }
    else
    {
        $sql = "SELECT DISTINCT t.territorio_cd, territorio_ds FROM diaria.territorio t, diaria.projeto_acao_territorio pat WHERE pat.acao_cd = '".$acao."' AND (t.territorio_cd = pat.territorio_cd) AND territorio_st = 0 ORDER BY t.territorio_cd";
    }
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------- Selecione ---------------------------------------------------------------------------------------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {
        if ($codigoEscolhido==($linha['territorio_cd']))
        {
            echo "<option value=" .$linha['territorio_cd']." selected>" .$linha['territorio_cd']. " ----> " .$linha['territorio_ds']. "</option>";
        }
        else
        {
            echo "<option value=" .$linha['territorio_cd'].">" .$linha['territorio_cd']." ----> " .$linha['territorio_ds']."</option>";
        }
    }
    echo "</select>";
}
/*
**************************************************
meio de transporte
**************************************************
 *
 */
function f_ComboMeioTransporte($codigoEscolhido)
{  echo "<select name=cmbMeioTransporte id=cmbMeioTransporte style=width:310px>";
    $sql = "SELECT * FROM diaria.meio_transporte WHERE meio_transporte_st = 0 ORDER BY UPPER(meio_transporte_ds)";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[-------------------------------------- Selecione -------------------------------------]</option>";
    echo "<option value=0></option>";
    while($linha=pg_fetch_assoc($rs))
    {  if ((int)$codigoEscolhido==(int)($linha['meio_transporte_id']))
    {  echo "<option value=" .$linha['meio_transporte_id']." selected>" .$linha['meio_transporte_ds']. "</option>";
    }
    else
    {  echo "<option value=".$linha['meio_transporte_id']. ">" .$linha['meio_transporte_ds']."</option>";
    }
    }
    echo "</select>";
}
/*
**************************************************
unidade de custo
**************************************************
 *
 */

function f_ComboAutorizador($codigoEscolhido,$Nome)
{  echo "<select id='cmbAutorizador' name=cmbAutorizador".$Nome." style=width:382px>";

    $sql = "SELECT f.pessoa_id, pessoa_nm FROM dados_unico.pessoa p ,dados_unico.funcionario f, seguranca.usuario_tipo_usuario utu WHERE (p.pessoa_id = utu.pessoa_id) AND (p.pessoa_id = f.pessoa_id) AND pessoa_st = 0 AND (tipo_usuario_id = 5 or tipo_usuario_id = 6) ORDER BY UPPER(pessoa_nm)";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[--------------------------------------------------- Selecione ------------------------------------------------]</option>";
    while($linha=pg_fetch_assoc($rs))
    {  if($codigoEscolhido != "")
    {  if ((int)$codigoEscolhido==(int)($linha['pessoa_id']))
    {   echo "<option value=" .$linha['pessoa_id']." selected>" .$linha['pessoa_nm']. "</option>";
    }
    else
    {  echo "<option value=" .$linha['pessoa_id']. ">" .$linha['pessoa_nm']. "</option>";
    }
    }
    else
    { echo "<option value=" .$linha['pessoa_id']. ">" .$linha['pessoa_nm']. "</option>";
    }
    }
    echo "</select>";
}

/**
 * Cria um combo com as fontes cadastradas na base de dados
 * @param numeric $codigoEscolhido <p>Código da fonte que deve ser selecionada no carregamento da pagina</p>
 * @param numeric $Tamanho <p>Tamanho em pixels do combo</p>
 * @param String  $FuncaoJavaScript [optional] <p>Funções Javascript do combo</p>
 */
function f_ComboFonte($codigoEscolhido, $Tamanho, $FuncaoJavaScript)
{  echo "<select name=cmbFonte id=cmbFonte style=width:".$Tamanho."px ".$FuncaoJavaScript.">";
    $sql = "SELECT * FROM diaria.fonte WHERE fonte_st = 0 ORDER BY fonte_cd";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value='0'>[--------------------------------------------------------------------------------------------------------- Selecione ---------------------------------------------------------------------------------------------------------]</option>";


    while($linha=pg_fetch_assoc($rs))
    {

        if($codigoEscolhido === "")
        {
            if (($linha['fonte_padrao'])===1)
            {   echo "<option value='" .$linha['fonte_cd']. "' selected>" .$linha['fonte_cd']. " - " .$linha['fonte_ds']. "</option>";


            }
            else
            {  echo "<option value='"  .$linha['fonte_cd']. "'>" .$linha['fonte_cd']. " - "  .$linha['fonte_ds']. "</option>";


            }
        }
        else
        {
            if ($codigoEscolhido===($linha['fonte_cd']))
            {  echo "<option value='" .$linha['fonte_cd']. "' selected>" .$linha['fonte_cd']. " - " .$linha['fonte_ds']. "</option>";


            }
            else
            { echo "<option value='" .$linha['fonte_cd']. "'>" .$linha['fonte_cd']. " - " .$linha['fonte_ds']. "</option>";


            }
        }
    }
    echo "</select>";
}
/*
**************************************************
municipio
**************************************************
 *
 */
function f_ComboMunicipioDiaria($codigoEscolhido)
{  echo "<select name=cmbMunicipio style=width:785>";
    $sql = "SELECT * FROM dados_unico.municipio WHERE estado_uf = '".$codigoEscolhido. "' ORDER BY UPPER(municipio_ds)";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------------------- Selecione --------------------------------------------------------------------------------------------------------------------]</option>";
    echo "<option value=0></option>";
    while($linha=pg_fetch_assoc($rs))
    {	$codigo=$linha['municipio_cd'];
        $descricao=$linha['municipio_ds'];
        echo "<option value=".$codigo.">" .$descricao."</option>";
    }
    echo "</select>";
}
/*************************************************
 ******* Combo do TIPO DE DOCUMENTO quando a ******
 ******* Diaria foi INDENIZADA ********************
 **************************************************/
function f_ComboDocumento($codigoEscolhido)
{
    echo "<select name=cmbDocumento style=width:240px >";
    $sqlConsulta = "SELECT * FROM diaria.diaria_tipo_doc";

    $rs=pg_query(abreConexao(),$sqlConsulta);
    echo "<option value=0>[-------------------------- Selecione --------------------------]</option>";
    echo "<option value=0></option>";
    while($linhars = pg_fetch_assoc($rs))
    {  if ($codigoEscolhido==($linhars['diaria_tipo_doc_id']))
    {
        echo "<option value=".$linhars['diaria_tipo_doc_id']. " selected>".$linhars['diaria_tipo_doc_ds']."</option>";
    }
    else
    {
        echo "<option value=" .$linhars['diaria_tipo_doc_id']. ">".$linhars['diaria_tipo_doc_ds']."</option>";
    }
    }
    echo "</select>";
}
function f_ValorReferencia($codigoEscolhido,$DataPartida)
{
    $TemporarioValor = false;
    $PermanenteValor = false;
    $sql = "SELECT cargo_temporario, cargo_permanente 
                FROM dados_unico.funcionario
                WHERE pessoa_id = '" .$codigoEscolhido."'";

    $rs = pg_query(abreConexao(),$sql);
    $linha = pg_fetch_assoc($rs);

    if ($linha['cargo_temporario'] != 0)
    {
        $CargoTemporario = $linha['cargo_temporario'];

        if (!empty($DataPartida))
        {
                $sql1   =  "SELECT cv.classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl, diaria.classe_valor cv  WHERE (ca.classe_id = cl.classe_id) AND cargo_id = '" .$CargoTemporario."' ";
                $sql1  .= "AND (cl.classe_id = cv.classe_id) AND '".$DataPartida."' BETWEEN classe_valor_dt_vigencia_inicio AND classe_valor_dt_vigencia_fim";
                $rs1    = pg_query(abreConexao(),$sql1);
                $linha1 = pg_fetch_assoc($rs1);

                if (!$linha1)
                {
                    $sql1   = "SELECT cv.classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl, diaria.classe_valor cv  WHERE (ca.classe_id = cl.classe_id) AND cargo_id = '" .$CargoTemporario."' ";
                    $sql1  .="AND (cl.classe_id = cv.classe_id) AND classe_valor_st = 0 ";
                    $rs1    = pg_query(abreConexao(),$sql1);
                    $linha1 = pg_fetch_assoc($rs1);
                }
        }
        else
        {
            $sql1   = "SELECT cv.classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl, diaria.classe_valor cv  WHERE (ca.classe_id = cl.classe_id) AND cargo_id = '" .$CargoTemporario."' ";
            $sql1  .="AND (cl.classe_id = cv.classe_id) AND classe_valor_st = 0 ";
            $rs1    = pg_query(abreConexao(),$sql1);
            $linha1 = pg_fetch_assoc($rs1);
        }

        $TemporarioValor = true;
    }
    if($linha['cargo_permanente'] != 0)
    {
        $CargoPermanente = $linha['cargo_permanente'];

        if (!empty($DataPartida))
        {
                $sql2   = "SELECT cv.classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl, diaria.classe_valor cv  WHERE (ca.classe_id = cl.classe_id) AND cargo_id = '" .$CargoPermanente."' ";
                $sql2  .="and (cl.classe_id = cv.classe_id) and '".$DataPartida."' between classe_valor_dt_vigencia_inicio and classe_valor_dt_vigencia_fim";
                $rs2    = pg_query(abreConexao(),$sql2);
                $linha2 = pg_fetch_assoc($rs2);

                if (!$linha2)
                {
                    $sql2   = "SELECT cv.classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl, diaria.classe_valor cv  WHERE (ca.classe_id = cl.classe_id) AND cargo_id = '" .$CargoPermanente."' ";
                    $sql2  .="and (cl.classe_id = cv.classe_id) and classe_valor_st = 0 ";
                    $rs2    = pg_query(abreConexao(),$sql2);
                    $linha2 = pg_fetch_assoc($rs2);
                }
        }
        else
        {
            $sql2   = "SELECT cv.classe_valor, classe_nm FROM dados_unico.cargo ca, diaria.classe cl, diaria.classe_valor cv  WHERE (ca.classe_id = cl.classe_id) AND cargo_id = '" .$CargoPermanente."' ";
            $sql2  .="and (cl.classe_id = cv.classe_id) and classe_valor_st = 0 ";
            $rs2    = pg_query(abreConexao(),$sql2);
            $linha2 = pg_fetch_assoc($rs2);
        }
        $PermanenteValor = true;
    }

    if (($TemporarioValor) && ($PermanenteValor) )
    {
        if ((int)($linha1['classe_valor']) > (int)($linha2['classe_valor']))
        {
            $ValorDiaria = $linha1['classe_valor'];
            $ValorDiariaDescricao = $linha1['classe_nm'];
        }
        else
        {
            $ValorDiaria =$linha2['classe_valor'];
            $ValorDiariaDescricao =$linha2['classe_nm'];
        }
    }
    elseif($TemporarioValor)
    {
        $ValorDiaria= $linha1['classe_valor'];
        $ValorDiariaDescricao = $linha1['classe_nm'];
    }
    elseif($PermanenteValor)
    {
        $ValorDiaria = $linha2['classe_valor'];
        $ValorDiariaDescricao = $linha2['classe_nm'];
    }
    echo "<input type='hidden' name='txtValorReferencia' id='txtValorReferencia' value='".$ValorDiaria."' style='width:75px; height:18px;' />".number_format($ValorDiaria, 2, ',', '.')." referente a Classe " .$ValorDiariaDescricao;

}

function date_converter($_date = null) {
    $format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
    if ($_date != null && preg_match($format, $_date, $partes)) {
        return $partes[3].'-'.$partes[2].'-'.$partes[1];
    }
    return false;
}



function f_ConsultaBloqueioSolicitante($Beneficiario)
    /* Esta função foi feita para retornar no momneto da aprovação da diaria exibir Pendências que existam no beneficiário
    Solicitações para Aprovar >> no fim da página antes do botão aprovar. *** Danillo 01-12-2010 11:33 AM ***
    */
{	$dataExtra=date("d/m/Y");

    $sqlConsultaBloq = "SELECT dd.diaria_id, dd.diaria_numero, dd.diaria_dt_chegada, dd.diaria_valor, dd.diaria_st, dd.diaria_comprovada, ddf.diaria_execucao_dt 
						FROM diaria.diaria dd LEFT JOIN diaria.diaria_financeiro ddf ON (dd.diaria_id = ddf.diaria_id) 
						WHERE ((dd.diaria_st >=3 ) and (dd.diaria_st <= 5)) AND (dd.diaria_beneficiario = ".$Beneficiario." AND dd.diaria_comprovada <> 1) AND (to_date(dd.diaria_dt_chegada,'DD/MM/YYYY') <=  ('".$dataExtra."'))
						ORDER BY diaria_id";

    //$sqlConsultaBloq = "SELECT diaria_id, diaria_numero, diaria_dt_chegada, diaria_valor, diaria_st, diaria_comprovada FROM diaria.diaria WHERE ((diaria_st >=3 ) and (diaria_st <= 5) AND diaria_comprovada <> 1) AND (diaria_beneficiario = " .$Beneficiario. " and (to_date(diaria_dt_chegada,'DD/MM/YYYY') <= ('".$dataExtra."'))) ORDER BY diaria_id";

    $rsBloq = pg_query(abreConexao(),$sqlConsultaBloq);
    $cont = 1;
    $cor  = 1;
    $flag = 0;

    while ($linharsBloq = pg_fetch_assoc($rsBloq))
    {
        if ($flag == 0 )
        {
            include "../Include/Inc_Linha.php";
            echo ("<table width='800' border='1' cellpadding='0' bordercolor='#FF0000' cellspacing='0' class='TabelaFormulario'>");
            echo("<tr>");
            echo("<td>");
            echo("<table width='100%' border='0' cellpadding='0' cellspacing='1'>");
            echo("<tr height='21'>");
            echo("<td class='dataTitulo' width='320' colspan='8'>&nbsp;Pend&ecirc;ncias</td>");
            echo("</tr>");
            echo("<tr height='21'>");
            echo("<td width='1%' class='dataLabel'>&nbsp;#</td>");
            echo("<td width='17%' class='dataLabel'>&nbsp;N&uacute;mero</td>");
            echo("<td width='13%' class='dataLabel'>&nbsp;Dias de atraso</td>");
            echo("<td width='13%' class='dataLabel'>&nbsp;Pago</td>");
            echo("<td width='15%' class='dataLabel'>&nbsp;Dias ap&oacute;s Pgto</td>");
            echo("<td width='12%' class='dataLabel'>&nbsp;Data Retorno</td>");
            echo("<td width='10%' class='dataLabel'>&nbsp;Valor</td>");
            echo("<td width='19%' class='dataLabel'>&nbsp;Status</td>");
            echo("</tr>");
            $flag ++;
        }//fim do if do flag == 0
        if($cor == 1)
        {
            $classe = "dataField";
        }
        else
        {
            $classe = "dataField2";
        }
        $cor *= -1;

        echo "<tr>";
        echo "  <td height='21' class='$classe'>&nbsp;<b>".$cont++."&nbsp;</b></td>";
        echo "  <td height='21' class='$classe'>&nbsp;".$linharsBloq['diaria_numero']."</td>";
        echo "  <td height='21' class='$classe'>&nbsp;".f_CalculaAtraso($linharsBloq['diaria_dt_chegada'])." Dia(s)</td>";
        echo "  <td height='21' class='$classe'>&nbsp;";

        if ($linharsBloq['diaria_execucao_dt'] != "")
        {
            include_once "../Include/Inc_funcao.php";
            $DataFormatada = f_FormataData($linharsBloq['diaria_execucao_dt']);
            $DataFormatada = f_CalculaAtraso($DataFormatada);
            $Img = "<img src='../Imagens/diarias_pagas_on.png' alt='Credito Efetuado em  : ".f_FormataData($linharsBloq['diaria_execucao_dt'])."' />";

            $DataFormatada = $DataFormatada ." Dia(s) ";
        }
        else
        {
            $Img = "<img src='../Imagens/diarias_pagas_off.png' alt='Falta Pagamento da Diaria".f_FormataData($linharsBloq['diaria_execucao_dt'])."' />";
            $DataFormatada = 0;
            $DataFormatada = $DataFormatada ." Dia(s) ";
        }
        echo  $Img." </td>";
        echo  "<td class='$classe'>&nbsp;". $DataFormatada." </td>";
        echo "  <td class='$classe'>&nbsp;".$linharsBloq['diaria_dt_chegada']."</td>";
        echo "  <td class='$classe'>&nbsp;".$linharsBloq['diaria_valor']."</td>";
        echo "  <td class='$classe'>&nbsp;".f_RetornaStatus($linharsBloq['diaria_st'])."</td>";

        echo "</tr>";
    }//fim do while

    if ($flag >=1)
    {
        echo("</table>");
        echo("</td>");
        echo("</tr>");
        echo("</table>");
    }//fim do if flag >= 1


}//fim da função f_ConsultaBloqueioSolicitante

function f_RetornaStatus ($Status)
{
    switch ($Status)
    {
        case 0:	$StatusNome = "Aguardando Autorização";                 break;
        case 1:	$StatusNome = "Aguardando Aprovação";                   break;
        case 2:	$StatusNome = "Aguardando Empenho";                     break;
        case 3:	$StatusNome = "Aguardando Pagamento"; 			break;
        case 4:	$StatusNome = "Aguardando Comprovação";                 break;
        case 5:	$StatusNome = "Aguardando Documentação";                break;
        case 6:	$StatusNome = "Aguardando 2° Empenho";                  break;
        case 7:	$StatusNome = "Aguardando 2° Pagamento";                break;
        case 8:	$StatusNome = "Aguardando Análise Financeira";		break;
        case 9:	$StatusNome = "Concluída";				break;
    }
    return $StatusNome;
}

function f_CalculaAtraso($data)
{
    If ($linharsBloq['diaria_comprovada'] != "1")
    {
        $dataBanco= $data;
        $dataBanco= explode("/", $dataBanco);
        //A função mktime recebe os argumentos (hora, minuto, segundos, mes, dia, ano).
        $diaBanco = mktime(0,0,0,$dataBanco[1],$dataBanco[0],$dataBanco[2]);
        $dataAtual=date("d-m-Y");
        $dataAtual=explode("-", $dataAtual);
        $diaAtual = mktime(0,0,0,$dataAtual[1],$dataAtual[0],$dataAtual[2]);
        $diferencaDataTempo = ($diaAtual-$diaBanco);
        //converte o tempo em dias
        $DiferencaDias = round(($diferencaDataTempo/60/60/24));
    }
    if (isset($DiferencaDias))
    {	return $DiferencaDias;}
    else
    {	return $DiferencaDias = 0;}
}
//* montar  numero de processo a partir do numero de solicitação gerado no sistema, nestea caso foi DE: SD  gerando numero de processo para  diarias
//* ex: N. SD 201002345   gerou 14 2010 9 0 02345  (1420109002345)
function f_NumeroProcesso($NumSD)
{
    $DTAno        = date("Y");
    $DTAno        = substr($DTAno,1,3); //tira o 20 e ficar s� o 11 0710119000063
    $DTAno        = "0710".$DTAno."9";
    $Zeros 	      = "0";
    $TamanhoSD    = strlen ($NumSD);
    $NumDiaria    = substr($NumSD,2,$TamanhoSD);
    return $Processo = $DTAno.$Zeros.$NumDiaria;
}
?>
