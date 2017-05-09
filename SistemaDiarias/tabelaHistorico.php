
            <table width="100%" border="0" cellpadding="0" cellspacing="1" class="TabelaFormulario">
                <tr height="21">
                    <td class="dataTitulo" width="320" colspan="7">&nbsp;Hist&oacute;rico</td>
                </tr>
                <tr height="21">
                    <td width="1%" class="dataLabel">&nbsp;#</td>
                    <td width="40%" class="dataLabel">&nbsp;Nome</td>
                    <td width="8%" class="dataLabel">&nbsp;Data</td>
                    <td width="8%" class="dataLabel">&nbsp;Hora</td>
                    <td width="19%" class="dataLabel">&nbsp;Status</td>
                </tr>
				<?php
					include "historico.class.php";
					
					$result = new Historico($Codigo);
					
					$cont = 1;
					$cor = 1;
					$reg = $result->getRegistros();
					if($reg)
						foreach($reg as $registro)
						{
							if($cor == 1)
								$classe = "dataField";
							else
								$classe = "dataField2";
							$cor *= -1;
							
							echo "<tr height='21'>";
                                                            echo "  <td class='$classe'>&nbsp;<b>".$cont++."&nbsp;</b></td>";
                                                            echo "  <td class='$classe'>&nbsp;".$registro["Nome"]."</td>";
                                                            echo "  <td class='$classe'>&nbsp;".$registro["Data"]."</td>";
                                                            echo "  <td class='$classe'>&nbsp;".$registro["Hora"]."</td>";
                                                            echo "  <td class='$classe'>&nbsp;".$registro["Tabela"]."</td>";
							echo "</tr>";
						}
				?>
         </table>