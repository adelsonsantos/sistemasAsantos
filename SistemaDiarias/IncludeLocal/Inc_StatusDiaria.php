<?php
//TRATAMENTO DOS STATUS
switch ($linhaDiaria['diaria_st']) 
{
    case 100:
        $StatusNome = "Pré Autorização"; // Modificado por Erinaldo em 18/02/2011
        break;
    case 0:
        $StatusNome = "Autorização";
        break;
    case 1:
        $StatusNome = "Aprovação";
        break;
    case 2:
        $StatusNome = "Empenho";
        break;
    case 3:
        $StatusNome = "Execução";
        break;
    case 4:
        $StatusNome = "Comprovação";
        break;
    case 5:
        $StatusNome = "Aprovação de Comprovação";
        break;
    case 6:
        $StatusNome = "Aguardando Arquivamento";
        break;
    case 7:
        $StatusNome = "Arquivada";
        break;
}

//TRATAMENTO DAS EXEÇÕES DO STATUS

if (($diariaDevolvida == "1")||($diariaDevolvida == "2"))
{
    $StatusNome .= " (Devolvida)";
}

if ($diariaCancelada == 1) 
{
    $StatusNome .= " (Cancelada)";
}

if (($Status == 3)&&($diariaComprovada == 1))
{
    $StatusNome .= " (Comprovada)";
}

if ($diaria_Excluida == 1) 
{
    $StatusNome = " (Excluída)";
}

if (($Status == 100) && ($diariaLocal == "Coordenadoria" )) 
{
    $StatusNome = "Pré Autorização";
} 
?>
