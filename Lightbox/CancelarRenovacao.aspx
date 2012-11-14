<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="CancelarRenovacao.aspx.vb" Inherits="WebSiteFrontEnd.CancelarRenovacao" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <!--[if IE]> 
		<link href="../css/ie.css" rel="stylesheet" type="text/css" />		
	<![endif]-->
</head>
<style type="text/css">
html,body{ overflow:hidden; }
</style>
<body>
    <form id="form1" runat="server">
    <div class="msgCancelaRenova">

        <asp:Label ID="lblCancelaRenovacao" runat="server" Text="<h3>Cancelar Renovação</h3><p>Tem certeza que deseja cancelar a renovação do serviço <strong>Plano 10 e-mails/mês?</strong></p>"></asp:Label>
        <asp:ImageButton ID="btnSim" runat="server" ImageUrl="~/img/btnSim.png" AlternateText="Sim" />

    </div>
    </form>
</body>
</html>
