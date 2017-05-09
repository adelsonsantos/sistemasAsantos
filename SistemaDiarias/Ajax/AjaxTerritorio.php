<?php
include "../../Include/Inc_Configuracao.php";?>
&nbsp;<?=f_ComboTerritorio($_GET['acao_cd'],"","onChange=MandaID(this.value,'AjaxFonte','territorio_cd')","")?>
