﻿<?php
include "../Include/Inc_Configuracao.php";
		
$sqlConsulta = "SELECT diaria_id, diaria_numero, diaria_solicitante, diaria_beneficiario,diaria_st
  FROM diaria.diaria 
  where diaria_st = '7' and
  diaria_numero In (
  '201107523',
  '201107013',
  '201107702',
  '201107705',
  '201108228',
  '201102067',
  '201106564',
  '201104227',
  '201108423',
  '201108424',
  '201107934',
  '201103734',
  '201101208',
  '201107730',
  '201107731',
  '201101787',
  '201103058',
  '201100236',
  '201101232',
  '201101757',
  '201106715',
  '201106476',
  '201106716',
  '201106417',
  '201107019',
  '201107774',
  '201101794',
  '201108133',
  '201108137',
  '201103059',
  '201104397',
  '201107779',
  '201107778',
  '201104379',
  '201108236',
  '201107781',
'201107780',
'201107509',
'201107732',
'201107780',
'201104382',
'201107772',
'201104075',
'201106879',
'201103775',
'201106882',
'201106885',
'201107601',
'201106466',
'201106929',
'201104209',
'201100881',
'201100880',
'201107448',
'201107940',
'201103770',
'201107942',
'201106929',
'201107414',
'201106909',
'201106931',
'201107944',
'201106931',
'201101021',
'201107020',
'201106892',
'201107381',
'201104540',
'201104481',
'201102439',
'201107382',
'201102550',
'201100893',
'201100895',
'201107092',
'201107097',
'201100745',
'201107826',
'201102449',
'201101918',
'201102888',
'201102257',
'201107814',
'201107377',
'201103910',
'201108418',
'201103911',
'201104519',
'201107379',
'201107527',
'201107513',
'201106911',
'201101919',
'201107815',
'201107519',
'201103072',
'201104893',
'201103917',
'201104520',
'201104205',
'201104049',
'201101339',
'201101345',
'201101336',
'201101340',
'201101328',
'201101332',
'201101330',
'201100692',
'201107354',
'201104027',
'201108034',
'201107716',
'201108022',
'201103618',
'201106655',
'201107817',
'201106654',
'201106861',
'201108029',
'201108243',
'201106940',
'201106908',
'201107476',
'201106942',
'201107819',
'201107474',
'201104198',
'201108353',
'201108244',
'201104623',
'201102252',
'201106698',
'201102253',
'201101233',
'201103730',
'201102890',
'201100792',
'201102931',
'201107471',
'201107535',
'201107467',
'201101681',
'201108196',
'201107603',
'201107599',
'201107600',
'201107468',
'201107479',
'201107472',
'201101475',
'201101476',
'201107478',
'201100792',
'201108303',
'201103727',
'201104432',
'201107472',
'201107373',
'201106804',
'201106805',
'201106587',
'201106941',
'201103693',
'201103695',
'201108354',
'201101293',
'201102797',
'201107576',
'201107163',
'201107574',
'201107575',
'201107190',
'201104659',
'201101936',
'201101934',
'201104658',
'201101927',
'201104656',
'201107184',
'201106403',
'201106405',
'201106421',
'201106404',
'201106429',
'201106424',
'201106427',
'201103971',
'201106409',
'201103981',
'201103989',
'201100607',
'201100604',
'201101339',
'201101345',
'201101336',
'201101340',
'201101328',
'201101332',
'201101330',
'201108334',
'201107605',
'201103447',
'201103445',
'201107515',
'201107689',
'201104754',
'201104456',
'201102390',
'201100691',
'201106649',
'201107773',
'201106313',
'201107032',
'201107482',
'201103210',
'201101290',
'201102661',
'201104206',
'201102993',
'201104079',
'201104076',
'201107481',
'201101219',
'201103188',
'201107742',
'201107741',
'201103914',
'201103747',
'201107739',
'201107740',
'201107748',
'201101699',
'201107745',
'201107746',
'201107747',
'201108462',
'201108456',
'201108455',
'201106751',
'201106991',
'201107561',
'201108706',
'201106464',
'201107813',
'201107816',
'201108475',
'201104399',
'201107319',
'201107318',
'201103504',
'201101210',
'201108296',
'201108422',
'201104549',
'201102534',
'201108668',
'201108767',
'201102314',
'201108712',
'201108720',
'201108458',
'201108626',
'201103526',
'201108421',
'201108587',
'201108294',
'201108719',
'201106979',
'201108659',
'201106750',
'201104319',
'201108469',
'201109077',
'201108374',
'201103751',
'201108373',
'201103751',
'201106767',
'201107326',
'201106923',
'201107389',
'201106985',
'201108153',
'201106974',
'201107012',
'201102306',
'201106972',
'201108155',
'201106987',
'201102314',
'201107194',
'201107195',
'201107827',
'201103805',
'201107824',
'201102310',
'201107487',
'201107339',
'201102438',
'201103754',
'201103746',
'201107691',
'201107389',
'201107175',
'201106989',
'201108154',
'201108152',
'201104899',
'201108668',
'201104573',
'201106981',
'201102573');";


$rsConsulta = pg_query(abreConexao(),$sqlConsulta);
 $CodigoThiago = $_GET['CodigoThiago'];
 $cont =0;
		 if($CodigoThiago ==''){
			While($linhaConsulta = pg_fetch_array($rsConsulta))
				 {
					$CodigoThiago = $linhaConsulta['diaria_id'];	
					echo $cont;
					?>
					<a href="<?php echo 'http://formiga/gestor/Home/Imprimir.php?CodigoThiago='.$CodigoThiago; ?>"><?echo 'http://formiga/gestor/Home/Imprimir.php?CodigoThiago='.$CodigoThiago;?></a>
				<?php
				$cont++;
					echo"<br />";
				}
		 }
		 else
		 {
			include "../SistemaDiarias/SolicitacaoComprovacaoImprimirPDF.php";		
		 }
    


?>