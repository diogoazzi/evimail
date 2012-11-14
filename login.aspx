<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="login.aspx.vb" Inherits="Manutencao.login" %>

<%@ Register Assembly="MessageBox" Namespace="MessageBox" TagPrefix="cc1" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1" runat="server">
    <title>Login - Área restrita - Evimail</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <!--
	<script language="javaScript" type="text/javascript" src= src="./js/scripts.js"></script>
	-->

    <script src="Scripts/jquery-1.3.2.min.js" type="text/javascript"></script>

    <script src="Scripts/jquery.qtip-1.0.0-rc3.js" type="text/javascript"></script>

    <script type="text/javascript">
        function lembrarSenha() 
        {
            $('#lembrarSenha').qtip({
                content: {
                    title: {
                        text: 'Lembrar senha',
                        button: 'X'
                    },
                    url: 'lembra-senha.aspx'
                },
                position: {
                    corner: {
                        target: 'topRight',
                        tooltip: 'bottomLeft'
                    },
                    adjust: {
                        screen: true
                    } 
                },
                style: {
                    name: 'light',
                    padding: '7px 13px',
                    width: {
                        max: 310,
                        min: 310
                    },
                    tip: true,
                    border: {
                        width: 3,
                        radius: 5
                    },
                    classes: {
                        title: 'Tooltip_Titulo',
                        content: 'Tooltip_Conteudo'
                    }
                },
                show: {
                    when: 'click', 
                    solo: true 
                },
                hide: false,
                classes: {
                title: 'tituloTooltip',
                    button: 'qtip-button'
                }
            });
        };
        function DefaultButtonKeyPress(evt, thisElementName) {
            if (evt.which || evt.keyCode) {
                if ((evt.which == 13) || (evt.keyCode == 13)) {
                    location = document.getElementById(thisElementName).href;
                    return false;
                }
            }
            else {
                return true;
            }
        }
    </script>

</head>
<body>
    <form id="form1" runat="server">
    <div id="login_wraper">
        <div id="login_main">
            <div id="login_form">
                <h2>
                    Login</h2>
                <div id="loginput_blank">
                    <asp:TextBox ID="txtUsuario" Text="Digite seu email" runat="server" MaxLength="255" Style="margin-left: 15px;"
                        onfocus="if(this.value=='Digite seu email')this.value=''" onblur="if(this.value=='')this.value='Digite seu email'"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvUsuario" runat="server" ControlToValidate="txtUsuario"
                        ErrorMessage="Informe seu email de acesso" ValidationGroup="login" Display="Dynamic"
                        InitialValue="Digite seu email" CssClass="validacao" SetFocusOnError="true"></asp:RequiredFieldValidator>



                    <asp:TextBox runat="server" TextMode="Password" MaxLength="12" ID="txtSenha" Style="margin-left: 15px;"
                        onfocus="if(this.value=='xxxxxx')this.value=''" onblur="if(this.value=='')this.value='xxxxxx'"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvSenha" runat="server" ControlToValidate="txtSenha"
                        ErrorMessage="Informe sua senha de acesso" CssClass="validacao" Display="Dynamic"
                        ValidationGroup="login" InitialValue="xxxxxx" SetFocusOnError="true"></asp:RequiredFieldValidator>

                </div>
                <asp:LinkButton ID="btnLogar" runat="server" CssClass="submit" OnClick="btnLogar_Click"
                    ValidationGroup="login" />
                <p>
                    <a id="lembrarSenha" href="#" title="Esqueci minha senha" onclick="lembrarSenha();">Lembrar senha</a></p>
            </div>
            <div id="login_right">
                <h2>
                    Administração de Conteúdo
                </h2>
                <p>
                    Bem-vindo a administração de contéudo do web site Evimail. Para ter acesso a área restrita é preciso digitar o login e senha nos campos ao lado.
                </p>
            </div>
        </div>
    </div>
    <cc1:MessageBox ID="MessageBox1" runat="server" />
    </form>
</body>
</html>