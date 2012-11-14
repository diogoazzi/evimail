<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="Laudo.aspx.vb" Inherits="WebSiteFrontEnd.Laudo" %>
<%@ Register Src="../UserControls/wucDetalhesEmail.ascx" TagName="wucDetalhesEmail" TagPrefix="uc1" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
	<title>Laudo</title>
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../css/temp.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<form id="form1" runat="server">
	<div id="laudoPDF" class="body">
		<h3>Transforme seu e-mail</h3>
		<h4>Laudo</h4>
		<p class="assunto">
			<asp:Label ID="lblTituloAssunto" runat="server" Text="Assunto do email" />
			<asp:Literal ID="ltrTextoAssunto" runat="server" Text="Lorem ipsum dolor sit amet, consectetur adipiscing elit. " />
		</p>
		<asp:ListView ID="lsvDestinatarios" runat="server">
			<LayoutTemplate>
				<table class="tableStyle">
					<tr>
						<th rowspan="2">
							<asp:Literal ID="ltrEmailHeader" runat="server"  />
						</th>
						<th colspan="3">
							<asp:Literal ID="ltrRecebimentoHeader" runat="server"  />
						</th>
						<th rowspan="2">
							<asp:Literal ID="ltrDataConfirmacaoHeader" runat="server"/>
						</th>
					</tr>
					<tr class="subTitle">
						<th>
							<asp:Literal ID="ltrStatusHeader" runat="server"  />
						</th>
						<th>
							<asp:Literal ID="ltrLeituraConteudoHeader" runat="server" />
						</th>
						<th>
							<asp:Literal ID="ltrLeituraAnexoHeader" runat="server" />
						</th>
					</tr>
					<tr>
						<td runat="server" id="itemPlaceholder">
						</td>
					</tr>
				</table>
			</LayoutTemplate>
			<ItemTemplate>
				<tr>
					<td>
						<asp:Literal ID="ltrEmailValue" runat="server" />
					</td>
					<td>
						<asp:Literal ID="ltrStatusValue" runat="server" />
					</td>
					<td>
						<asp:Label ID="lblLeituraConteudoValue" runat="server" />
					</td>
					<td>
						<asp:Label ID="lblLeituraAnexoValue" runat="server" />
					</td>
					<td>
						<asp:Literal ID="ltrDataConfirmacaoValue" runat="server" />
					</td>
				</tr>
			</ItemTemplate>
		</asp:ListView>
		<p class="legendDetalhe">
			<span>
				<asp:Literal ID="ltrPendente" runat="server" Text="confirmação pendente" />
			</span><span>
				<asp:Literal ID="ltrConfirmado" runat="server" Text="confirmado" />
			</span>
		</p>
	<uc1:wucDetalhesEmail ExibeAnexo="false" ID="ucDetalhesEmail" runat="server" />
	</div>
	</form>
</body>
</html>