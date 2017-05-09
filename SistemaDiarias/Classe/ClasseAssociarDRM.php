<?php


		$Sucesso = $_GET['sucesso'];

		If ($AcaoSistema == "associar")
        {

					$Projeto		= $_POST['cmbProjeto'];
					$Acao		    = $_POST['cmbAcao'];
					$Territorio	    = $_POST['cmbTerritorio'];

					$sqlConsulta = "SELECT projeto_cd FROM diaria.projeto_acao_territorio WHERE projeto_cd = '" .$Projeto. "' AND acao_cd = '" .$Acao. "' AND territorio_cd = '" .$Territorio. "'";
                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                

                    If(pg_fetch_row($rsConsulta)==0)
                    {

						$sqlInsere = "INSERT INTO diaria.projeto_acao_territorio (projeto_cd, acao_cd, territorio_cd) VALUES ('" .$Projeto.  "','" .$Acao. "', '" .$Territorio. "')";
						pg_query(abreConexao(),$sqlInsere);
                        echo "<script>window.location = 'AssociarDRM.php?sucesso=1';</script>";

                    }
					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
                    }
        }

		ElseIf ($AcaoSistema == "remover_acao")
        {

					$Projeto	= $_POST['cmbProjeto'];
					$Acao		= $_POST['cmbAcao'];

					$sqlConsulta = "SELECT projeto_cd FROM diaria.projeto_acao_territorio WHERE projeto_cd = '" .$Projeto. "' AND acao_cd = '" .$Acao. "'";
					$rsConsulta =  pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);

					If ($linha)
                    {

						$sqlDeleta = "UPDATE diaria.projeto_acao_territorio SET projeto_acao_territorio_st = 2 WHERE projeto_cd = '" .$Projeto. "' AND acao_cd = '" .$Acao. "'";
						pg_query(abreConexao(),$sqlDeleta);

						 echo "<script>window.location = 'AssociarDRM.php?sucesso=2';</script>";
                    }
					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
					}
        }

		ElseIf ($AcaoSistema == "remover_territorio")
        {

					$Projeto		= $_POST['cmbProjeto'];
					$Acao		    = $_POST['cmbAcao'];
					$Territorio	    = $_POST['cmbTerritorio'];

					$sqlConsulta = "SELECT projeto_cd FROM diaria.projeto_acao_territorio WHERE projeto_cd = '" .$Projeto. "' AND acao_cd = '" .$Acao. "' AND territorio_cd = '" .$Territorio. "'";
					$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);

					If($linha)
                    {

						$sqlDeleta = "UPDATE diaria.projeto_acao_territorio SET projeto_acao_territorio_st = 2 WHERE projeto_cd = '" .$Projeto. "' AND acao_cd = '" .$Acao. "' AND territorio_cd = '" .$Territorio. "'";
						pg_query(abreConexao(),$sqlDeleta);

						echo "<script>window.location = 'AssociarDRM.php?sucesso=2';</script>";

                    }
                    Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
                    }
        }
		
?>
