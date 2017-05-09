<?php
function DadosResumoComprovacao ($Codigo) 
{
    $Codigo = $_GET['cod'];
    $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_motivo dm, diaria.diaria_comprovacao dc, diaria.diaria_financeiro df WHERE (d.diaria_id = df.diaria_id) AND (d.diaria_id = dc.diaria_id) AND (d.diaria_id = dm.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    $linhaConsulta=pg_fetch_assoc($rsConsulta);

    If(!$linhaConsulta) 
    {
        $sqlConsulta = "SELECT * FROM diaria.diaria d, dados_unico.funcionario f, dados_unico.pessoa p, diaria.diaria_motivo dm, diaria.diaria_comprovacao dc  WHERE (d.diaria_id = dc.diaria_id) AND (d.diaria_id = dm.diaria_id) AND (p.pessoa_id = f.pessoa_id) AND (d.diaria_beneficiario = f.pessoa_id) AND d.diaria_id = ".$Codigo;
        $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        $linhaConsulta=pg_fetch_assoc($rsConsulta);
    }

    If($linhaConsulta) 
    {
        $Numero 	= $linhaConsulta['diaria_numero'];
        $Solicitante    = $linhaConsulta['diaria_solicitante'];
        $Beneficiario   = $linhaConsulta['diaria_beneficiario'];
        $Nome           = $linhaConsulta['pessoa_nm'];

        $HoraPartida	 = $linhaConsulta['diaria_hr_saida'];
        $DataPartida	 = $linhaConsulta['diaria_dt_saida'];
        $DataChegada	 = $linhaConsulta['diaria_dt_chegada'];
        $HoraChegada	 = $linhaConsulta['diaria_hr_chegada'];

        $HoraPartidaEfetiva = $linhaConsulta['diaria_comprovacao_hr_saida'];
        $DataPartidaEfetiva = $linhaConsulta['diaria_comprovacao_dt_saida'];
        $DataChegadaEfetiva = $linhaConsulta['diaria_comprovacao_dt_chegada'];
        $HoraChegadaEfetiva = $linhaConsulta['diaria_comprovacao_hr_chegada'];

        $DataLiquidacao  = $linhaConsulta['diaria_financeiro_dt_obrigacao'];
        $HoraLiquidacao  = $linhaConsulta['diaria_financeiro_hr_obrigacao'];       
        $DataExecucao    = $linhaConsulta['diaria_financeiro_dt_execucao'];
        $DataCriacao 	 = $linhaConsulta['diaria_dt_criacao'];
        $HoraCriacao 	 = $linhaConsulta['diaria_hr_criacao'];
        $DataComprovacao = $linhaConsulta['diaria_comprovacao_dt'];
        $HoraComprovacao = $linhaConsulta['diaria_comprovacao_hr'];

        $DiaSemanaPartida = diasemana($DataPartida);
        $DiaSemanaChegada = diasemana($DataChegada);

        $JustificativaFimSemana = $linhaConsulta['diaria_justificativa_fds'];
        $JustificativaFeriado  	= $linhaConsulta['diaria_justificativa_feriado'];
        $MeioTransporte		= $linhaConsulta['meio_transporte_id'];
        $TransporteObservacao 	= $linhaConsulta['diaria_transporte_obs'];
        $RoteiroComplemento	= $linhaConsulta['diaria_roteiro_complemento'];
        $Desconto 		= $linhaConsulta['diaria_desconto'];
        $Qtde			= $linhaConsulta['diaria_qtde'];
        $Valor			= $linhaConsulta['diaria_valor'];
        $ValorRef	 	= $linhaConsulta['diaria_valor_ref'];
        $Motivo			= $linhaConsulta['motivo_id'];
        $SubMotivo		= $linhaConsulta['sub_motivo_id'];
        $Descricao 		= $linhaConsulta['diaria_descricao'];
        $UnidadeCusto           = $linhaConsulta['diaria_unidade_custo'];
        $Projeto 		= $linhaConsulta['projeto_cd'];
        $Acao 			= $linhaConsulta['acao_cd'];
        $Territorio             = $linhaConsulta['territorio_cd'];
        $Fonte 			= $linhaConsulta['fonte_cd'];
        $Status 		= $linhaConsulta['diaria_st'];
        $DataCriacao            = $linhaConsulta['diaria_dt_criacao'];
        $HoraCriacao            = $linhaConsulta['diaria_hr_criacao'];
        $Processo 		= $linhaConsulta['diaria_processo'];
        $Empenho 		= $linhaConsulta['diaria_empenho'];
        $DataEmpenho            = $linhaConsulta['diaria_dt_empenho'];
        $RoteiroComplemento     = $linhaConsulta['diaria_roteiro_complemento'];
        $Resumo                 = $linhaConsulta['diaria_comprovacao_resumo'];


        $diaria_comprovacao_saldo_tipo  = $linhaConsulta['diaria_comprovacao_saldo_tipo'];
        $diaria_comprovacao_saldo       = $linhaConsulta['diaria_comprovacao_saldo'];
        // Corrigir o sinal ..
        $diaria_comprovacao_saldo 	= str_replace(".","",$diaria_comprovacao_saldo);
        $diaria_comprovacao_saldo 	= str_replace(",",".",$diaria_comprovacao_saldo);
        
        if ($diaria_comprovacao_saldo < 0) 
        {
            $diaria_comprovacao_saldo = $diaria_comprovacao_saldo*(-1);
        }

        $Complemento = $linhaConsulta['diaria_comprovacao_complemento'];

        If ($Complemento == "1") 
        {
            $ComplementoJustificativa = $linhaConsulta['diaria_comprovacao_complemento_justificativa'];
        }


        If ($Desconto == "N") 
        {
            $Desconto = "N&atilde;o";
            $DescontoMarcado = "";
        }
        Else 
        {
            $Desconto = "Sim";
            $DescontoMarcado = "checked";
        }
?>
        <table width="800" border="0" cellpadding="0" cellspacing="0" class="TabelaFormulario">
            <tr>
                <td>
                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                        <tr height="21" class="dataTitulo">
                            <td width="399" colspan="8">Dados da Solicitação</td>
                        </tr>
                        <tr height="21" class="dataTitulo">
                            <td width="359" colspan="3">Partida Prevista</td>
                            <td width="359" colspan="3">Chegada Prevista</td>
                            <td width="160" colspan="2">Quantidade e Valor Previsto</td>
                        </tr>
                        <tr height="21" class="dataLabel">
                            <td width="80">Data</td>
                            <td width="80">Hora</td>
                            <td width="139">Dia da Semana</td>
                            <td width="80">Data</td>
                            <td width="80">Hora</td>
                            <td width="139">Dia da Semana</td>
                            <td width="80">Qtde Di&aacute;rias</td>
                            <td width="120">Valor Total</td>
                        </tr>
                        <tr height="21" class="dataField">
                            <td width="80"><?=$DataPartida?></td>
                            <td width="80"><?=$HoraPartida?></td>
                            <td width="139"><?=diasemana($DataPartida)?></td>
                            <td width="80"><?=$DataChegada?></td>
                            <td width="80"><?=$HoraChegada?></td>
                            <td width="139"><?=diasemana($DataChegada)?></td>
                            <td width="80"><?=$Qtde?></td>
                            <td width="120"><?=$Valor?></td>
                        </tr>
                    </table>
                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                        <tr height="21" class="dataTitulo">
                            <td width="399" colspan="6">Dados da Comprovação</td>
                        </tr>
                        <tr height="21" class="dataTitulo">
                            <td width="399" colspan="3">Partida Realizada</td>
                            <td width="399" colspan="3">Chegada Realizada</td>
                        </tr>
                        <tr height="21" class="dataLabel">
                            <td width="100">Data</td>
                            <td width="100">Hora</td>
                            <td width="199">Dia da Semana</td>
                            <td width="100">Data</td>
                            <td width="100">Hora</td>
                            <td width="199">Dia da Semana</td>
                        </tr>
                        <tr height="21" class="dataField">
                            <td width="100"><?=$DataPartidaEfetiva?></td>
                            <td width="100"><?=$HoraPartidaEfetiva?></td>
                            <td width="199"><?=diasemana($DataPartidaEfetiva)?></td>
                            <td width="100"><?=$DataChegadaEfetiva?></td>
                            <td width="100"><?=$HoraChegadaEfetiva?></td>
                            <td width="199"><?=diasemana($DataChegadaEfetiva)?></td>
                        </tr>
                    </table>
                    <table width="798" border="0" cellpadding="0" cellspacing="1">
                        <tr height="21" class="dataLabel">
                            <td width="100">Redu&ccedil;&atilde;o 50%</td>
                            <td width="166">Valor Refer&ecirc;ncia (Descri&ccedil;&atilde;o)</td>
                            <td width="133">Valor do Roteiro</td>
                            <td width="99">Qtde Di&aacute;rais</td>
                            <td width="100">Valor Total</td>
                            <td width="100">A Restituir</td>
                            <td width="100">A Receber</td>
                        </tr>
                        <tr height="21" class="dataField">
                            <td width="100"><font color='#CC9933'><?=$Desconto?></font></td>
                            <td width="166"><font color='#CC9933'><?=f_ValorReferencia($Beneficiario)?></font></td>
                            <td width="133"><font color='#CC9933'><?=$ValorRef?></font></td>
                            <?php 
                            $linha = pg_fetch_assoc($rsConsulta);
                            ?>
                            <td width="99"><font color='#CC9933'>&nbsp;<?=$linhaConsulta['diaria_comprovacao_qtde']?></font></td>
                            <td width="100"><font color='#CC9933'>&nbsp;<?=$linhaConsulta['diaria_comprovacao_valor']?></font></td>
                            <?php
                            if ($diaria_comprovacao_saldo_tipo == "D") 
                            {
                                echo "<td width=100><font color='#CC9933'>R$ ".number_format($diaria_comprovacao_saldo, 2, ',', '.')."</font></td>";
                                echo "<td width=100><font color='#CC9933'>R$ 0,00</font></td>";
                            }
                            else
                            {
                                echo "<td width=100><font color='#CC9933'>R$ 0,00</font></td>";
                                echo "<td width=100><font color='#CC9933'>R$ ".number_format($diaria_comprovacao_saldo, 2, ',', '.')."</font></td>";
                            }
                            ?>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
<?php
    }
}
?>
