<?php
include "../../Include/Inc_Configuracao.php";

$controle    = $_POST['controle'];

if($controle == '')
{
    $cont = 0;
}
else
{
    $cont = $controle;
}

if(($_POST['controleOrigem'] == 'undefined')&&($_POST['controleDestino'] == 'undefined'))
{
    $controleOrigem  = $_POST['origem'];
    $origem          = $_POST['origem'];
    $controleDestino = $_POST['destino'];        
    $destino         = $_POST['destino'];
}
else
{
    $origem          = $_POST['origem'];
    $controleOrigem  = $_POST['controleOrigem'];
    $destino         = $_POST['destino'];        
    $controleDestino = $_POST['controleDestino'];
}

if($_POST['acao']=='adicionar')
{    
    $PodeInserir = 1;
    
    unset($html); 

    //VERIFICA SE O MUNICÍPIO DESTINO É DA BAHIA
    $sqlConsultaUF = "SELECT estado_uf, municipio_cd, municipio_ds
                        FROM dados_unico.municipio
                       WHERE municipio_cd = ".$controleDestino;
    
    $rsConsultaUF = pg_query(abreConexao(),$sqlConsultaUF);
    $linha        = pg_fetch_assoc($rsConsultaUF);

    //VERIFICA SE O ESTADO E DIFERENTE DA BA E O MUNICÍPIO DESTINO É SALVADOR.
    If ((mb_strtoupper($linha['estado_uf']) != "BA") || (mb_strtoupper($linha['municipio_ds'])  == 'SALVADOR'))
    { 
        //VERIFICA O PERCENTUAL DO MUNICÍPIO PARA CALCULO
        $sqlConsultaCidade = "SELECT percentual_ds 
                                FROM diaria.percentual_capital pc,
                                     diaria.percentual p
                               WHERE (pc.percentual_id = p.percentual_id)
                                 AND municipio_cd = ".$controleDestino;
        
        $rsConsultaCidade = pg_query(abreConexao(),$sqlConsultaCidade);
        $linhaCidade      = pg_fetch_assoc($rsConsultaCidade);

        //SE A PESQUISA ROTORNAR ALGUMA LINHA
        if($linhaCidade)
        {
            $Percentual = $linhaCidade['percentual_ds'];
        }
        else
        {
            $sql3 = "SELECT percentual_ds
                       FROM diaria.percentual
                      WHERE percentual_id = 2";

            $rs3        = pg_query(abreConexao(),$sql3);
            $linhars3   = pg_fetch_assoc($rs3);
            //RECEBE VALOR PADRÃO DE CALCULO. 0,6
            $Percentual = $linhars3['percentual_ds'];
        }
    }
    else
    {
        //VERIFICA SE O ESTADO E O MUNICÍPIO ORIGEM SÃO: SALVADOR E BA
        $sqlConsultaUF = "SELECT estado_uf, municipio_cd, municipio_ds
                            FROM dados_unico.municipio
                           WHERE municipio_cd = ".$controleOrigem;
        
        $rsConsultaUF  = pg_query(abreConexao(),$sqlConsultaUF);
        $linhaUF       = pg_fetch_assoc($rsConsultaUF);

        if ((mb_strtoupper($linhaUF['estado_uf']) != "BA"))
        {
            //VERIFICA O PERCENTUAL DO MUNICÍPIO PARA CALCULO
            $sqlConsultaCidade = "SELECT percentual_ds 
                                    FROM diaria.percentual_capital pc,
                                         diaria.percentual p
                                   WHERE (pc.percentual_id = p.percentual_id)
                                     AND municipio_cd = " .$controleOrigem;
            
            $rsConsultaCidade = pg_query(abreConexao(),$sqlConsultaCidade);
            $linhaCidade      = pg_fetch_assoc($rsConsultaCidade);

            //SE A PESQUISA ROTORNAR ALGUMA LINHA
            if($linhaCidade)
            {
                $Percentual = $linhaCidade['percentual_ds'];
            }
            else
            {
                $sql3 = "SELECT percentual_ds
                           FROM diaria.percentual
                          WHERE percentual_id = 2";
                $rs3      = pg_query(abreConexao(),$sql3);
                $linhars3 = pg_fetch_assoc($rs3);
                //RECEBE VALOR PADRÃO DE CALCULO. 0,6
                $Percentual = $linhars3['percentual_ds'];
            }
        }// FIM DO IF(($linhaUF['estado_uf'] != "BA"))
        else
        {
            //CASO O ESTADO SEJA A BAHIA (($linhaUF['estado_uf'] != "BA"))
            //NESTE MOMENTO O AJAX NÃO DEIXA INSERIR SALVADOR NOVAMENTE NO ROTEIRO            
            If(
                ((mb_strtoupper($linhaUF['estado_uf']) == "BA") && (mb_strtoupper($linhaUF['municipio_ds']) == 'SALVADOR')) 
                &&((($_SESSION['ViagemOrigem'][$cont][count($_SESSION['ViagemOrigem'][$cont])]) != ($origem))
                &&(($_SESSION['ViagemOrigem'][$cont][1]) == ($destino)))
              )
            {
                $sqlConsultaSalvador = "SELECT percentual_ds
                                          FROM diaria.percentual_capital pc,
                                               diaria.percentual p
                                         WHERE (pc.percentual_id = p.percentual_id)
                                           AND municipio_cd = ".$linhaUF['municipio_cd']; 
                
                $rsConsultaSalvador      = pg_query(abreConexao(),$sqlConsultaSalvador);
                $linharsConsultaSalvador = pg_fetch_assoc($rsConsultaSalvador);

                $PodeInserir = 0;
                $Percentual  = $linharsConsultaSalvador['percentual_ds'];
            }
            else
            {   //NÃO DEIXA INSERIR A MESMA LINHA NOVAMENTE EX: SSA X ITABERABA; SSA X ITABERABA;                
                if(($_SESSION['ViagemOrigem'][$cont][count($_SESSION['ViagemOrigem'][$cont])]) == ($origem) 
                 &&($_SESSION['ViagemDestino'][$cont][count($_SESSION['ViagemDestino'][$cont])]) == ($destino))
                {
                    $PodeInserir = 0;
                    $Percentual  = '0,0';
                }
                elseIf (($_SESSION['ViagemOrigem'][$cont][count($_SESSION['ViagemOrigem'][$cont])]) == ($origem))
                {//NÃO DEIXA INSERIR QUANDO A ULTIMA CIDADE ORIGEM QUE FOI INSERIDA FOR IGUAL A CIDADE QUE ESTA SENDO INSERIDA.
                    $PodeInserir = 0;
                    $Percentual  = '0,0';
                }
                else
                { //NÃO ALTERA O CALCULO, SÓ PARA CIDADES DA BAHIA
                    $Percentual = 0;
                }
            }
        }//FIM DO ELSE (($linhaUF['estado_uf'] != "BA"))
    }
//[$controle]
    //******************************************************************************
    if ( strval($_SESSION['ValorPercentual'][$cont]) == strval($Percentual))
    {
        $PodeInserir = 1;
    }
    else
    {
        If ((($_SESSION['ViagemOrigem'][$cont][1]) == ($destino))&&(($_SESSION['ViagemOrigem'][$cont][count($_SESSION['ViagemOrigem'][$cont])]) != ($origem) &&($_SESSION['ViagemDestino'][$cont][count($_SESSION['ViagemDestino'][$cont])]) != ($destino)))
        {
            $PodeInserir = 1;
        }
        Else
        {
            $PodeInserir = 0;
        }
    }
    
    if ((strval($_SESSION['ValorPercentual'][$cont])== "") || ($PodeInserir == 1))
    {
        if ($_SESSION['ContadorDestino'][$cont] == "")
        {
            $_SESSION['ContadorDestino'][$cont] = 1;
        }
        else
        {
            $_SESSION['ContadorDestino'][$cont] = $_SESSION['ContadorDestino'][$cont] + 1;
        }

        $RelacaoViagemOrigem[$_SESSION['ContadorDestino'][$cont]] = $origem;
        $RelacaoViagemDestino[$_SESSION['ContadorDestino'][$cont]] = $destino;
        $_SESSION['Origem'][$cont] = $RelacaoViagemOrigem[1];
    }

    $html = "<table cellpadding=1 cellspacing=1 border=0 width=100%>
                <tr class=dataLabel>
                    <td height=21 width=50%><b>De</b></td>
                    <td height=21 width=50%><b>Para</b></td>
                </tr>";

    For ($i = 1; $i<=$_SESSION['ContadorDestino'][$cont];$i++)
    {
        if ($RelacaoViagemOrigem[$i] == "") 
        {
            $RelacaoViagemOrigem[$i] = $_SESSION['ViagemOrigem'][$cont][$i];
        }
        if ($RelacaoViagemDestino[$i] == "") 
        {
            $RelacaoViagemDestino[$i] = $_SESSION['ViagemDestino'][$cont][$i];
        }
        
        $sql1     = "SELECT *
                       FROM dados_unico.municipio
                      WHERE municipio_cd = ".$RelacaoViagemOrigem[$i];
        $rs1      = pg_query(abreConexao(),$sql1);
        $linhars1 = pg_fetch_assoc($rs1);

        $sql2     = "SELECT *
                       FROM dados_unico.municipio
                      WHERE municipio_cd = ".$RelacaoViagemDestino[$i];
        $rs2      = pg_query(abreConexao(),$sql2);
        $linhars2 = pg_fetch_assoc($rs2);

        $html.= "<tr class=dataField>
                    <td height=21>" .$linhars1['estado_uf']. " - " .$linhars1['municipio_ds']."</td>
                    <td height=21>" .$linhars2['estado_uf']. " - " .$linhars2['municipio_ds']."</td>
                </tr>";
    }

    if ((strval($_SESSION['ValorPercentual'][$cont]) == "" ) || ($PodeInserir == 1))
    {
        $_SESSION['ViagemOrigem'][$cont]  = $RelacaoViagemOrigem;
        $_SESSION['ViagemDestino'][$cont] = $RelacaoViagemDestino;
        //verifica se o municipio eh da bahia
        $sqlConsultaUF = "SELECT estado_uf, municipio_cd, municipio_ds 
                            FROM dados_unico.municipio
                           WHERE municipio_cd = " .$_SESSION['ViagemDestino'][$cont][1];
        
        $rsConsultaUF = pg_query(abreConexao(),$sqlConsultaUF);
        $linhaUF      = pg_fetch_assoc($rsConsultaUF);
        
        if ((mb_strtoupper($linhaUF['estado_uf']) != "BA") or (mb_strtoupper($linhaUF['municipio_ds']) == 'SALVADOR'))
        {
        //verifica o percentual do municipio para calculo
            $sqlConsultaCidade = "SELECT percentual_ds 
                                    FROM diaria.percentual_capital pc,
                                         diaria.percentual p
                                   WHERE (pc.percentual_id = p.percentual_id)
                                     AND municipio_cd = " .$_SESSION['ViagemDestino'][$cont][1];
            
            $rsConsultaCidade = pg_query(abreConexao(),$sqlConsultaCidade);
            $linhaCidade      = pg_fetch_assoc($rsConsultaCidade);
            
            if($linhaCidade)
            {
                //QUANDO A DIARIA FOR SOLICITADA ANTES DA MUDANÇA E A COMPROVAÇÃO OCORRER
                //DEPOIS NÃO CALCULA A DIÁRIA COM 80% PARA SALVADOR E SIM O 0% COMO ANTES.
                if ($_POST['dataPartida'])// <= '11/08/2011')
                {
                    $dataPartida = explode ('/', $_POST['dataPartida']);
                    $dataBanco   = $dataPartida[2].'-'.$dataPartida[1].'-'.$dataPartida[0];

                    $sqlConsultaData    = "SELECT classe_valor_id FROM diaria.classe_valor
                                            WHERE classe_valor_st = 1
                                              AND '".$dataBanco."' BETWEEN classe_valor_dt_vigencia_inicio
                                              AND classe_valor_dt_vigencia_fim"; 
                    
                    $rsConsultaData     = pg_query(abreConexao(), $sqlConsultaData);
                    $linhaConsultaData  = pg_fetch_assoc ($rsConsultaData);

                    if ($linhaConsultaData)
                    {
                        $Percentual = 0;
                    }
                }
                else
                {
                    $Percentual = $linhaCidade['percentual_ds'];
                }
            }
            else
            {
                $sql3 = "SELECT percentual_ds 
                           FROM diaria.percentual
                          WHERE percentual_id = 2";
                
                $rs3        = pg_query(abreConexao(),$sql3);
                $linhars3   = pg_fetch_assoc($rs3);
                $Percentual = $linhars3['percentual_ds']; //recebe valor padrao de calculo
            }
        }
        else
        {
            //'verifica se o municipio eh da bahia
            $sqlConsultaUF = "SELECT estado_uf, municipio_cd 
                                FROM dados_unico.municipio
                               WHERE municipio_cd = " .$origem;
            
            $rsConsultaUF = pg_query(abreConexao(),$sqlConsultaUF);
            $linhaUF      = pg_fetch_assoc($rsConsultaUF);

            if ((mb_strtoupper($linhaUF['estado_uf']) != "BA"))
            {  //verifica o percentual do municipio para calculo
                $sqlConsultaCidade = "SELECT percentual_ds 
                                        FROM diaria.percentual_capital pc,
                                             diaria.percentual p
                                       WHERE (pc.percentual_id = p.percentual_id)
                                         AND municipio_cd = " .$origem;
                
                $rsConsultaCidade = pg_query(abreConexao(),$sqlConsultaCidade);
                $linhaCidade      = pg_fetch_assoc($rsConsultaCidade);

                if($linhaCidade)
                {
                    $Percentual = $linhaCidade['percentual_ds'];
                }
                else 
                {
                    $sql3 = "SELECT percentual_ds
                               FROM diaria.percentual
                              WHERE percentual_id = 2";
                    
                    $rs3        = pg_query(abreConexao(),$sql3);
                    $linhars3   = pg_fetch_assoc($rs3);
                    $Percentual = $linhars3['percentual_ds']; //recebe valor padrao de calculo
                }
            }
            else
            {
                $Percentual = 0;// 'nao altera o calculo, so para cidades da bahia
            }
        }
        $_SESSION['ValorPercentual'][$cont] = $Percentual;
    }
    else
    {
        $html.=" <tr class=dataField>
                    <td height=21 class='MensagemErro' colspan='2'><b>O roteiro escolhido não é compatível, entre em contato com o GESTOR do sistema!</b></td>
                </tr>";
        $Percentual = $_SESSION['ValorPercentual'][$cont];
    }

    if ( ($_SESSION['ViagemOrigem'][$cont][1]) != ($_SESSION['ViagemDestino'][$cont][count($_SESSION['ViagemDestino'][$cont])]) )
    {
        //MENSAGEM INFORMANDO QUE A PRIMEIRA ORIGEM É DIFERENTE DO ULTIMO DESTINO
        $html.=" <tr class=dataField>
                    <td height=21 class='MensagemErro' colspan='2'><b>A cidade FINAL deve COINCIDIR com a cidade INICIAL!</b></td>
                </tr>";
    }
    $html.=" </table>
            <input type='hidden' name='txtPercentual$controle' id='txtPercentual$controle' value=".$Percentual." />
            <input type='hidden' name='hdnControleOrigem$controle' id='hdnControleOrigem$controle' value='$controleOrigem' />  
            <input type='hidden' name='hdnControleDestino$controle' id='hdnControleDestino$controle' value='$controleDestino' />";       
//<input type='hidden' name='hdnControle$controle' id='hdnControle$controle' value='$controle' />
    print $html;
}
elseif($_POST['acao']=='limpar')
{    
    unset($_SESSION['ViagemOrigem'][$cont]);
    unset($_SESSION['ViagemDestino'][$cont]);
    unset($_SESSION['ContadorDestino'][$cont]);
    unset($_SESSION['ValorPercentual'][$cont]);
    unset($_SESSION['Origem'][$cont]);
    unset($Percentual);
    print '';
}
?>
