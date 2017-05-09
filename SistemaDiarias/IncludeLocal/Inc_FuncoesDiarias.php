<?php
/*COMBO DAS CORDENADORIAS*/
function f_ComboCordenadoriasInterior($nome, $tamanho, $codigo)
{
    echo'<select id="'.$nome.'" name="'.$nome.'" style="width:'.$tamanho.'px;">';
    echo'<option selected value="0">[-------Selecione-------]</option>';
    $sql = "SELECT id_coordenadoria, nome 
              FROM diaria.coordenadoria 
            ORDER BY nome ASC";
    $consulta = pg_query(abreConexao(),$sql);
    if (pg_num_rows($consulta)) 
    {
        while ($linhaCordenadorias = pg_fetch_assoc($consulta)) 
        {
            $idCoordenadoria    = $linhaCordenadorias["id_coordenadoria"];
            $nomeCoordenadoria  = $linhaCordenadorias["nome"];
            if($codigo == $idCoordenadoria)
            {
                echo '<option value = "'.$idCoordenadoria.'" selected>'.$nomeCoordenadoria.'</option>';                
            }
            else
            {
                echo '<option value = "'.$idCoordenadoria.'">'.$nomeCoordenadoria.'</option>';
            }
        }
    }
    echo '</select>';
}
/*COMBO DAS FONTES*/
function f_ComboFontes($nome,$tamanho,$codigo,$funcaoJavaScript,$tracos)
{    
    $tracos = geraDescricaoSelecione($tracos);
    
    echo'<select id="'.$nome.'" name="'.$nome.'" '.$funcaoJavaScript.' style="width:'.$tamanho.'px;">';
        echo'<option value="0">'.$tracos.'</option>';
        
    $sql      = "SELECT fonte_cd,fonte_ds FROM diaria.fonte WHERE fonte_st != 2 ORDER BY UPPER(fonte_cd)";
    $consulta = pg_query(abreConexao(),$sql);
    
    while($linhaFonte = pg_fetch_assoc($consulta)) 
    {
        if(trim($codigo) == trim($linhaFonte['fonte_cd']))
        {
            echo '<option value ="'.$linhaFonte['fonte_cd'].'" selected>'.$linhaFonte['fonte_cd'].' - '.$linhaFonte['fonte_ds'].'</option>';                
        }
        else
        {
            echo '<option value = "'.$linhaFonte['fonte_cd'].'">'.$linhaFonte['fonte_cd'].' - '.$linhaFonte['fonte_ds'].'</option>';
        }
    }
    echo '</select>';
}
/*COMBO DOS PROJETOS*/
function f_ComboProjetos($nome,$tamanho,$codigo,$funcaoJavaScript,$tracos)
{  
    $tracos = geraDescricaoSelecione($tracos);
    
    echo'<select id="'.$nome.'" name="'.$nome.'" '.$funcaoJavaScript.' style="width:'.$tamanho.'px;">';
        echo'<option value="0">'.$tracos.'</option>';
        
        $sql = "SELECT projeto_cd, projeto_ds FROM diaria.projeto WHERE projeto_st = 0 ORDER BY projeto_cd";
        $rs  = pg_query(abreConexao(),$sql);
        
            while($linha = pg_fetch_assoc($rs))
            {  
                if(trim($codigo) == trim($linha['projeto_cd']))
                {  
                    echo "<option value=".$linha['projeto_cd']. " selected>" .$linha['projeto_cd']. " ----> ".$linha['projeto_ds']."</option>";//echo "<input type='hidden' name='cmbProjetoPC' value='".$linha['projeto_convenio']."'";	
                }
                else
                { 
                    echo "<option value=" .$linha['projeto_cd']. ">" .$linha['projeto_cd']. " ----> " .$linha['projeto_ds']. "</option>";// echo "<input type='hidden' name='cmbProjetoPC' value='".$linha['projeto_convenio']."'";
                }
            }
    echo "</select>";
}
/*COMBO DAS ETAPAS*/
function f_ComboEtapas($nome,$tamanho,$codigo,$funcaoJavaScript,$tracos,$projeto,$fonte)
{  
    $tracos = geraDescricaoSelecione($tracos);
    
    echo'<select id="'.$nome.'" name="'.$nome.'" '.$funcaoJavaScript.' style="width:'.$tamanho.'px;">';
        echo'<option value="0">'.$tracos.'</option>';
        
        if(($fonte == '')&&($projeto == ''))
        {
            $sql = "SELECT * FROM diaria.etapa WHERE etapa_st = 0 ORDER BY etapa_meta, etapa_codigo";
        }
        else
        {
            $sql = "SELECT * FROM diaria.etapa WHERE projeto_id = $projeto AND fonte_id = '".$fonte."' AND etapa_st = 0 ORDER BY etapa_meta, etapa_codigo";
        }
        $rs  = pg_query(abreConexao(),$sql);
        
            while($linha = pg_fetch_assoc($rs))
            {  
                if(trim($codigo) == trim($linha['etapa_id']))
                {  
                    echo "<option value=".$linha['etapa_id']. " selected>" .$linha['etapa_codigo']. " -- ".$linha['etapa_ds']."</option>";
                }
                else
                { 
                    echo "<option value=".$linha['etapa_id']. ">" .$linha['etapa_codigo']. " -- ".$linha['etapa_ds']."</option>";
                }
            }
    echo "</select>";
}
/*FUNÇÃO QUE GERA A PRIMEIRA LINHA DE UM COMBO*/
function geraDescricaoSelecione($numeroTracos)
{
    if($numeroTracos % 2 == 0)
    {
        $controle = $numeroTracos / 2;
        for($i = 0; $i < $controle; $i++) 
        {
            $montarRetorno .= ' - '; 
        }        
    }
    else
    {        
        $controle = ($numeroTracos + 1) / 2;
        for($i = 0; $i < $controle; $i++) 
        {
            $montarRetorno .= ' - '; 
        }
    }
    
    $selecione = '['.$montarRetorno.' SELECIONE '.$montarRetorno.']';
    
    return $selecione;
}

function f_ComboAno($nome,$tamanho,$codigo,$funcaoJavaScript,$tracos)
{           
    echo'<select id="'.$nome.'" name="'.$nome.'" '.$funcaoJavaScript.' style="width:'.$tamanho.'px;">';        
        
    $sql      = "SELECT DISTINCT SUBSTRING(diaria_dt_saida,7,10) AS ano
                   FROM diaria.diaria
               ORDER BY SUBSTRING(diaria_dt_saida,7,10) DESC";
    $consulta = pg_query(abreConexao(),$sql);
    
    while($linhaAno = pg_fetch_assoc($consulta)) 
    {
        if(trim($codigo) == trim($linhaAno['ano']))
        {
            echo '<option value ="'.$linhaAno['ano'].'" selected>'.$linhaAno['ano'].'</option>';                
        }
        else
        {
            echo '<option value ="'.$linhaAno['ano'].'">'.$linhaAno['ano'].'</option>';
        }
    }
    echo '</select>';
}

?>
