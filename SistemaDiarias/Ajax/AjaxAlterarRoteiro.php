<?php
include "../../Include/Inc_Configuracao.php";

$cont = $_POST['controle'];

echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'>
        <tr>
            <td height='21'>
                <table cellpadding='0' cellspacing='1' border='0' width='400'>
                    <tr class='dataField'>
                        <td height='21' width='50'>&nbsp;".f_ComboEstado('cmbRoteiroOrigemUF'.$cont,"onChange='Javascript:MudaComboCidadeOrigem(\"\",\"$cont\");'" , '')."</td>
                        <td height='21'><span id='RoteiroOrigem$cont'>".f_ComboMunicipio('cmbRoteiroOrigemMunicipio'.$cont, '', '')."</span></td>
                    </tr>
                </table>
            </td>
            <td height='21' class='dataField'>
                <table cellpadding='0' cellspacing='1' border='0' width='400'>
                    <tr class='dataField'>
                        <td height='21' width='50'>&nbsp;".f_ComboEstado('cmbRoteiroDestinoUF'.$cont, "onChange='Javascript:MudaComboCidadeDestino(\"\",\"$cont\");'", '')."</td>
                        <td height='21'>
                            <span id='RoteiroDestino$cont'>".f_ComboMunicipio('cmbRoteiroDestinoMunicipio'.$cont, '', '')."</span>
                        </td>
                        <td height='21'>
                            <input type='button' name='btnAdicionar' id='btnAdicionar' style='width:65px; height:18px;' value='Adicionar' onclick='Javascript:AdicionarDadosRoteiro(\"$cont\");' /> &nbsp;
                            <input type='button' name='btnLimpar' id='btnLimpar' value='Limpar' style='width:65px; height:18px;' onclick='Javascript:LimparDadosRoteiro(\"$cont\");'/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>";
?>
