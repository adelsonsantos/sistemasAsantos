<?php
include "../Include/Inc_Configuracao.php";
include "Classe/ClasseDiariaImpressao.php";
?>
<style>
    .table thead tr {
        background-color: #dcdedd;
    }

    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    .table td {
        height: 25px;
        background-color: white;
    }

    .th-left {
        text-align: left;
        height: 25px;
    }

    #spacer {
        height: 2em;
    }

    fieldset {
        display: block;
        padding-top: 0.35em;
        padding-bottom: 0.625em;
        padding-left: 0.75em;
        padding-right: 0.75em;
        border: 2px groove (internal value);
    }

    .button {
        background-color: #008CBA; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: none;
        font-size: 16px;
        margin-left: 90%;
    }

    #html-content-holder {
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
    }
</style>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>
</head>
<body>

<a id="btn-Convert-Html2Image" class="button" href="#">Download</a>

<div id="html-content-holder" style="background-color: #F0F0F1; width: 100%;
        padding-left: 25px; padding-top: 10px;">
    <div>
        <table style="height: 50px; width: 98%; margin-right: 10%">
            <tr>
                <td style="width: 20%; text-align: center"><img src="../Imagens/adab.png"
                                                                style="width: 80px; margin-bottom: 10px; margin-top: 10px">
                </td>
                <td style="width: 600px; text-align: center">
                    <h2>Comprovação de Diárias</h2>
                </td>
            </tr>
        </table>
        <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
            <legend>Dados da Diária:</legend>
            <table class="table"
                   style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left">Área Beneficiária</th>
                    <th class="th-left">Processo</th>
                    <th class="th-left">Empenho</th>
                    <th class="th-left">N° Diária</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $UnidadeCustoNome; ?></td>
                    <td><?= $Processo; ?></td>
                    <td><?= $Empenho; ?></td>
                    <td><?= $Numero; ?></td>
                </tr>
                </tbody>
            </table>
        </fieldset>
        <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
            <legend>Dados do Beneficiário:</legend>
            <table class="table"
                   style="width: 102%; margin-bottom: -1px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left">Nome</th>
                    <th class="th-left">Matrícula</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td><?= utf8_decode($BeneficiarioNome); ?></td>
                    <td><?= $Matricula; ?></td>
                </tr>
                </tbody>
            </table>

            <table class="table"
                   style="width: 102%; margin-bottom: -1px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left" style="width: 51%"> Lotação</th>
                    <th class="th-left" style="width: 51%"> ACP</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="white-space: nowrap;"><?= $EstruturaAtuacaoNome; ?></td>
                    <td style="white-space: nowrap;"><?= $UnidadeCustoNumero . "-" . $UnidadeCustoNome; ?></td>
                </tr>
                </tbody>
            </table>

            <table class="table"
                   style="width: 102%; margin-bottom: -1px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left" style="width: 51%"> Cargo/Função</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td style="white-space: nowrap;"><?= $CargoNome; ?></td>
                </tr>
                </tbody>
            </table>

            <table class="table"
                   style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left" style="width: 51%"> CPF</th>
                    <th class="th-left" style="width: 51%">Dados Bancários</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td><?= $CPF; ?></td>
                    <?php $ContaTipo = $ContaTipo == 'C' ? 'CC' : 'CP'?>
                    <td><?= "Banco: " . $Banco . " - Agencia: " . $Agencia . " - ".$ContaTipo.": " . $Conta; ?></td>
                </tr>
                </tbody>
            </table>
        </fieldset>
        <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
            <legend>Projeto</legend>
            <table class="table"
                   style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left">Projeto</th>
                    <th class="th-left">Produto</th>
                    <th class="th-left">Território</th>
                    <th class="th-left">Fonte</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $Projeto; ?></td>
                    <td><?= $Acao; ?></td>
                    <td><?= $Territorio; ?></td>
                    <td><?= $Fonte; ?></td>
                </tr>
                </tbody>
            </table>
        </fieldset>

        <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
            <legend>Motivo</legend>
            <table class="table"
                   style="width: 102%; margin-bottom: -1px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left">Motivo da Viagem</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php

                        $str = $Descricao;
                        $arrayStr = explode(".", $str);
                        foreach ($arrayStr as $key) {
                            if (!empty($key)) {
                                echo "<p style='text-align: justify'>$key." . "</p>";
                            }
                        }
                        ?><br></td>
                </tr>
                </tbody>
            </table>

            <table class="table"
                   style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left" style="width: 315px"> Justificativa do Fim de Semana e Feriado</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td style="text-align: justify;"><?= $JustificativaFimSemana . $JustificativaFeriado; ?></td>
                </tr>
                </tbody>
            </table>
        </fieldset>

        <?php

        if ($qtdeRoteiros > 0) {
            $controle = 0;
            while ($controle < $qtdeRoteiros) {
                $sqlConsultaMultiplo = " SELECT drm.diaria_valor_ref as solicitacaoreferencia ,drmc.diaria_comprovacao_valor_ref as referencia, dc.diaria_comprovacao_valor_ref, drm.diaria_dt_saida,drm.diaria_hr_saida,drm.diaria_dt_chegada,drm.diaria_hr_chegada,drm.diaria_qtde, drm.diaria_valor, drm.diaria_desconto,
                                        drmc.dados_roteiro_comprovacao_id, drmc.diaria_comprovacao_dt_saida,drmc.diaria_comprovacao_hr_saida,drmc.diaria_comprovacao_dt_chegada,drmc.diaria_comprovacao_hr_chegada,drmc.diaria_comprovacao_qtde,drmc.diaria_comprovacao_valor,drmc.diaria_resumo_comprovacao,drmc.dados_roteiro_comprovacao_id,drmc.diaria_comprovacao_desconto,drmc.diaria_comprovacao_saldo,drmc.diaria_comprovacao_saldo_tipo,diaria_roteiro_comprovacao_complemento,
                                        dc.diaria_comprovacao_qtde AS qtde_total, dc.diaria_comprovacao_valor AS valor_total, dc.diaria_comprovacao_saldo AS saldo_total ,dc.diaria_comprovacao_saldo_tipo AS saldo_tipo_total
                                 FROM diaria.dados_roteiro_multiplo drm
                                 JOIN diaria.dados_roteiro_multiplo_comprovacao drmc ON drm.diaria_id = drmc.diaria_id
                                 JOIN diaria.diaria_comprovacao dc ON dc.diaria_id = drmc.diaria_id
                                 WHERE dc.diaria_id = $Codigo
                                 AND controle_roteiro = $controle
                                 AND drmc.controle_roteiro_comprovacao = $controle
                                 AND dados_roteiro_status = 0";

                $rsConsultaMultiplo = pg_query(abreConexao(), $sqlConsultaMultiplo);
                $linhaConsultaMultiplo = pg_fetch_assoc($rsConsultaMultiplo);
                $Resumo = $linhaConsultaMultiplo['diaria_resumo_comprovacao'];
                ?>


                <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
                    <legend>Roteiro <?= $controle + 1; ?></legend>
                    <?php
                    $sqlRoteiroMultiplo = "SELECT roteiro_comprovacao_origem, roteiro_comprovacao_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = " . $Codigo . " AND controle_roteiro_comprovacao = " . $controle;
                    $rsRoteiroMultiplo = pg_query(abreConexao(), $sqlRoteiroMultiplo);

                    $qtdDeRegistro = pg_num_rows($rsRoteiroMultiplo);
                    $Contador = $qtdDeRegistro;
                    $i = 1;
                    $RoteiroComprovacao = "";
                    $Meio = "";

                    While ($linharsRoteiro = pg_fetch_assoc($rsRoteiroMultiplo)) {
                        $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linharsRoteiro['roteiro_comprovacao_origem'];
                        $rsRoteiroOrigem = pg_query(abreConexao(), $sqlRoteiroOrigem);
                        $linharsRoteiroOrigem = pg_fetch_assoc($rsRoteiroOrigem);

                        $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linharsRoteiro['roteiro_comprovacao_destino'];
                        $rsRoteiroDestino = pg_query(abreConexao(), $sqlRoteiroDestino);
                        $linharsRoteiroDestino = pg_fetch_assoc($rsRoteiroDestino);


                        If ($i == 1) {
                            $Inicio = $linharsRoteiroOrigem['municipio_ds'] . " - (" . $linharsRoteiroOrigem['estado_uf'] . ")" . " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
                        } Elseif (($i != 1) && ($i < $Contador)) {
                            $Meio = $Meio . " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
                        } Elseif ($i == $Contador) {
                            $Final = " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
                        }

                        // $RoteiroComprovacao .= " " . $linharsRoteiroOrigem['municipio_ds'] . " - " . $linharsRoteiroOrigem['estado_uf'] ;
                        $i++;
                    }
                    $RoteiroComprovacao = $Inicio . $Meio . $Final;
                    ?>
                    <table class="table"
                           style="width: 102%; margin-bottom: -1px; margin-left: -1%; px font-size: 13px;">
                        <thead>
                        <tr class="vendorListHeading">
                            <th class="th-left">Destino</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <p> <?= $RoteiroComprovacao ?><br><br></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table"
                           style="width: 102%;  margin-left: -1%; px font-size: 13px;">
                        <thead>
                        <tr class="vendorListHeading">
                            <th class="th-left" style="width:25%; white-space: nowrap">Partida Prevista</th>
                            <th class="th-left" style="width:25%; white-space: nowrap">Chegada Prevista</th>
                            <th class="th-left" style="width:50%; white-space: nowrap">Diárias Recebidas</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="white-space: nowrap; text-align: center">
                                <?= $linhaConsultaMultiplo['diaria_dt_saida'] . " às " . $linhaConsultaMultiplo['diaria_hr_saida']; ?>
                                <hr>
                                <?= diasemana($linhaConsultaMultiplo['diaria_dt_saida']); ?>
                            </td>
                            <td style="white-space: nowrap; text-align: center">
                                <?= $linhaConsultaMultiplo['diaria_dt_chegada'] . " às " . $linhaConsultaMultiplo['diaria_hr_chegada']; ?>
                                <hr>
                                <?= diasemana($linhaConsultaMultiplo['diaria_dt_chegada']); ?>
                            </td>
                            <td style="white-space: nowrap; text-align: center">
                                <table class="table"
                                       style="height: 101%; width: 100%; font-size: 13px;">
                                    <thead>
                                    <th class="th-left" style="text-align: center">Quantidade</th>
                                    <th class="th-left" style="text-align: center">Valor Total</th>
                                    <th class="th-left" style="white-space: nowrap; text-align: center">Unitário</th>
                                    </thead>
                                    <tbody>
                                    <td style="white-space: nowrap; text-align: center"><?= $linhaConsultaMultiplo['diaria_qtde']; ?></td>
                                    <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($linhaConsultaMultiplo['diaria_valor'], 2, ',', '.'); ?></td>
                                    <td style="white-space: nowrap; text-align: center">
                                        <?= !empty($linhaConsultaMultiplo['solicitacaoreferencia']) ? number_format($linhaConsultaMultiplo['solicitacaoreferencia'], 2) : $ValorRef; ?>
                                    </td>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table"
                           style="width: 102%; margin-left: -1%; px font-size: 13px;">
                        <tr class="vendorListHeading">
                            <th class="th-left" style="width:25%; white-space: nowrap">Partida Efetiva</th>
                            <th class="th-left" style="width:25%; white-space: nowrap">Chegada Efetiva</th>
                            <th class="th-left" style="width:30%; white-space: nowrap">Diárias Utilizadas</th>
                            <th class="th-left" style="width:20%; white-space: nowrap">Saldo</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="white-space: nowrap; text-align: center">
                                <?= $linhaConsultaMultiplo['diaria_comprovacao_dt_saida'] . " às " . $linhaConsultaMultiplo['diaria_comprovacao_hr_saida']; ?>
                                <hr>
                                <?= diasemana($linhaConsultaMultiplo['diaria_comprovacao_dt_saida']); ?>
                            </td>
                            <td style="white-space: nowrap; text-align: center">
                                <?= $linhaConsultaMultiplo['diaria_comprovacao_dt_chegada'] . " às " . $linhaConsultaMultiplo['diaria_comprovacao_hr_chegada']; ?>
                                <hr>
                                <?= diasemana($linhaConsultaMultiplo['diaria_comprovacao_dt_chegada']); ?>
                            </td>
                            <td style="white-space: nowrap; text-align: center">
                                <table class="table"
                                       style="height: 101%; width: 100%; font-size: 13px;">
                                    <thead>
                                    <th class="th-left" style="text-align: center">Quantidade</th>
                                    <th class="th-left" style="text-align: center">Valor Total</th>
                                    <th class="th-left" style="white-space: nowrap; text-align: center">Unitário</th>
                                    </thead>
                                    <tbody>
                                    <td style="white-space: nowrap; text-align: center"><?= $linhaConsultaMultiplo['diaria_comprovacao_qtde']; ?></td>
                                    <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($linhaConsultaMultiplo['diaria_comprovacao_valor'], 2, ',', '.'); ?></td>
                                    <td style="white-space: nowrap; text-align: center">
                                        <?php echo !empty($linhaConsultaMultiplo['referencia']) ? 'R$ ' . number_format($linhaConsultaMultiplo['referencia'], 2) : 'R$ ' . number_format($linhaConsultaMultiplo['diaria_comprovacao_valor_ref'], 2);  ?>
                                    </td>
                                    </tbody>
                                </table>
                            </td>

                            <td style="white-space: nowrap; text-align: center">
                                <table class="table"
                                       style="height: 101%; width: 100%; font-size: 13px;">
                                    <?php if ($linhaConsultaMultiplo['diaria_comprovacao_saldo_tipo'] == "D") {
                                        $saldoReceber = '0,00';
                                        $saldoRestituir = $linhaConsultaMultiplo['diaria_comprovacao_saldo'];
                                    } elseif ($linhaConsultaMultiplo['diaria_comprovacao_saldo_tipo'] == "C") {
                                        $saldoReceber = $linhaConsultaMultiplo['diaria_comprovacao_saldo'];
                                        $saldoRestituir = '0,00';
                                    } else {
                                        $saldoReceber = '0,00';
                                        $saldoRestituir = '0,00';
                                    } ?>
                                    <thead>
                                    <th class="th-left" style="text-align: center">A Receber</th>
                                    <th class="th-left" style="white-space: nowrap; text-align: center">A Restituir</th>
                                    </thead>
                                    <tbody>
                                    <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($saldoReceber, 2); ?></td>
                                    <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($saldoRestituir, 2); ?></td>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table"
                           style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                        <thead>
                        <tr class="vendorListHeading">
                            <th class="th-left" style="width: 315px; text-align: center"> Relatório de Atividades:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="">
                            <td style="text-align: justify;"><?= $Resumo . "<br>"; ?>
                                <br></td>
                        </tr>
                        </tbody>
                    </table>

                </fieldset>

                <?php $controle++;
            }

            if ($linhaConsultaMultiplo['saldo_tipo_total'] == "D") {
                $saldoReceber = '0,00';
                $saldoRestituir = $linhaConsultaMultiplo['saldo_total'];
            } elseif ($linhaConsultaMultiplo['saldo_tipo_total'] == "C") {
                $saldoReceber = $linhaConsultaMultiplo['saldo_total'];
                $saldoRestituir = '0,00';
            } else {
                $saldoReceber = '0,00';
                $saldoRestituir = '0,00';
            } ?>

            <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
                <legend>Total:</legend>
                <table class="table"
                       style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading">
                        <th class="th-left" style="text-align: center">Total de Diárias:</th>
                        <th class="th-left" style="text-align: center">Valor Total:</th>
                        <th class="th-left" style="text-align: center">A Receber:</th>
                        <th class="th-left" style="text-align: center">A Restituir:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="white-space: nowrap; text-align: center"><?= $linhaConsultaMultiplo['qtde_total']; ?></td>
                        <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($linhaConsultaMultiplo['valor_total'], 2, ',', '.'); ?></td>
                        <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($saldoReceber, 2, ',', '.'); ?></td>
                        <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($saldoRestituir, 2, ',', '.'); ?></td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
        <?php } else {
            $sqlRoteiro = "SELECT roteiro_comprovacao_origem, roteiro_comprovacao_destino FROM diaria.roteiro_comprovacao WHERE diaria_id = " . $Codigo;

            $rsRoteiro = pg_query(abreConexao(), $sqlRoteiro);

            $sqlEfetiva = "SELECT DIARIA_COMPROVACAO_DT_SAIDA, DIARIA_COMPROVACAO_HR_SAIDA, DIARIA_COMPROVACAO_DT_CHEGADA, DIARIA_COMPROVACAO_HR_CHEGADA, DIARIA_COMPROVACAO_VALOR_REF, DIARIA_COMPROVACAO_DESCONTO, DIARIA_COMPROVACAO_QTDE, DIARIA_COMPROVACAO_VALOR, DIARIA_COMPROVACAO_SALDO, DIARIA_COMPROVACAO_SALDO_TIPO
                           FROM DIARIA.DIARIA_COMPROVACAO WHERE DIARIA_ID = " . $Codigo;

            $rsEfetiva = pg_query(abreConexao(), $sqlEfetiva);
            $linharsEfetiva = pg_fetch_assoc($rsEfetiva);

            $qtdDeRegistro = pg_num_rows($rsRoteiro);
            $Contador = $qtdDeRegistro;
            $i = 1;
            $Roteiro = "";
            $Meio = "";

            While ($linharsRoteiro = pg_fetch_assoc($rsRoteiro)) {
                $sqlRoteiroOrigem = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linharsRoteiro['roteiro_comprovacao_origem'];
                $rsRoteiroOrigem = pg_query(abreConexao(), $sqlRoteiroOrigem);
                $linharsRoteiroOrigem = pg_fetch_assoc($rsRoteiroOrigem);

                $sqlRoteiroDestino = "SELECT * FROM dados_unico.municipio WHERE municipio_cd = " . $linharsRoteiro['roteiro_comprovacao_destino'];
                $rsRoteiroDestino = pg_query(abreConexao(), $sqlRoteiroDestino);
                $linharsRoteiroDestino = pg_fetch_assoc($rsRoteiroDestino);

                If ($i == 1) {
                    $Inicio = $linharsRoteiroOrigem['municipio_ds'] . " - (" . $linharsRoteiroOrigem['estado_uf'] . ")" . " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
                } Elseif (($i != 1) && ($i < $Contador)) {
                    $Meio = $Meio . " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
                } Elseif ($i == $Contador) {
                    $Final = " / " . $linharsRoteiroDestino['municipio_ds'] . " - (" . $linharsRoteiroDestino['estado_uf'] . ")";
                }
                $i++;
            }
            $Roteiro = $Inicio . $Meio . $Final;


            ?>

            <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
                <legend>Roteiro</legend>
                <table class="table"
                       style="width: 102%; margin-bottom: -1px; margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading">
                        <th class="th-left">Destino</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <p> <?= $Roteiro; ?><br><br></p>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table"
                       style="width: 102%;  margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading">
                        <th class="th-left" style="width:25%; white-space: nowrap">Partida Prevista</th>
                        <th class="th-left" style="width:25%; white-space: nowrap">Chegada Prevista</th>
                        <th class="th-left" style="width:50%; white-space: nowrap">Diárias Recebidas</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="white-space: nowrap; text-align: center">
                            <?= $DataPartida . " às " . $HoraPartida; ?>
                            <hr>
                            <?= $DiaSemanaPartida; ?>
                        </td>
                        <td style="white-space: nowrap; text-align: center">
                            <?= $DataChegada . " às " . $HoraChegada; ?>
                            <hr>
                            <?= $DiaSemanaChegada; ?>
                        </td>
                        <td style="white-space: nowrap; text-align: center">
                            <table class="table"
                                   style="height: 101%; width: 100%; font-size: 13px;">
                                <thead>
                                <th class="th-left" style="text-align: center">Quantidade</th>
                                <th class="th-left" style="text-align: center">Valor Total</th>
                                <th class="th-left" style="white-space: nowrap; text-align: center">Unitário</th>
                                </thead>
                                <tbody>
                                <td style="white-space: nowrap; text-align: center"><?= $Qtde; ?></td>
                                <td style="white-space: nowrap; text-align: center"><?= $Valor; ?></td>
                                <td style="white-space: nowrap; text-align: center"><?= $ValorRef; ?></td>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table"
                       style="width: 102%; margin-left: -1%; px font-size: 13px;">
                    <tr class="vendorListHeading">
                        <th class="th-left" style="width:25%; white-space: nowrap">Partida Efetiva</th>
                        <th class="th-left" style="width:25%; white-space: nowrap">Chegada Efetiva</th>
                        <th class="th-left" style="width:30%; white-space: nowrap">Diárias Utilizadas</th>
                        <th class="th-left" style="width:20%; white-space: nowrap">Saldo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="white-space: nowrap; text-align: center">
                            <?= $linharsEfetiva['diaria_comprovacao_dt_saida'] . " às " . $linharsEfetiva['diaria_comprovacao_hr_saida']; ?>
                            <hr>
                            <?= diasemana($linharsEfetiva['diaria_comprovacao_dt_saida']);?>
                        </td>
                        <td style="white-space: nowrap; text-align: center">
                            <?= $linharsEfetiva['diaria_comprovacao_dt_chegada'] . " às " . $linharsEfetiva['diaria_comprovacao_hr_chegada']; ?>
                            <hr>
                            <?=diasemana($linharsEfetiva['diaria_comprovacao_dt_chegada']);?>
                        </td>
                        <td style="white-space: nowrap; text-align: center">
                            <table class="table"
                                   style="height: 101%; width: 100%; font-size: 13px;">
                                <thead>
                                <th class="th-left" style="text-align: center">Quantidade</th>
                                <th class="th-left" style="text-align: center">Valor Total</th>
                                <th class="th-left" style="white-space: nowrap; text-align: center">Unitário</th>
                                </thead>
                                <tbody>
                                <td style="white-space: nowrap; text-align: center"><?= $linharsEfetiva['diaria_comprovacao_qtde']; ?></td>
                                <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($linharsEfetiva['diaria_comprovacao_valor'], 2); ?></td>
                                <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($linharsEfetiva['diaria_comprovacao_valor_ref'], 2); ?></td>
                                </tbody>
                            </table>
                        </td>
                        <td style="white-space: nowrap; text-align: center">
                            <table class="table"
                                   style="height: 101%; width: 100%; font-size: 13px;">
                                <thead>
                                <th class="th-left" style="text-align: center">A Receber</th>
                                <th class="th-left" style="white-space: nowrap; text-align: center">A Restituir</th>
                                </thead>
                                <tbody>
                                <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($SaldoReceber, 2, ',', '.'); ?></td>
                                <td style="white-space: nowrap; text-align: center"><?= 'R$ ' . number_format($SaldoPagar, 2, ',', '.'); ?></td>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table"
                       style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading">
                        <th class="th-left" style="width: 315px; text-align: center"> Relatório de Atividades:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="">
                        <td style="text-align: justify;"><?= $Resumo . "<br>"; ?>
                            <br></td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>

        <?php } ?>

        <div>
            <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
                <legend style="font-size: 15px;">Assinatura:</legend>
                <table class="table"
                       style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading">
                        <th class="th-left" style="text-align: center; width: 33%">Beneficiário</th>
                        <th class="th-left" style="text-align: center; width: 34%   ">Dirigente da Unidade</th>
                        <th class="th-left" style="text-align: center; width: 33%  ">Diretor</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: center; width: 33%">
                            <div class="row" style="height: 150px">
                                <br><br>
                                <hr style="margin-top: 13%">
                            </div>
                        </td>
                        <td style="text-align: center; width: 33%">

                            <div class="row" style="height: 150px">
                                <br><br>
                                <hr style="margin-top: 13%">
                            </div>
                        </td>
                        <td style="text-align: center; width: 33%">

                            <div class="row" style="height: 150px">
                                <br><br>
                                <hr style="margin-top: 13%">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>

        <div>
            <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
                <legend>Datas</legend>
                <table class="table"
                       style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading">
                        <th class="th-left">Data da Solicitação</th>
                        <th class="th-left">Data da Comprovação</th>
                        <th class="th-left">Data da Impressão</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php
                            $date=date_create($DataCriacao);
                            echo date_format($date,"d/m/Y")." - ".$HoraCriacao; ?></td>
                        <td><?php
                            $date=date_create($DataDaComprovacao);
                            echo date_format($date,"d/m/Y")." - ".$HoraDaComprovacao; ?></td>
                        <td><?= date("d/m/Y - H:i:s"); ?></td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>
    </div>
</div>
<input id="btn-Preview-Image" type="button" value="Preview"/>



<div id="previewImage">
</div>


<script>
    $(document).ready(function(){

        var element = $("#html-content-holder"); // global variable
        var getCanvas; // global variable

        $("#btn-Preview-Image").on('click', function () {
            html2canvas(element, {
                onrendered: function (canvas) {
                    $("#previewImage").append(canvas);
                    getCanvas = canvas;
                }
            });
        });

        $("#btn-Convert-Html2Image").on('click', function () {
            var imgageData = getCanvas.toDataURL("image/png");
            // Now browser starts downloading it instead of just showing it
            var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
            var nomeFile = "<?= "comp_".$Numero.".jpg";?>";
            $("#btn-Convert-Html2Image").attr("download", nomeFile).attr("href", newData);
        });

    });


    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function demo() {
        document.getElementById('btn-Preview-Image').style.visibility = 'hidden';
        await sleep(1000);
        document.getElementById("btn-Preview-Image").click();
        document.getElementById("previewImage").style.display = 'none';
        document.getElementById("btn-Convert-Html2Image").style.display = 'inline-block';
    }
    demo();
</script>
</body>
</html>