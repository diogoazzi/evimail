<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="Alerta.aspx.vb" Inherits="WebSiteFrontEnd.Alerta" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" >
        function fechaJanela() {
            this.close();
        }

    </script>
</head>
<body style="overflow:hidden">
    <form id="form1" runat="server">
    <div class="msgAlert">
        <p><asp:Label ID="lblMensagem" runat="server" /> <asp:LinkButton ID="lnkOk" CssClass="button" runat="server" Text="<span>OK</span>" /><!--OnClick="this.close();"--></p>
		
    </div>
    </form>
</body>
</html>
