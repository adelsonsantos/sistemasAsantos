<?php 
include "../../Include/Inc_Configuracao.php";

f_ComboAcao("",$_GET['projeto_cd'],"onChange=MandaID(this.value,'AjaxTerritorio','acao_cd')");
        
?>