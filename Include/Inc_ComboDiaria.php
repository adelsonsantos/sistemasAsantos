<?php
//funcao que exibe combo com os beneficiarios da diaria
 Function ComboBeneficiario($Beneficiario, $FuncaoJavaScript)
 {  
    echo "<select id=cmbBeneficiario name=cmbBeneficiario style=width:382px; ".$FuncaoJavaScript.">";
    $sql = "SELECT f.pessoa_id, pessoa_nm, funcionario_matricula 
              FROM dados_unico.pessoa p ,dados_unico.funcionario f
             WHERE (p.pessoa_id = f.pessoa_id) 
               AND pessoa_st = 0 
               AND funcionario_tipo_id <> 3 
               AND funcionario_validacao_rh = 1 
           ORDER BY UPPER(pessoa_nm)";

    $rs = pg_query(abreConexao(),$sql);   
    
    if($Beneficiario == 'todos')
    {
        echo "<option selected value=0>[----------------------------------------------- Todos -----------------------------------------------]</option>";
    }
    elseif($Beneficiario == '')
    {
        echo "<option value=0>[--------------------------------------------- Selecione ---------------------------------------------]</option>";
    }
    //converte para inteiro o (int)$codigoEscolhido
    while ($linha = pg_fetch_assoc($rs))
    { 
        if ($Beneficiario == $linha['pessoa_id'])
        {   
            echo "<option selected value=".$linha['pessoa_id'].">".$linha['pessoa_nm']." - ".$linha['funcionario_matricula']."</option>";
        }
        else
        {				
            echo "<option value=" .$linha['pessoa_id'].">".$linha['pessoa_nm']." - ".$linha['funcionario_matricula']."</option>";				
        }

    }
}

Function ComboACP($codigoEscolhido, $FuncaoJavaScript)
{  
    echo "<select name=cmbUnidadeCusto id=cmbUnidadeCusto style=width:785px; ".$FuncaoJavaScript.">";
    $sql = "SELECT * FROM dados_unico.est_organizacional WHERE est_organizacional_centro_custo = 1 AND
    est_organizacional_st = 0 ORDER BY est_organizacional_centro_custo_num";
    $rs=pg_query(abreConexao(),$sql);
    echo "<option value=0>[--------------------------------------------------------------------------------------------------------- Selecione ---------------------------------------------------------------------------------------------------------]</option>";    

    while ($linha=pg_fetch_assoc($rs))
    {  
        if($codigoEscolhido!="")
        {  
            if ((int)$codigoEscolhido==(int)$linha['est_organizacional_id'])
            {  
                echo  "<option value=".$linha['est_organizacional_id']." selected>".$linha['est_organizacional_centro_custo_num']." ----> "
                .$linha['est_organizacional_sigla']." ----> ".$linha['est_organizacional_ds']."</option>";
            }
            else
            {  
                echo "<option value=".$linha['est_organizacional_id'].">".$linha['est_organizacional_centro_custo_num']. " ----> "
                .$linha['est_organizacional_sigla']." ----> ".$linha['est_organizacional_ds']."</option>";
            }
        }
        else
        {  
            echo "<option value=".$linha['est_organizacional_id'].">".$linha['est_organizacional_centro_custo_num']." ----> "
            .$linha['est_organizacional_sigla']." ----> ".$linha['est_organizacional_ds']."</option>";
        }
    }
    echo "</select>";
}
?>
