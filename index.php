<?
$u_agent = $_SERVER['HTTP_USER_AGENT'];
        $ub = '';
//        if(!preg_match('/MSIE/i',$u_agent))
//        {
//            //$ub = "Favor ultilizar o Internet Explorer";
//            ?><!--
                <script language="javascript">
                    alert("Favor ultilizar o Internet Explorer");
                </script>-->
            <?
//        exit;
//        }
        //header("Location: Home/Login_Manutencao.php");
	header("Location: Home/Login.php");
?>	
                
                