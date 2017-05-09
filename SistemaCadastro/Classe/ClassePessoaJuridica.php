<?php


	//controla a visibilidade do botao consultar
	$_SESSION['BotaoConsultar'] = 1;

	//zera a variavel de msg de banco
	$MensagemErroBD = "";

	//define o link padrao para as paginas
	$PaginaLocal = "Juridica";

	//carrega grade de informacoes na pagina inicial
	If (($AcaoSistema == "buscar")|| ($AcaoSistema == ""))
	{
			$numFiltro = $_GET['filtro'];

			If ($numFiltro != "" )
            {
				$strStringSQL = "pessoa_st = " .$numFiltro;
            }
			Else
			{	$strStringSQL = "pessoa_st <> 2";
			}
			//fim do filtro

			If ($RetornoFiltro != "" )
			{	$sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, pessoa_juridica_cnpj, pessoa_juridica_nm_fantasia FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj WHERE (p.pessoa_id = pj.pessoa_id) AND pessoa_tipo = 'J' AND ".$strStringSQL. " AND pessoa_nm ILIKE '%" .$RetornoFiltro. "%' ORDER BY UPPER(pessoa_nm)";
            }
            Else
			{	$sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, pessoa_juridica_cnpj, pessoa_juridica_nm_fantasia FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj WHERE (p.pessoa_id = pj.pessoa_id) AND pessoa_tipo = 'J' AND " .$strStringSQL. " ORDER BY UPPER(pessoa_nm)";
            }

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
    }

	ElseIf ($AcaoSistema == "incluir")
    {

			//atributos da entidade pessoa
			$NomeFantasia			= strtoupper(trim($_POST['txtNomeFantasia']));
			$RazaoSocial			= strtoupper(trim($_POST['txtRazao']));
			$Tipo					= "J";
			$Email					= strtolower(trim($_POST['txtEmail']));
			$DataCriacao 			= date("Y-m-d");
			$Fornecedor				= $_POST['chkFornecedor'];
			$CNPJ					= $_POST['txtCNPJ'];
			$DataAbertura			= $_POST['txtData'];
			$IE						= $_POST['txtIE'];
			$IM						= $_POST['txtIM'];

			$Endereco				= strtoupper(trim($_POST['txtEndereco']));
			$EnderecoNumero			= $_POST['txtNumero'];
			$EnderecoComplemento	= $_POST['txtComplemento'];
			$EnderecoReferencia	    = $_POST['txtReferencia'];
			$EnderecoCEP			= $_POST['txtCEP'];
			$EnderecoUF				= $_POST['cmbEnderecoUF'];
			$EnderecoMunicipio		= $_POST['cmbEnderecoMunicipio'];
			$EnderecoBairro			= strtoupper(trim($_POST['txtEnderecoBairro']));

			$TelefoneDDDComercial1 	= $_POST['txtFoneDDDComercial1'];
			$TelefoneComercial1 	= $_POST['txtFoneComercial1'];
			$TelefoneDDDComercial2 	= $_POST['txtFoneDDDComercial2'];
			$TelefoneComercial2	 	= $_POST['txtFoneComercial2'];
			$TelefoneDDDFax 		= $_POST['txtFoneDDDFax'];
			$TelefoneFax 			= $_POST['txtFoneFax'];
			$TelefoneDDDCelular 	= $_POST['txtFoneDDDCelular'];
			$TelefoneCelular 		= $_POST['txtFoneCelular'];
			$Contato				= strtoupper(trim($_POST['txtContato']));

			If ($Fornecedor == "on")
            {  $Fornecedor = 1;

            }
            Else
            {  $Fornecedor = 0;

            }

			//verifica se já existe cpf
			$sqlConsultaExistente = "SELECT pessoa_id FROM dados_unico.pessoa_juridica WHERE pessoa_juridica_cnpj = '".$CNPJ. "'";
            $rsConsultaExistente = pg_query(abreConexao(),$sqlConsultaExistente);

			If (pg_num_rows($rsConsultaExistente)==0)
			{

					$BeginTrans= "BEGIN WORK";
                    pg_query(abreConexao(),$BeginTrans);

					$DataCriacao = date("Y-m-d");

					//insere dados na tabela pessoa
					$sqlInsere = "INSERT INTO dados_unico.pessoa (pessoa_nm, pessoa_tipo, pessoa_email, pessoa_dt_criacao) VALUES ('".$RazaoSocial. "', '" .$Tipo. "', '" .$Email. "', '" .$DataCriacao. "')";
					pg_query(abreConexao(),$sqlInsere);
					//fim

				    //pega o ultimo codigo inserido
					$sqlCodigo= "SELECT  last_value FROM dados_unico.seq_pessoa";
					$rsCodigo = pg_query(abreConexao(),$sqlCodigo);

                    $ultimoValorSeq=pg_fetch_assoc($rsCodigo);
					//fim

				    //insere dados da tabela pessoa_fisica
					$sqlInsere = "INSERT INTO dados_unico.pessoa_juridica (pessoa_id, pessoa_juridica_cnpj, pessoa_juridica_nm_fantasia, pessoa_juridica_insc_mun, pessoa_juridica_insc_est, pessoa_juridica_dt_abertura, pessoa_juridica_contato, pessoa_juridica_fornecedor) VALUES (" .$ultimoValorSeq['last_value']. ", '" .$CNPJ. "', '" .$NomeFantasia. "', '" .$IM. "', '" .$IE. "', '" .$DataAbertura. "', '" .$Contato. "', '" .$Fornecedor. "')";
					pg_query(abreConexao(),$sqlInsere);

					//fim

				    //insere dados da tabela endereco
                    $sqlInsere = "INSERT INTO dados_unico.endereco (pessoa_id, estado_uf, municipio_cd, endereco_bairro, endereco_ds, endereco_num, endereco_complemento, endereco_referencia, endereco_cep) VALUES (" .$ultimoValorSeq['last_value']. ", '" .$EnderecoUF. "', '" .$EnderecoMunicipio. "', '".$EnderecoBairro."', '".$Endereco."', '".$EnderecoNumero."', '".$EnderecoComplemento."', '" .$EnderecoReferencia."', '".$EnderecoCEP."')";
                    pg_query(abreConexao(),$sqlInsere);
				    //fim

					If ($TelefoneCelular != "")
					{	$sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneCelular. "', '" .$TelefoneDDDCelular. "', 'M')";
						pg_query(abreConexao(),$sqlInsere);
                    }

					If ($TelefoneComercial1 != "" )
					{	$sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneComercial1. "', '" .$TelefoneDDDComercial1. "', 'C')";
						pg_query(abreConexao(),$sqlInsere);
                    }

					If ($TelefoneComercial2 != "")
                    {
						$sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneComercial2. "', '" .$TelefoneDDDComercial2. "', 'C')";
						pg_query(abreConexao(),$sqlInsere);
                    }


					if ($TelefoneFax != "")
					{	
						$sqlInsere = "INSERT INTO dados_unico.telefone ( pessoa_id, 
						                                                 telefone_num, 
																														 telefone_ddd, 
																														 telefone_tipo
																													 ) VALUES (
																													   ".$ultimoValorSeq['last_value'].",
																														 '" .$TelefoneFax. "',
																														 '" .$TelefoneDDDFax. "',
																														 'F'
																													 )";
						pg_query(abreConexao(),$sqlInsere);
          }

					//fim
					If ($Err != 0)
                    {
						$RollbackTrans = "ROLLBACK";
                        pg_query(abreConexao(),$RollbackTrans);

						echo $Err;
                    }
					Else
					{	$CommitTrans="COMMIT";
                        pg_query(abreConexao(),$CommitTrans);

                    }

                    echo "<script>window.location = 'JuridicaInicio.php ';</script>";
            }

			Else
            {
					 $MensagemErroBD = "CNPJ j&aacute; existente.";

            }
    }


	ElseIf ($AcaoSistema == "consultar")
    {

			$Codigo = $_GET['cod'];

			If ($Codigo == "")
            {

				$Codigo = $_POST['checkbox'];

				$sqlConsulta = "SELECT * FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj, dados_unico.endereco e WHERE (p.pessoa_id = pj.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND p.pessoa_id IN (" .$Codigo. ")";
            }
			Else
			{	$sqlConsulta = "SELECT * FROM dados_unico.pessoa p, dados_unico.pessoa_juridica pj, dados_unico.endereco e WHERE (p.pessoa_id = pj.pessoa_id) AND (p.pessoa_id = e.pessoa_id) AND p.pessoa_id = " .$Codigo;
            }

           $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
           $linha=pg_fetch_assoc($rsConsulta);

			If ($linha)
			{
					//atributos da entidade pessoa
					$NomeFantasia			= $linha['pessoa_juridica_nm_fantasia'];
					$RazaoSocial			= $linha['pessoa_nm'];
					$Email					= $linha['pessoa_email'];
					$Fornecedor				= $linha['pessoa_juridica_fornecedor'];
					$CNPJ					= $linha['pessoa_juridica_cnpj'];
					$DataAbertura			= $linha['pessoa_juridica_dt_abertura'];
					$IE						= $linha['pessoa_juridica_insc_est'];
					$IM						= $linha['pessoa_juridica_insc_mun'];
					$Contato				= $linha['pessoa_juridica_contato'];
					$PessoaDataCriacao		= $linha['pessoa_dt_criacao'];
					$PessoaDataAlteracao	= $linha['pessoa_dt_alteracao'];
					$StatusNumero			= $linha['pessoa_st'];

					$Endereco				= $linha['endereco_ds'];
					$EnderecoNumero			= $linha['endereco_num'];
					$EnderecoComplemento	= $linha['endereco_complemento'];
				    $EnderecoReferencia     = $linha['endereco_referencia'];
					$EnderecoCEP			= $linha['endereco_cep'];
					$EnderecoUF				= $linha['estado_uf'];
					$EnderecoMunicipio		= $linha['municipio_cd'];
					$EnderecoBairro			= $linha['endereco_bairro'];
					$EnderecoReferencia			= $linha['endereco_referencia'];

					If($Fornecedor == "1")
                    {  $FornecedorMarcado = "checked";

                    }
                    Else
                    {  $FornecedorMarcado = "";

                    }

					If ($StatusNumero == "0")
                    {  $StatusNome = "Ativo";

                    }
                    Else
                    {  $StatusNome = "Inativo";

                    }

					$sqlConsultaTelefone = "SELECT * FROM dados_unico.telefone WHERE pessoa_id = " .$Codigo;
                    $rsConsultaTelefone = pg_query(abreConexao(),$sqlConsultaTelefone);

                    while($linha2=pg_fetch_assoc($rsConsultaTelefone))
					{
                            If ($linha2['telefone_tipo']== "C")
                            {
                                If ($TelefoneComercial1 == "")
                                {  $TelefoneDDDComercial1 	= $linha2['telefone_ddd'];
                                   $TelefoneComercial1 		= $linha2['telefone_num'];
                                }
                                Else
                                {	$TelefoneDDDComercial2 	= $linha2['telefone_ddd'];
                                    $TelefoneComercial2 	= $linha2['telefone_num'];
                                }
                            }
							ElseIf ($linha2['telefone_tipo']== "M")
                            {
								$TelefoneDDDCelular 	= $linha2['telefone_ddd'];
								$TelefoneCelular 		= $linha2['telefone_num'];
                            }
							ElseIf ($linha2['telefone_tipo']== "F")
                            {
								$TelefoneDDDFax 		= $linha2['telefone_ddd'];
								$TelefoneFax 			= $linha2['telefone_num'];
							}

                    }
            }
    }


	ElseIf ($AcaoSistema == "alterar")
    {

			$Codigo					= $_POST['txtCodigo'];
			$NomeFantasia			= strtoupper(trim($_POST['txtNomeFantasia']));
			$RazaoSocial			= strtoupper(trim($_POST['txtRazao']));
			$Tipo					= "J";
			$Email					= strtolower(trim($_POST['txtEmail']));
			$DataAlteracao 			= date("Y-m-d");
			$Fornecedor				= $_POST['chkFornecedor'];
			$CNPJ					= $_POST['txtCNPJ'];
			$DataAbertura			= $_POST['txtData'];
			$IE						= $_POST['txtIE'];
			$IM						= $_POST['txtIM'];

			$Endereco				= strtoupper(trim($_POST['txtEndereco']));
			$EnderecoNumero			= $_POST['txtNumero'];
			$EnderecoComplemento	= $_POST['txtComplemento'];
	    	$EnderecoReferencia     = $_POST['txtReferencia'];
			$EnderecoCEP			= $_POST['txtCEP'];
			$EnderecoUF				= $_POST['cmbEnderecoUF'];
			$EnderecoMunicipio		= $_POST['cmbEnderecoMunicipio'];
			$EnderecoReferencia		= $_POST['txtReferencia'];
			$EnderecoBairro			= strtoupper(trim($_POST['txtEnderecoBairro']));

			$TelefoneDDDComercial1 	= $_POST['txtFoneDDDComercial1'];
			$TelefoneComercial1 	= $_POST['txtFoneComercial1'];
			$TelefoneDDDComercial2 	= $_POST['txtFoneDDDComercial2'];
			$TelefoneComercial2	 	= $_POST['txtFoneComercial2'];
			$TelefoneDDDFax 		= $_POST['txtFoneDDDFax'];
			$TelefoneFax 			= $_POST['txtFoneFax'];
			$TelefoneDDDCelular 	= $_POST['txtFoneDDDCelular'];
			$TelefoneCelular 		= $_POST['txtFoneCelular'];
			$Contato				= strtoupper(trim($_POST['txtContato']));

			If ($Fornecedor == "on")
            {  $Fornecedor = 1;

            }
            Else
            {  $Fornecedor = 0;

            }

			$sqlConsultaExistente = "SELECT pessoa_id FROM dados_unico.pessoa_juridica WHERE pessoa_juridica_cnpj = '".$CNPJ. "' AND pessoa_id <> " .$Codigo;
            $rsConsultaExistente = pg_query(abreConexao(),$sqlConsultaExistente);


			 If (pg_num_rows($rsConsultaExistente)==0)
			 {
                 $BeginTrans= "BEGIN WORK";
                 pg_query(abreConexao(),$BeginTrans);

				 $sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_nm = '" .$RazaoSocial. "', pessoa_email = '" .$Email. "', pessoa_dt_alteracao = '" .$DataAlteracao. "'WHERE pessoa_id = " .$Codigo;
                 pg_query(abreConexao(),$sqlAltera);


                $sqlAltera = "UPDATE dados_unico.pessoa_juridica SET pessoa_juridica_cnpj = '" .$CNPJ. "',pessoa_juridica_nm_fantasia = '" .$NomeFantasia. "',pessoa_juridica_insc_mun = '" .$IM. "',pessoa_juridica_insc_est = '" .$IE. "',pessoa_juridica_dt_abertura = '" .$DataAbertura. "',pessoa_juridica_contato = '" .$Contato. "',	pessoa_juridica_fornecedor = '" .$Fornecedor. "'WHERE pessoa_id = ".$Codigo;

                pg_query(abreConexao(),$sqlAltera);

                $sqlAltera = "UPDATE dados_unico.endereco SET estado_uf = '" .$EnderecoUF. "', municipio_cd = '" .$EnderecoMunicipio. "', endereco_bairro = '" .$EnderecoBairro. "',endereco_ds = '" .$Endereco. "', endereco_num = '" .$EnderecoNumero. "', endereco_cep = '" .$EnderecoCEP. "',endereco_complemento = '" .$EnderecoComplemento. "', endereco_referencia = '".$EnderecoReferencia."' WHERE pessoa_id = ".$Codigo;

                pg_query(abreConexao(),$sqlAltera);


                $sqlTeste="SELECT * FROM dados_unico.telefone where telefone_num='" .$TelefoneComercial1."'AND pessoa_id=".$Codigo;
            $rsTeste=pg_query(abreConexao(),$sqlTeste);
            If(pg_fetch_row($rsTeste)==0)
            {  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneComercial1. "', '" .$TelefoneDDDComercial. "', 'C')";
                pg_query(abreConexao(),$sqlInsere);
            }
            else
            {
               $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneComercial1."',telefone_ddd = '" .$TelefoneDDDComercial1."'WHERE telefone_tipo = 'C' AND pessoa_id = " .$Codigo;
               pg_query(abreConexao(),$sqlAltera);

            }
            $sqlTeste="SELECT * FROM dados_unico.telefone where telefone_num='" .$TelefoneComercial2."'AND pessoa_id=".$Codigo;
            $rsTeste=pg_query(abreConexao(),$sqlTeste);
            If(pg_fetch_row($rsTeste)==0)
            {  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneComercial2. "', '" .$TelefoneDDDComercial2. "', 'C')";
                pg_query(abreConexao(),$sqlInsere);
            }
            else
            {
               $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneComercial2."',telefone_ddd = '" .$TelefoneDDDComercial2."'WHERE telefone_tipo = 'C' AND pessoa_id = " .$Codigo;
               pg_query(abreConexao(),$sqlAltera);

            }
            $sqlTeste="SELECT * FROM dados_unico.telefone where telefone_num='" .$TelefoneCelular."'AND pessoa_id=".$Codigo;
            $rsTeste=pg_query(abreConexao(),$sqlTeste);
            If(pg_fetch_row($rsTeste)==0)
            {  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneCelular. "', '" .$TelefoneDDDCelular. "', 'M')";
                pg_query(abreConexao(),$sqlInsere);
            }
            else
            {
             $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneCelular."',telefone_ddd = '" .$TelefoneDDDCelular."'WHERE telefone_tipo = 'M' AND pessoa_id = " .$Codigo;
                pg_query(abreConexao(),$sqlAltera);
            }
            $sqlTeste="SELECT * FROM dados_unico.telefone where telefone_num='" .$TelefoneFax."'AND pessoa_id=".$Codigo;
            $rsTeste=pg_query(abreConexao(),$sqlTeste);
            If(pg_fetch_row($rsTeste)==0)
            {  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneFax. "', '" .$TelefoneDDDFax. "', 'F')";
                pg_query(abreConexao(),$sqlInsere);
            }
            else
            {
             $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneFax."',telefone_ddd = '" .$TelefoneDDDFax."'WHERE telefone_tipo = 'F' AND pessoa_id = " .$Codigo;
            pg_query(abreConexao(),$sqlAltera);

            }
                pg_query(abreConexao(),$sqlAltera);
                If ($Err != 0)
                {
                    $RollbackTrans = "ROLLBACK";
                    pg_query(abreConexao(),$RollbackTrans);

                    echo $Err;
                }
                Else
                {	$CommitTrans="COMMIT";
                    pg_query(abreConexao(),$CommitTrans);

                }

                 echo "<script>window.location = 'JuridicaInicio.php ';</script>";
            }
			Else
            {   $MensagemErroBD = "CNPJ j&aacute; existente.";

            }
    }
		ElseIf ($AcaoSistema == "alterarStatus")
        {
            $DataAlteracao 	= date("Y-m-d");
            $Codigo 		= $_GET['cod'];
            $StatusCod		= $_GET['status'];

            If ($StatusCod == 0)
            {  $StatusCod = 1;

            }
            Else
            {  $StatusCod = 0;

            }

            $sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_st = ".$StatusCod. ", pessoa_dt_alteracao = '" .$DataAlteracao. "' WHERE pessoa_id = " .$Codigo;
            pg_query(abreConexao(),$sqlAltera);

             echo "<script>window.location = 'JuridicaInicio.php ';</script>";
        }

		ElseIf ($AcaoSistema == "excluir")
		{
				$ExcluirCheckbox = $_GET['excluirMultiplo'];
				If ($ExcluirCheckbox == 1)
				{
					$Codigo	= $_POST['txtCodigo'];
					$sqlDeleta = "UPDATE dados_unico.pessoa SET pessoa_st = 2 WHERE pessoa_id IN (".$Codigo.")";
                }
				Else
				{
					$Codigo	= $_GET['cod'];
					$sqlDeleta = "UPDATE dados_unico.pessoa SET pessoa_st = 2 WHERE pessoa_id = " .$Codigo;
                }
				pg_query(abreConexao(),$sqlDeleta);


				 echo "<script>window.location = 'JuridicaInicio.php ';</script>";

        }



?>