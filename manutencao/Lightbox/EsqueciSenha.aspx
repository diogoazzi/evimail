<%@ Page Language="vb" AutoEventWireup="false"  CodeBehind="EsqueciSenha.aspx.vb" Inherits="WebSiteFrontEnd.EsqueciSenha" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />    
    <style type="text/css">
    html,body{ overflow:hidden; }
    </style>
</head>
<body>
    <form id="form1" runat="server">
    <div class="esqSenha">
        <p>
            <asp:Label ID="lblEmail" runat="server" AssociatedControlID="txtEmail" />
            <asp:TextBox ID="txtEmail" runat="server" CssClass="txtBox" MaxLength="50" />
            <br /><br /><br />
            <asp:LinkButton ID="btnEnviar" runat="server" CssClass="button" />
        </p> 
    </div>
    </form>
</body>
</html>
