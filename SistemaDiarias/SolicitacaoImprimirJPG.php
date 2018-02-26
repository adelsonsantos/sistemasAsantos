<?php
//@language=vbscript
include "../Include/Inc_Configuracao.php";

include "Classe/ClasseDiariaGestaoPdf.php";
include "Fpdf.php";

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

        /* height of footer + a little extra */
       /* #footer {
            width: 100%;
            !*position: fixed;*!
            bottom: 0;
        }*/



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
                <td style="width: 20%; text-align: center"><img src="http://localhost/php/sistemasAdab/image/adab.png"
                                                                style="width: 80px; margin-bottom: 10px; margin-top: 10px"></td>
                <td style="width: 600px; text-align: center">
                    <h2>Solicitação de Diárias</h2>
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
                    <th class="th-left">N° Diária</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?=$UnidadeCustoNome;?></td>
                    <td><?=$Processo;?></td>
                    <td><?=$Numero;?></td>
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
                    <th class="th-left">Tipo de Servidor</th>
                    <th class="th-left">Matrícula</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td><?=utf8_decode($BeneficiarioNome);?></td>
                    <td><?=utf8_decode($TipoUsuario);?></td>
                    <td><?=$Matricula;?></td>
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
                    <td style="white-space: nowrap;"><?=$EstruturaAtuacaoNome;?></td>
                    <td style="white-space: nowrap;"><?=$UnidadeCustoNumero."-".$UnidadeCustoNome;?></td>
                </tr>
                </tbody>
            </table>

            <table class="table"
                   style="width: 102%; margin-bottom: -1px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left" style="width: 51%"> Cargo/Função</th>
                    <th class="th-left" style="width: 51%">Escolaridade</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td style="white-space: nowrap;"><?=$CargoNome;?></td>
                    <td style="white-space: nowrap;"><?=$EscolaridadeNome;?></td>
                </tr>
                </tbody>
            </table>

            <table class="table"
                   style="width: 102%; margin-bottom: -1px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left" style="width: 315px"> CPF</th>
                    <th class="th-left">Dados Bancários</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td><?=$CPF;?></td>
                    <td><?="Banco: ".$Banco." - Agencia: ".$Agencia." - CC: " .$Conta;?></td>
                </tr>
                </tbody>
            </table>

            <table class="table"
                   style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left" style="width: 315px"> Endereço</th>
                </tr>
                </thead>
                <tbody>
                <tr class="">
                    <td><?=$Endereco;?></td>
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
                    <td><?=$Projeto;?></td>
                    <td><?=$Acao;?></td>
                    <td><?=$Territorio;?></td>
                    <td><?=$Fonte;?></td>
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
                    <th class="th-left" style="width: 30%; text-align: center">Meio de Transporte</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php

                        $str = $Descricao;
                        $arrayStr = explode(".",$str);
                        foreach ($arrayStr as $key){
                            if(!empty($key)) {
                                echo "<p style='text-align: justify'>$key." . "</p>";
                            }
                        }
                       ?><br></td>
                    <td style="text-align: center"><?=$MeioTransporte;?></td>
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
                    <td style="text-align: justify;"><?=$JustificativaFimSemana.$JustificativaFeriado;?></td>
                </tr>
                </tbody>
            </table>
        </fieldset>

        <?php

        if($qtdeRoteiros > 0)
        {


            for($i = 0; $i < $qtdeRoteiros; $i++)
            {
                ?>


                <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
                    <legend>Roteiro <?= $i+1;?></legend>
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
                                <p> <?=$roteiro[$i];?><br><br></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table"
                           style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                        <thead>
                        <tr class="vendorListHeading">
                            <th class="th-left" style="white-space: nowrap">Partida Prevista</th>
                            <th class="th-left" style="white-space: nowrap">Chegada Prevista</th>
                            <th class="th-left">Quantidade</th>
                            <th class="th-left" style="white-space: nowrap">Red. 50%</th>
                            <th class="th-left" style="white-space: nowrap">Valor Ref.</th>
                            <th class="th-left">Total</th>
                            <th class="th-left" style="white-space: nowrap">N° Empenho</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="white-space: nowrap; text-align: center">
                                <?=$dataPartida[$i]. " às " .$horaPartida[$i];?>
                                <hr>
                                <?=$diaSemanaPartida[$i];?>
                            </td>
                            <td style="white-space: nowrap; text-align: center">
                                <?=$dataChegada[$i]. " às " .$horaChegada[$i];?>
                                <hr>
                                <?=$diaSemanaChegada[$i];?>
                            </td>
                            <td style="white-space: nowrap; text-align: center"><?=$qtde[$i];?></td>
                            <td style="white-space: nowrap; text-align: center"><?=$desconto[$i];?></td>
                            <td style="white-space: nowrap; text-align: center"><?=$ValorRef;?></td>
                            <td style="white-space: nowrap; text-align: center"><?=$valor[$i];?></td>
                            <td style="white-space: nowrap; text-align: center"><?=$Empenho;?></td>
                        </tr>
                        </tbody>
                    </table>

                </fieldset>


            <?php } ?>

            <fieldset style="margin-top: 25px; width: 96%; margin-right: 10%">
                <legend>Total:</legend>
                <table class="table"
                       style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading">
                        <th class="th-left" style="text-align: center">Total de Diárias: </th>
                        <th class="th-left" style="text-align: center">Valor
                            Total:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="white-space: nowrap; text-align: center"><?=$Qtde;?></td>
                        <td style="white-space: nowrap; text-align: center"><?=$Valor;?></td>
                    </tr>
                    </tbody>
                </table>
            </fieldset>
        <?php } else{
        $sqlRoteiro = "SELECT roteiro_origem, roteiro_destino FROM diaria.roteiro WHERE diaria_id = ".$Codigo;

        $rsRoteiro = pg_query(abreConexao(),$sqlRoteiro);

        $qtdDeRegistro= pg_num_rows($rsRoteiro);
        $Contador = $qtdDeRegistro;
        $i =1;
        $Roteiro = "";
        $Meio = "";

        While($linharsRoteiro = pg_fetch_assoc($rsRoteiro))
        {
            $sqlRoteiroOrigem 		= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_origem'];
            $rsRoteiroOrigem 		= pg_query(abreConexao(),$sqlRoteiroOrigem);
            $linharsRoteiroOrigem	= pg_fetch_assoc($rsRoteiroOrigem);

            $sqlRoteiroDestino 		= "SELECT * FROM dados_unico.municipio WHERE municipio_cd = ".$linharsRoteiro['roteiro_destino'];
            $rsRoteiroDestino 		= pg_query(abreConexao(),$sqlRoteiroDestino);
            $linharsRoteiroDestino	= pg_fetch_assoc($rsRoteiroDestino);

            If ($i == 1)
            {
                $Inicio = $linharsRoteiroOrigem['municipio_ds']." - (".$linharsRoteiroOrigem['estado_uf'].")" . " / ".$linharsRoteiroDestino['municipio_ds']." - (" .$linharsRoteiroDestino['estado_uf'].")";
            }
            Elseif (($i != 1) && ($i < $Contador))
            {
                $Meio = $Meio." / ".$linharsRoteiroDestino['municipio_ds']. " - (".$linharsRoteiroDestino['estado_uf']. ")";
            }
            Elseif ($i == $Contador)
            {
                $Final = " / ".$linharsRoteiroDestino['municipio_ds']." - (".$linharsRoteiroDestino['estado_uf']. ")";
            }
            $i++;
        }
        $Roteiro = $Inicio.$Meio.$Final;



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
                        <p> <?=$Roteiro;?><br><br></p>
                    </td>
                </tr>
                </tbody>
            </table>

            <table class="table"
                   style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                <thead>
                <tr class="vendorListHeading">
                    <th class="th-left" style="white-space: nowrap">Partida Prevista</th>
                    <th class="th-left" style="white-space: nowrap">Chegada Prevista</th>
                    <th class="th-left">Quantidade</th>
                    <th class="th-left" style="white-space: nowrap">Red. 50%</th>
                    <th class="th-left" style="white-space: nowrap">Valor Ref.</th>
                    <th class="th-left">Total</th>
                    <th class="th-left" style="white-space: nowrap">N° Empenho</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="white-space: nowrap; text-align: center">
                        <?=$DataPartida. " às " .$HoraPartida;?>
                        <hr>
                        <?=$DiaSemanaPartida;?>
                    </td>
                    <td style="white-space: nowrap; text-align: center">
                        <?=$DataChegada. " às " .$HoraChegada;?>
                        <hr>
                        <?=$DiaSemanaChegada;?>
                    </td>
                    <td style="white-space: nowrap; text-align: center"><?=$Qtde;?></td>
                    <td style="white-space: nowrap; text-align: center"><?=$Desconto;?></td>
                    <td style="white-space: nowrap; text-align: center"><?=$ValorRef;?></td>
                    <td style="white-space: nowrap; text-align: center"><?=$Valor;?></td>
                    <td style="white-space: nowrap; text-align: center"><?=$Empenho;?></td>
                </tr>
                </tbody>
            </table>
        </fieldset>

            <?php } ?>

        <div>
            <fieldset style="margin-top: 5px; width: 96%; margin-right: 10%">
                <legend style="font-size: 15px;">Assinatura:</legend>
                <table class="table"
                       style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading">
                        <th class="th-left" style="text-align: center; width: 50%">Coordenador da Unidade</th>
                        <th class="th-left" style="text-align: center; width: 50%  ">Diretor</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: center">
                            <div class="row" style="height: 150px">
                                <br><br>
                                <hr style="margin-top: 13%">
                            </div>
                        </td>
                        <td style="text-align: center">

                            <div class="row" style="height: 150px">
                                <br><br>
                                <hr style="margin-top: 13%">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="table"
                       style="width: 102%; margin-bottom: -11px; margin-left: -1%; px font-size: 13px;">
                    <thead>
                    <tr class="vendorListHeading"  style="height: 50px">
                        <th class="th-left" style="text-align: center; width: 50%">Autorização: <?=$diaria_autorizacao_dt.' '.$diaria_autorizacao_hr;?> </h6></th>
                        <th class="th-left" style="text-align: center; width: 50%  ">Aprovação: <?=$diaria_aprovacao_dt.' '.$diaria_aprovacao_hr;?></h6></th>
                    </tr>
                    </thead>

                </table>


            </fieldset>
        </div>
    </div>
</div>
<?php
$sqlAltera = "UPDATE diaria.diaria_aprovacao SET imp_processo_st = 1  WHERE diaria_id = $Codigo";
pg_query(abreConexao(),$sqlAltera);

$sqlAltera2 = "UPDATE diaria.diaria SET diaria_indvidual = 1  WHERE diaria_id = $Codigo";
pg_query(abreConexao(),$sqlAltera2);
?>
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
            var nomeFile = "<?= $Numero.".jpg";?>";
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