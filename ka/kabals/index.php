<? require_once '../Layout.inc'; ?>
<?	$kabals = $roster->GetKabals();
	foreach ($kabals as $kabal) {
		$chief = $kabal->GetChief();
		$cra = $kabal->GetCRA();
 ?>
 			<div>
				<h2><?=$kabal->GetName()?> Kabal</h2>
			<table cellpadding="0" cellspacing="0" class="invisible">
				<tr>
					<td colspan="2">Chief: <b><?=$chief->GetName()?></b> - <b><a href="mailto:<?=$chief->GetEMail()?>"><?=$chief->GetEMail()?></a></b></td> <td colSpan="4" rowspan="6" width="82" ><img src="<?=$kabal->getlogourl()?>"></td>
				</tr>
				<tr>
					<td colspan="2">CRA: <b><?=$cra->GetName()?></b> - <b><a href="mailto:<?=$cra->GetEMail()?>"><?=$cra->GetEMail()?></a></b></td>
				</tr>
				<tr>
					<td colspan="2">Kabal Slogan: <b><?=$kabal->GetSlogan()?></b></td>
				</tr>
				<tr>
					<td colspan="2">Kabal Homepage: <b><a href="<?=$kabal->GetURL()?>"><?=$kabal->GetURL()?></a></b></td>
				</tr>
				<tr>
					<td colspan="2">Kabal Email: <b><a href="mailto:<?=$kabal->GetMailingList()?>"><?=$kabal->GetMailingList()?></a></b></td>
				</tr>
				<tr>
					<td colspan="2">Total Members: <b><?=$kabal->GetMemberCount()?></b></td>
				</tr>
			</table>
			</div>
<? } ?>
<? ConstructLayout(); ?>
