<?php

		$Sucesso = $_GET['sucesso'];

		If ($AcaoSistema == "associar")
        {

					$Territorio	= $_POST['cmbTerritorio'];
					$Municipio	= $_POST['cmbMunicipio'];

					$sqlConsulta = "SELECT municipio_cd FROM diaria.territorio_municipio WHERE municipio_cd = '" .$Territorio. "' AND municipio_cd = '" .$Municipio. "'";
                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);
					If($linha)
                    {   $sqlInsere = "INSERT INTO diaria.territorio_municipio (territorio_cd, municipio_cd) VALUES ('" .$Territorio.  "','" .$Municipio. "')";
						pg_query(abreConexao(),$sqlInsere);
                        echo "<script>window.location = 'AssociarMunicipio.php?sucesso=1';</script>";
                    }

					Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";
                    }
        }
		ElseIf ($AcaoSistema == "remover")
        {

					$Territorio	= $_POST['cmbTerritorio'];
					$Municipio	= $_POST['cmbMunicipio'];

					$sqlConsulta = "SELECT municipio_cd FROM diaria.territorio_municipio WHERE municipio_cd = '" .$Municipio. "' AND territorio_cd = '" .$Territorio. "'";
                    $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
                    $linha=pg_fetch_assoc($rsConsulta);
					If ($linha)
                    {

						$sqlDeleta = "UPDATE diaria.territorio_municipio SET territorio_municipio_st = 2 WHERE municipio_cd = '" .$Municipio. "' AND territorio_cd = '" .$Territorio. "'";
						pg_query(abreConexao(),$sqlDeleta);

						echo "<script>window.location = 'AssociarMunicipio.php?sucesso=2';</script>";
                    }
    				Else
					{	$MensagemErroBD = "REGISTRO J&Aacute; EXISTENTE.";

                    }
        }
?>
