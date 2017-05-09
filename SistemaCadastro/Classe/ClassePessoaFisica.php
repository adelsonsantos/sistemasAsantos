<?php

	//controla a visibilidade do botao consultar
	$_SESSION['BotaoConsultar'] = 1;

	//zera a variavel de msg de banco
	$MensagemErroBD = "";

	//define o link padrao para as paginas
	$PaginaLocal = "Fisica";

	//carrega grade de informacoes na pagina inicial
	if (($AcaoSistema == "buscar")||($AcaoSistema == ""))
  {

			$numFiltro = $_GET['filtro'];

			If ($numFiltro !="")
            {
				$strStringSQL = "pessoa_st = ".$numFiltro;
            }
			Else
			{	$strStringSQL = "pessoa_st <> 2";

            }
			// fim do filtro
           
		If ((is_string($RetornoFiltro))&&($RetornoFiltro != ""))
     	{$sqlConsulta = "SELECT p.pessoa_id, p.pessoa_nm, p.pessoa_st, p.pessoa_dt_criacao, p.pessoa_dt_alteracao, pf.pessoa_fisica_cpf FROM dados_unico.pessoa p, dados_unico.pessoa_fisica pf WHERE (p.pessoa_id = pf.pessoa_id) AND ((p.pessoa_nm ILIKE '%".$RetornoFiltro."%') OR (pf.pessoa_fisica_cpf ILIKE '%".$RetornoFiltro."%') OR (pf.pessoa_fisica_rg ILIKE '%".$RetornoFiltro."%')) AND " .$strStringSQL. " ORDER BY UPPER(pessoa_nm)";
   		}
       	Else
   		{$sqlConsulta = "SELECT p.pessoa_id, pessoa_nm, pessoa_st, pessoa_dt_criacao, pessoa_dt_alteracao, pessoa_fisica_cpf FROM dados_unico.pessoa p, dados_unico.pessoa_fisica pf WHERE (p.pessoa_id = pf.pessoa_id) AND " .$strStringSQL. " ORDER BY UPPER(pessoa_nm)";
   		}

       $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
   }


	ElseIf ($AcaoSistema == "incluir")
    {

		//atributos da entidade pessoa
		$Tipo					           = "F";
		$Nome					           = strtoupper(trim($_POST['txtNome']));
		$Email				               = strtolower(trim($_POST['txtEmail']));
		$NivelEscolar		               = $_POST['cmbNivelEscolar'];
		$EstadoCivil		               = $_POST['cmbEstadoCivil'];
		$Sexo					           = $_POST['rdSexo'];
		$CPF					           = $_POST['txtCPF'];
		$DataNascimento	                   = $_POST['txtDtNasc'];
		$RG						           = $_POST['txtRG'];
		$RGOrgao				           = strtoupper($_POST['txtRGOrgao']);
		$RGOrgaoUF			               = $_POST['cmbRGUF'];
		$RGData					           = $_POST['txtRGDtExpedicao'];
		$Passaporte			               = $_POST['txtPassaporte'];
		$Sangue					           = $_POST['cmbGrupoSanguineo'];
		$Filho   				           = $_POST['txtFilho'];
		$Filha   				           = $_POST['txtFilha'];
		$NomePai				           = strtoupper(trim($_POST['txtPai']));
		$NomeMae 				           = strtoupper(trim($_POST['txtMae']));
		$Nacionalidade			           = $_POST['cmbNacionalidade'];
		$NaturalidadeUF			           = $_POST['cmbNaturalidadeUF'];
		$Naturalidade		    	       = $_POST['cmbNaturalidade'];
		$NivelTecnicoCurso 		           = $_POST['txtNivelEscolarCurso'];
		$NivelTecnicoInstituicao           = $_POST['txtNivelEscolarInstituicao'];
		$NivelTecnicoConselho  	           = $_POST['txtNivelEscolarConselho'];
		$NivelTecnicoSemestre  	           = $_POST['txtNivelEscolarSemestre'];
		
 	//atributos da entidade endereco
		$Endereco				          = strtoupper(trim($_POST['txtEndereco']));
		$EnderecoNumero			          = $_POST['txtNumero'];
		$EnderecoComplemento              = $_POST['txtComplemento'];
		$EnderecoReferencia	              = $_POST['txtReferencia'];
		$EnderecoCEP			          = $_POST['txtCEP'];
		$EnderecoUF				          = $_POST['cmbEnderecoUF'];
		$EnderecoMunicipio	              = $_POST['cmbEnderecoMunicipio'];
		$EnderecoBairro		              = strtoupper(trim($_POST['txtEnderecoBairro']));
		
  	//atributos da entidade funcionario
	
		$TituloEleitor			          = $_POST['txtTitulo'];
		$TituloEleitorZona		          = $_POST['txtTituloZona'];
		$TituloEleitorSecao		          = $_POST['txtTituloSecao'];
		$TituloEleitorUF		          = $_POST['cmbTituloUF'];
		$TituloEleitorCidade              = $_POST['cmbTituloCidade'];
		$Habilitacao			          = $_POST['txtHabilitacao'];
		$HabilitacaoCategoria             = $_POST['txtHabilitacaoCategoria'];
		$HabilitacaoValidade	          = $_POST['txtHabilitacaoValidade'];
		$HabilitacaoLenteCorretiva        = $_POST['txtHabilitacaoLenteCorretiva'];
		$Reservista				          = $_POST['txtReservista'];
		$ReservistaUF			          = $_POST['cmbReservistaUF'];
		$ReservistaMinisterio	          = $_POST['cmbMinisterio'];
	
		 //atributos da entidade telefone
		$TelefoneDDDResidencial           = $_POST['txtFoneDDDResidencial'];
		$TelefoneResidencial 	          = $_POST['txtFoneResidencial'];
		$TelefoneDDDComercial 	          = $_POST['txtFoneDDDComercial'];
		$TelefoneComercial	 	          = $_POST['txtFoneComercial'];
		$TelefoneDDDCelular 	          = $_POST['txtFoneDDDCelular'];
		$TelefoneCelular 		          = $_POST['txtFoneCelular'];
		$TelefoneDDDFax 		          = $_POST['txtFoneDDDFax'];
		$TelefoneFax 			          = $_POST['txtFonefax'];

        //verifica se já existe cpf
        $sqlConsultaExistente = "SELECT * FROM dados_unico.pessoa_fisica WHERE pessoa_fisica_cpf = '" .$CPF. "'";
       
        $rsConsultaExistente = pg_query(abreConexao(),$sqlConsultaExistente);

     
		If(pg_fetch_row($rsConsultaExistente)==0)
        {

                $BeginTrans= "BEGIN WORK";
                pg_query(abreConexao(),$BeginTrans);

                $DataCriacao = date("Y-m-d");

                //insere dados na tabela pessoa
                $sqlInsere = "INSERT INTO dados_unico.pessoa (pessoa_nm, pessoa_tipo, pessoa_email, pessoa_dt_criacao) VALUES ('" .$Nome. "', '" .$Tipo. "', '" .$Email. "', '" .$DataCriacao. "')";
                $sqlInsere = strtoupper($sqlInsere);
				
				pg_query(abreConexao(),$sqlInsere);
                //fim
                //pega o ultimo codigo inserido
                $sqlCodigo= "SELECT  last_value FROM dados_unico.seq_pessoa";
                $rsCodigo = pg_query(abreConexao(),$sqlCodigo);

                $ultimoValorSeq=pg_fetch_assoc($rsCodigo);

                //fim

                //insere dados da tabela pessoa_fisica
                $sqlInsere = "INSERT INTO dados_unico.pessoa_fisica (pessoa_id, nivel_escolar_id, pessoa_fisica_sexo, pessoa_fisica_cpf, pessoa_fisica_dt_nasc, pessoa_fisica_rg, pessoa_fisica_rg_orgao, pessoa_fisica_rg_uf, pessoa_fisica_rg_dt, pessoa_fisica_passaporte, estado_civil_id, pessoa_fisica_nm_pai, pessoa_fisica_nm_mae, pessoa_fisica_grupo_sanguineo, pessoa_fisica_filho, pessoa_fisica_filha,  pessoa_fisica_nacionalidade, pessoa_fisica_naturalidade, pessoa_fisica_naturalidade_uf, pessoa_fisica_clt, pessoa_fisica_clt_serie, pessoa_fisica_clt_uf, pessoa_fisica_titulo, pessoa_fisica_titulo_zona, pessoa_fisica_titulo_secao, pessoa_fisica_titulo_cidade, pessoa_fisica_titulo_uf, pessoa_fisica_cnh, pessoa_fisica_cnh_categoria, pessoa_fisica_cnh_validade,pessoa_fisica_cnh_lente_corretiva, pessoa_fisica_reservista, pessoa_fisica_reservista_ministerio, pessoa_fisica_reservista_uf, pessoa_fisica_pis) VALUES (" .$ultimoValorSeq['last_value']. ", '" .$NivelEscolar. "', '" .$Sexo. "', '" .$CPF. "', '" .$DataNascimento. "', '" .$RG. "', '" .$RGOrgao. "', '" .$RGOrgaoUF. "', '" .$RGData. "', '" .$Passaporte. "', '" .$EstadoCivil. "', '" .$NomePai. "', '" .$NomeMae. "', '" .$Sangue. "', '" .$Filho. "','" .$Filha. "', '" .$Nacionalidade. "', '".$Naturalidade. "', '".$NaturalidadeUF. "', '".$CartTrabalho. "', '".$CartTrabalhoSerie. "', '".$CartTrabalhoUF. "', '".$TituloEleitor. "', '".$TituloEleitorZona. "', '".$TituloEleitorSecao. "', '" .$TituloEleitorCidade. "', '" .$TituloEleitorUF. "', '" .$Habilitacao. "', '" .$HabilitacaoCategoria. "', '" .$HabilitacaoValidade. "', '" .$HabilitacaoLenteCorretiva."','" .$Reservista. "', '" .$ReservistaMinisterio. "', '" .$ReservistaUF. "', '" .$PIS. "')";
              
               $sqlInsere = strtoupper($sqlInsere);
			   
			   pg_query(abreConexao(),$sqlInsere);
                //fim

               //insere dados da tabela endereco
               $EnderecoCEP=str_replace("-","",$EnderecoCEP);
               $sqlInsere = "INSERT INTO dados_unico.endereco (pessoa_id, estado_uf, municipio_cd, endereco_bairro, endereco_ds, endereco_num, endereco_complemento,endereco_referencia, endereco_cep) VALUES (" .$ultimoValorSeq['last_value']. ", '" .$EnderecoUF. "', '" .$EnderecoMunicipio. "', '" .$EnderecoBairro. "', '" .$Endereco. "', '" .$EnderecoNumero. "', '" .$EnderecoComplemento. "', '" .$EnderecoReferencia. "', '" .$EnderecoCEP. "')";
     			    
                $sqlInsere = strtoupper($sqlInsere);
				
				pg_query(abreConexao(),$sqlInsere);
                //fim
				
				//Insere dados sobre nivel tecnico
				if ($NivelTecnicoCurso != "")
				{
		    		$sqlInsere = "INSERT INTO dados_unico.nivel_tecnico (pessoa_id, nivel_tecnico_curso_ds, nivel_tecnico_instituicao_ds, nivel_tecnico_conselho, nivel_tecnico_semestre) VALUES (" .$ultimoValorSeq['last_value']. ", '" .$NivelTecnicoCurso. "', '" .$NivelTecnicoInstituicao. "', '" .$NivelTecnicoConselho. "', '" .$NivelTecnicoSemestre. "')";
					$sqlInsere = strtoupper($sqlInsere);
					pg_query(abreConexao(),$sqlInsere);
				}
				// Fim 

                //insere telefones
                If ($TelefoneResidencial != "")
                {
                    $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneResidencial. "', '" .$TelefoneDDDResidencial. "', 'R')";
                    
					$sqlInsere = strtoupper($sqlInsere);
					
					pg_query(abreConexao(),$sqlInsere);
                }

                If ($TelefoneCelular != "")
                {
                    $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneCelular. "', '" .$TelefoneDDDCelular. "', 'M')";
                    
					$sqlInsere = strtoupper($sqlInsere);
					
					pg_query(abreConexao(),$sqlInsere);
                }

                If ($TelefoneComercial != "")
                {
                    $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneComercial. "', '" .$TelefoneDDDComercial. "', 'C')";
                    
					$sqlInsere = strtoupper($sqlInsere);
					
					pg_query(abreConexao(),$sqlInsere);
                }

                If ($TelefoneFax != "")
                {
                    $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$ultimoValorSeq['last_value']. ",'" .$TelefoneFax. "', '" .$TelefoneDDDFax. "', 'F')";
                    
					$sqlInsere = strtoupper($sqlInsere);
					
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
                     echo "<script>window.location = 'FisicaInicio.php ';</script>";
        }

        Else
        {
                 $MensagemErroBD = "CPF j&aacute; existente.";

        }
    }
	ElseIf ($AcaoSistema == "consultar")
    {
			$Codigo = $_GET['cod'];

			If ($Codigo == "")
            {

				$Codigo = $_POST['checkbox'];

				$sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E WHERE (e.pessoa_id = p.pessoa_id) AND(P.pessoa_id = PF.pessoa_id) AND P.pessoa_id IN (" .$Codigo. ")";
            }
			Else
			{	$sqlConsulta = "SELECT * FROM dados_unico.pessoa P, dados_unico.pessoa_fisica PF, dados_unico.endereco E WHERE (e.pessoa_id = p.pessoa_id) AND(P.pessoa_id = PF.pessoa_id) AND P.pessoa_id = " .$Codigo;
            }

            $rsConsulta = pg_query(abreConexao(),$sqlConsulta);
  
            $linha=pg_fetch_assoc( $rsConsulta);
			If($linha)
            {

					//atributos da entidade pessoa
					$Codigo					= $linha['pessoa_id'];
					$StatusNumero			= $linha['pessoa_st'];
					$PessoaDataCriacao		= $linha['pessoa_dt_criacao'];
					$PessoaDataAlteracao	= $linha['pessoa_dt_alteracao'];
					$Nome					= $linha['pessoa_nm'];
					$Email					= $linha['pessoa_email'];
					$NivelEscolar			= $linha['nivel_escolar_id'];
					$EstadoCivil			= $linha['estado_civil_id'];
					$Sexo					= $linha['pessoa_fisica_sexo'];
					$CPF					= $linha['pessoa_fisica_cpf'];
					$DataNascimento			= $linha['pessoa_fisica_dt_nasc'];
					$RG						= $linha['pessoa_fisica_rg'];
					$RGOrgao				= $linha['pessoa_fisica_rg_orgao'];
					$RGOrgaoUF				= $linha['pessoa_fisica_rg_uf'];
					$RGData					= $linha['pessoa_fisica_rg_dt'];
					$Passaporte				= $linha['pessoa_fisica_passaporte'];
					$Sangue					= $linha['pessoa_fisica_grupo_sanguineo'];
                	$Filho					= $linha['pessoa_fisica_filho'];
                    $Filha					= $linha['pessoa_fisica_filha'];
					$NomePai				= $linha['pessoa_fisica_nm_pai'];
					$NomeMae 				= $linha['pessoa_fisica_nm_mae'];
					$Nacionalidade			= $linha['pessoa_fisica_nacionalidade'];
					$NaturalidadeUF			= $linha['pessoa_fisica_naturalidade_uf'];
					$Naturalidade			= $linha['pessoa_fisica_naturalidade'];

					If ($Sexo == "M")
                    {
						$SexoMasc = "checked";
						$SexoFem  = "";
                    }
					ElseIf ($Sexo == "F")
                    {
						$SexoMasc = "";
						$SexoFem  = "checked";
                    }
					Else
					{	$SexoMasc = "";
						$SexoFem  = "";
                    }

					$TituloEleitor			= $linha['pessoa_fisica_titulo'];
					$TituloEleitorZona		= $linha['pessoa_fisica_titulo_zona'];
					$TituloEleitorSecao		= $linha['pessoa_fisica_titulo_secao'];
					$TituloEleitorUF		= $linha['pessoa_fisica_titulo_uf'];
					$TituloEleitorCidade	= $linha['pessoa_fisica_titulo_cidade'];
					$Habilitacao			= $linha['pessoa_fisica_cnh'];
					$HabilitacaoCategoria	= $linha['pessoa_fisica_cnh_categoria'];
					$HabilitacaoValidade	= $linha['pessoa_fisica_cnh_validade'];
					$HabilitacaoLenteCorretiva	= $linha['pessoa_fisica_cnh_lente_corretiva'];
					$Reservista				= $linha['pessoa_fisica_reservista'];
					$ReservistaUF			= $linha['pessoa_fisica_reservista_uf'];
					$ReservistaMinisterio	= $linha['pessoa_fisica_reservista_ministerio'];
					$Endereco				= $linha['endereco_ds'];
					$EnderecoNumero			= $linha['endereco_num'];
					$EnderecoComplemento	= $linha['endereco_complemento'];
					$EnderecoReferencia	    = $linha['endereco_referencia'];
					$EnderecoCEP			= $linha['endereco_cep'];
					$EnderecoUF				= $linha['estado_uf'];
					$EnderecoMunicipio		= $linha['municipio_cd'];
					$EnderecoBairro			= $linha['endereco_bairro'];
	
					If ($StatusNumero == "0")
                    {  $StatusNome = "Ativo";

                    }
                     Else
                     {  $StatusNome = "Inativo";

                     }
					 //se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados
					$sqlConsultaNivelTecnico = "SELECT nivel_tecnico_curso_ds, nivel_tecnico_instituicao_ds, nivel_tecnico_conselho, nivel_tecnico_semestre FROM dados_unico.nivel_tecnico WHERE pessoa_id = " .$Codigo;
					$rsConsultaNivelTecnico = pg_query(abreConexao(),$sqlConsultaNivelTecnico);
					$linha2=pg_fetch_assoc($rsConsultaNivelTecnico);
		
					if($linha2)
					{
					$NivelTecnicoCurso 		          = $linha2['nivel_tecnico_curso_ds'];
					$NivelTecnicoInstituicao          = $linha2['nivel_tecnico_instituicao_ds'];
					$NivelTecnicoConselho             = $linha2['nivel_tecnico_conselho'];
					$NivelTecnicoSemestre             = $linha2['nivel_tecnico_semestre'];
					}

					//se pessoa possuir nivel tecnico como nivel escolar, entao consultar dados
					$sqlConsultaTelefone = "SELECT * FROM dados_unico.telefone WHERE pessoa_id = " .$Codigo;
                    $rsConsultaTelefone =pg_query(abreConexao(),$sqlConsultaTelefone);
					while($linha3=pg_fetch_assoc($rsConsultaTelefone))
                    {
                        If ($linha3['telefone_tipo']== "R")
                        {  $TelefoneDDDResidencial 	= $linha3['telefone_ddd'];
                            $TelefoneResidencial 	= $linha3['telefone_num'];
                        }
                        ElseIf ($linha3['telefone_tipo']== "M")
                        {
                            $TelefoneDDDCelular 	= $linha3['telefone_ddd'];
                            $TelefoneCelular 		= $linha3['telefone_num'];
                        }
                        ElseIf ($linha3['telefone_tipo']== "C")
                        {
                            $TelefoneDDDComercial 	= $linha3['telefone_ddd'];
                            $TelefoneComercial 		= $linha3['telefone_num'];
                        }
                        ElseIf ($linha3['telefone_tipo']== "F" )
                        {	$TelefoneDDDFax 		= $linha3['telefone_ddd'];
                            $TelefoneFax 			= $linha3['telefone_num'];
                        }

                    }
            }
    }
	ElseIf ($AcaoSistema == "alterar")
    {

			$Codigo									= $_POST['txtCodigo'];
			$EstruturaOriginal						= $_POST['txtEstruturaOriginal'];
			$Nome									= strtoupper(trim($_POST['txtNome']));
			$Email									= strtolower(trim($_POST['txtEmail']));
			$DataAlteracao 							= date("Y-m-d");
			$NivelEscolar							= $_POST['cmbNivelEscolar'];
			$EstadoCivil							= $_POST['cmbEstadoCivil'];
			$Sexo									= $_POST['rdSexo'];
			$CPF									= $_POST['txtCPF'];
			$DataNascimento							= $_POST['txtDtNasc'];
			$RG										= $_POST['txtRG'];
			$RGOrgao								= strtoupper($_POST['txtRGOrgao']);
			$RGOrgaoUF								= $_POST['cmbRGUF'];
			$RGData									= $_POST['txtRGDtExpedicao'];
			$Passaporte								= $_POST['txtPassaporte'];
			$Sangue									= $_POST['cmbGrupoSanguineo'];
            $Filho									= $_POST['txtFilho'];
            $Filha									= $_POST['txtFilha'];
			$NomePai								= strtoupper(trim($_POST['txtPai']));
			$NomeMae 								= strtoupper(trim($_POST['txtMae']));
			$Nacionalidade							= $_POST['cmbNacionalidade'];
			$NaturalidadeUF							= $_POST['cmbNaturalidadeUF'];
			$Naturalidade						 	= $_POST['cmbNaturalidade'];
			$NivelTecnicoCurso                   	= $_POST['txtNivelEscolarCurso'];
			$NivelTecnicoInstituicao             	= $_POST['txtNivelEscolarInstituicao'];
			$NivelTecnicoConselho  	             	= $_POST['txtNivelEscolarConselho'];
			$NivelTecnicoSemestre  	             	= $_POST['txtNivelEscolarSemestre'];
			$Endereco                            	= strtoupper(trim($_POST['txtEndereco']));
			$EnderecoNumero                      	= $_POST['txtNumero'];
			$EnderecoComplemento                 	= $_POST['txtComplemento'];
			$EnderecoReferencia                  	= $_POST['txtReferencia'];
			$EnderecoCEP                        	= $_POST['txtCEP'];
			$EnderecoUF                          	= $_POST['cmbEnderecoUF'];
			$EnderecoMunicipio                   	= $_POST['cmbEnderecoMunicipio'];
			$Endereco                            	= strtoupper(trim($_POST['txtEndereco']));
			$TituloEleitor                       	= $_POST['txtTitulo'];
			$TituloEleitorZona                   	= $_POST['txtTituloZona'];
			$TituloEleitorSecao                 	= $_POST['txtTituloSecao'];
			$TituloEleitorUF                    	= $_POST['cmbTituloUF'];
			$TituloEleitorCidade                	= $_POST['cmbTituloCidade'];
			$Habilitacao                        	= $_POST['txtHabilitacao'];
			$HabilitacaoCategoria               	= $_POST['txtHabilitacaoCategoria'];
			$HabilitacaoValidade                 	= $_POST['txtHabilitacaoValidade'];
			$HabilitacaoLenteCorretiva           	= $_POST['txtHabilitacaoLenteCorretiva'];
			$Reservista                          	= $_POST['txtReservista'];
			$ReservistaUF                        	= $_POST['cmbReservistaUF'];
			$ReservistaMinisterio                	= $_POST['cmbMinisterio'];
			$TelefoneDDDResidencial              	= $_POST['txtFoneDDDResidencial'];
			$TelefoneResidencial 	             	= $_POST['txtFoneResidencial'];
			$TelefoneDDDComercial                	= $_POST['txtFoneDDDComercial'];
			$TelefoneComercial	 	             	= $_POST['txtFoneComercial'];
			$TelefoneDDDCelular 	             	= $_POST['txtFoneDDDCelular'];
			$TelefoneCelular 		             	= $_POST['txtFoneCelular'];
			$TelefoneDDDFax 		             	= $_POST['txtFoneDDDFax'];
			$TelefoneFax 			             	= $_POST['txtFonefax'];
			$EnderecoBairro		              		= strtoupper(trim($_POST['txtEnderecoBairro']));
	
			$sqlConsultaExistente = "SELECT PF.pessoa_id FROM dados_unico.pessoa_fisica PF WHERE (pessoa_fisica_cpf = '" .$CPF. "') AND PF.pessoa_id <> " .$Codigo;
            $rsConsultaExistente = pg_query(abreConexao(),$sqlConsultaExistente);


            If (pg_fetch_row($rsConsultaExistente)==0)
            {      $BeginTrans= "BEGIN WORK";
                   pg_query(abreConexao(),$BeginTrans);

					

					$sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_nm = '".$Nome."',pessoa_email = '" .$Email. "', pessoa_dt_alteracao = '" .$DataAlteracao."' WHERE pessoa_id = ".$Codigo;

					pg_query(abreConexao(),$sqlAltera);

					$sqlAltera = "UPDATE dados_unico.pessoa_fisica SET pessoa_fisica_sexo = '".$Sexo. "', pessoa_fisica_cpf = '".$CPF. "', pessoa_fisica_dt_nasc = '".$DataNascimento. "', pessoa_fisica_rg = '".$RG."', pessoa_fisica_rg_orgao = '".$RGOrgao."', pessoa_fisica_rg_uf = '".$RGOrgaoUF. "', pessoa_fisica_rg_dt = '".$RGData. "', pessoa_fisica_passaporte = '".$Passaporte. "', pessoa_fisica_nm_pai = '".$NomePai. "', pessoa_fisica_nm_mae = '".$NomeMae. "', pessoa_fisica_grupo_sanguineo = '".$Sangue. "',pessoa_fisica_filho = '".$Filho. "', pessoa_fisica_filha = '".$Filha. "', pessoa_fisica_nacionalidade = '".$Nacionalidade. "', pessoa_fisica_naturalidade = '".$Naturalidade. "', pessoa_fisica_naturalidade_uf = '".$NaturalidadeUF. "', pessoa_fisica_clt = '" .$CartTrabalho. "', pessoa_fisica_clt_serie = '" .$CartTrabalhoSerie. "', pessoa_fisica_clt_uf = '" .$CartTrabalhoUF. "', pessoa_fisica_titulo = '" .$TituloEleitor. "', pessoa_fisica_titulo_zona = '" .$TituloEleitorZona. "', pessoa_fisica_titulo_secao = '" .$TituloEleitorSecao. "', pessoa_fisica_titulo_cidade = '" .$TituloEleitorCidade. "', pessoa_fisica_titulo_uf = '" .$TituloEleitorUF. "', pessoa_fisica_cnh = '" .$Habilitacao. "', pessoa_fisica_cnh_categoria = '" .$HabilitacaoCategoria. "', pessoa_fisica_cnh_validade = '" .$HabilitacaoValidade. "',pessoa_fisica_cnh_lente_corretiva = '".$HabilitacaoLenteCorretiva. "', pessoa_fisica_reservista = '" .$Reservista. "', pessoa_fisica_reservista_ministerio = '" .$ReservistaMinisterio. "', pessoa_fisica_reservista_uf = '" .$ReservistaUF. "', pessoa_fisica_pis = '" .$PIS. "', 	estado_civil_id = " .$EstadoCivil. ", nivel_escolar_id = " .$NivelEscolar. " WHERE pessoa_id = ".$Codigo;
					pg_query(abreConexao(),$sqlAltera);

					// Altera o nivel técnico .. 
					// *****************************************************************************
					$sqlTeste="SELECT * FROM dados_unico.nivel_tecnico where pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					if(pg_fetch_row($rsTeste)==0)
					{
						$sqlInsere = "INSERT INTO dados_unico.nivel_tecnico (pessoa_id, nivel_tecnico_curso_ds, nivel_tecnico_instituicao_ds, nivel_tecnico_conselho,  nivel_tecnico_semestre) VALUES (" .$Codigo. ", '" .$NivelTecnicoCurso. "', '" .$NivelTecnicoInstituicao. "', '" .$NivelTecnicoConselho."', '" .$NivelTecnicoSemestre."')";
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{
						$sqlAltera = "UPDATE dados_unico.nivel_tecnico SET nivel_tecnico_curso_ds = '" .$NivelTecnicoCurso."', nivel_tecnico_instituicao_ds = '" .$NivelTecnicoInstituicao."', nivel_tecnico_conselho = '" .$NivelTecnicoConselho."', nivel_tecnico_semestre = '" .$NivelTecnicoSemestre."' WHERE pessoa_id = " .$Codigo;
						pg_query(abreConexao(),$sqlAltera);
					}
					// *****************************************************************************
					// Fim 		


					$sqlAltera = "UPDATE dados_unico.endereco SET estado_uf = '" .$EnderecoUF."', municipio_cd = '" .$EnderecoMunicipio."', endereco_bairro = '" .$EnderecoBairro."', endereco_ds = '" .$Endereco."', endereco_num = '" .$EnderecoNumero."', endereco_cep = '" .$EnderecoCEP."', endereco_complemento = '" .$EnderecoComplemento."' , endereco_referencia = '" .$EnderecoReferencia."' WHERE pessoa_id = " .$Codigo;

 					pg_query(abreConexao(),$sqlAltera);

					// Dados do Telefone residencial .. 
					// ********************************************************************

					$sqlTeste="SELECT * FROM dados_unico.telefone where telefone_tipo = 'R' and  telefone_num='" .$TelefoneResidencial."'AND pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					If(pg_fetch_row($rsTeste)==0)
					{   $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneResidencial. "', '" .$TelefoneDDDResidencial. "', 'R')";
						
						$sqlInsere = strtoupper($sqlInsere);
						
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{  $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneResidencial."',telefone_ddd = '" .$TelefoneDDDResidencial."'WHERE telefone_tipo = 'R' AND pessoa_id = " .$Codigo;
					   
					   $sqlInsere = strtoupper($sqlInsere);
					   
					   pg_query(abreConexao(),$sqlAltera);
					}
				   	
					// Dados do Telefone Celular .. 
					// ********************************************************************
					$sqlTeste="SELECT * FROM dados_unico.telefone where telefone_tipo = 'M' and telefone_num='" .$TelefoneCelular."'AND pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					
					If(pg_fetch_row($rsTeste)==0)
					{  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneCelular. "', '" .$TelefoneDDDCelular. "', 'M')";
						$sqlInsere = strtoupper($sqlInsere);
						
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{
					 $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneCelular."',telefone_ddd = '" .$TelefoneDDDCelular."'WHERE telefone_tipo = 'M' AND pessoa_id = " .$Codigo;
						pg_query(abreConexao(),$sqlAltera);
					}
					// Fim 
					// ********************************************************************
				  

					// Dados do Telefone Comercial .. 
					// ********************************************************************
					$sqlTeste="SELECT * FROM dados_unico.telefone where telefone_tipo = 'C' and  telefone_num='" .$TelefoneComercial."'AND pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					If(pg_fetch_row($rsTeste)==0)
					{  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneComercial. "', '" .$TelefoneDDDComercial. "', 'C')";
						
						$sqlInsere = strtoupper($sqlInsere);
						
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{
					   $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneComercial."',telefone_ddd = '" .$TelefoneDDDComercial."'WHERE telefone_tipo = 'C' AND pessoa_id = " .$Codigo;
					   pg_query(abreConexao(),$sqlAltera);
		
					}
					// Fim 
					// ********************************************************************
		
					// Dados do Telefone Fax .. 
					// ********************************************************************
					$sqlTeste="SELECT * FROM dados_unico.telefone where telefone_tipo = 'F' and telefone_num='" .$TelefoneFax."'AND pessoa_id=".$Codigo;
					$rsTeste=pg_query(abreConexao(),$sqlTeste);
					If(pg_fetch_row($rsTeste)==0)
					{  $sqlInsere = "INSERT INTO dados_unico.telefone (pessoa_id, telefone_num, telefone_ddd, telefone_tipo) VALUES (" .$Codigo. ",'" .$TelefoneFax. "', '" .$TelefoneDDDFax. "', 'F')";
						$sqlInsere = strtoupper($sqlInsere);
						
						pg_query(abreConexao(),$sqlInsere);
					}
					else
					{
					 $sqlAltera = "UPDATE dados_unico.telefone SET telefone_num = '" .$TelefoneFax."',telefone_ddd = '" .$TelefoneDDDFax."'WHERE telefone_tipo = 'F' AND pessoa_id = " .$Codigo;
					pg_query(abreConexao(),$sqlAltera);
		
					}
					// Fim 
					// ********************************************************************

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
              
                     echo "<script>window.location = 'FisicaInicio.php ';</script>";
            }

			Else
            {
					 $MensagemErroBD = "CPF j&aacute; existente.";

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

            $sqlAltera = "UPDATE dados_unico.pessoa SET pessoa_st = ".$StatusCod.", pessoa_dt_alteracao = '" .$DataAlteracao. "' WHERE pessoa_id = " .$Codigo;
            pg_query(abreConexao(),$sqlAltera);

             echo "<script>window.location = 'FisicaInicio.php ';</script>";
        }
		ElseIf($AcaoSistema == "excluir")
        {
            $ExcluirCheckbox = $_GET['excluirMultiplo'];

            If ($ExcluirCheckbox == 1)
            {

                $Codigo	= $_POST['txtCodigo'];
                $sqlDeleta = "UPDATE dados_unico.pessoa SET pessoa_st = 2 WHERE pessoa_id IN (" .$Codigo. ")";
            }

            Else
            {

                $Codigo	= $_GET['cod'];
                $sqlDeleta = "UPDATE dados_unico.pessoa SET pessoa_st = 2 WHERE pessoa_id = ".$Codigo;
            }



            pg_query(abreConexao(),$sqlDeleta);


            echo "<script>window.location = 'FisicaInicio.php ';</script>";

    }




?>
