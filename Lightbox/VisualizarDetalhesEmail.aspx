<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="VisualizarDetalhesEmail.aspx.vb"
    Inherits="WebSiteFrontEnd.VisualizarDetalhesEmail" %>

<%@ Register Src="../UserControls/wucDetalhesEmail.ascx" TagName="wucDetalhesEmail"
    TagPrefix="uc1" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<style type="text/css">
html,body{ overflow:hidden; }
.body {padding:0 !important; margin-left:10px;}

</style>
<body>
    <form id="form1" runat="server">
    <div id="content">
        <div class="body">
            <uc1:wucDetalhesEmail ID="ucDetalhesEmail" runat="server" />
        </div>
    </div>
    </form>
</body>
</html>
