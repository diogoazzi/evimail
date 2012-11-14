<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="Insert.aspx.vb" Inherits="Manutencao.Usuario" %>

<%@ Register Assembly="MessageBox" Namespace="MessageBox" TagPrefix="cc1" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="Server">
    <div id="ctCadastroUsuario">
        <div class="title">
            <h2><asp:Literal ID="ltrlTitulo" runat="server" Text="Cadastrar Novo Usuário"></asp:Literal></h2>
        </div>
        <!--<div style="clear: both">
        </div>
        <span class="dot"></span>-->
        <fieldset class="usuariomanut">
            
            <p>
                <asp:Label ForeColor="Red" runat="server" ID="Label1"></asp:Label>
            </p>
            <p>
                <asp:Label ForeColor="Red" runat="server" ID="lblErro"></asp:Label>
            </p>
            <p>
                <label>Nome: </label>
                <asp:TextBox ID="txtNomeEdit" runat="server" CssClass="txt" Style="width: 515px" MaxLength="250"></asp:TextBox>
                <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ControlToValidate="txtNomeEdit" CssClass="droplist" style="float:left; width:100%" ErrorMessage="O campo Nome é obrigatório" ValidationGroup="cadastro" Display="Dynamic"></asp:RequiredFieldValidator>
            </p>
            <p>
                <label>Email: </label>
                <asp:TextBox ID="txtEmailEdit" runat="server" CssClass="txt" Style="width: 515px" MaxLength="250"></asp:TextBox>
                
                    <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" ControlToValidate="txtEmailEdit" ErrorMessage="O campo email é obrigatório" CssClass="droplist" ValidationGroup="cadastro" Display="Dynamic"></asp:RequiredFieldValidator>
                    <asp:RegularExpressionValidator ID="RegularExpressionValidator1" runat="server" ControlToValidate="txtEmailEdit" ErrorMessage="O campo email está inválido" CssClass="droplist" ValidationExpression="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" ValidationGroup="cadastro" Display="Dynamic"></asp:RegularExpressionValidator>
                
            </p>
            <p>
                <label>Senha: </label>
                <asp:TextBox ID="txtSenhaEdit" runat="server" TextMode="Password" CssClass="txt" Style="width: 160px" MaxLength="12"></asp:TextBox>&nbsp;
                
                    <asp:RequiredFieldValidator ID="RequiredFieldValidator4" runat="server" ControlToValidate="txtSenhaEdit" ErrorMessage="O campo senha é obrigatório" ValidationGroup="cadastro" Display="Dynamic" CssClass="droplist"></asp:RequiredFieldValidator>
                
            </p>
            <p>
                <label>Confirmação de Senha: </label>
                <asp:TextBox ID="txtConfirmaSenhaEdit" runat="server" TextMode="Password" CssClass="txt" Style="width: 160px" MaxLength="12"></asp:TextBox>
                <asp:CompareValidator ID="CompareValidator1" runat="server" ControlToCompare="txtSenhaEdit" ControlToValidate="txtConfirmaSenhaEdit" ErrorMessage="Senha inválida! Confirme novamente a senha." ValidationGroup="cadastro" Display="Dynamic"></asp:CompareValidator>
                <asp:RequiredFieldValidator ID="RequiredFieldValidator5" runat="server" ControlToValidate="txtConfirmaSenhaEdit" ErrorMessage="Confirme a senha do usuário" ValidationGroup="cadastro" CssClass="droplist"></asp:RequiredFieldValidator>
            </p>
            <p>
                <label>Clube</label>
                <asp:DropDownList ID="ddlClube" runat="server" AppendDataBoundItems="true">
                    <asp:ListItem Text="Nenhum" Value=""></asp:ListItem>
                </asp:DropDownList>
            </p>
            <p>
                <label>Ativo</label>
                <asp:CheckBox ID="chkAtivo" runat="server" Checked="true" />
            </p>
            <asp:LinkButton ID="lnkEnviar" Text="Inserir" runat="server" ValidationGroup="cadastro" CssClass="botao_link" />
            <asp:HyperLink ID="lnkCancelar" runat="server" NavigateUrl="/UsuarioManutencaos/List.aspx" Text="Cancelar" CssClass="botao_link"></asp:HyperLink>
            <asp:Label ID="lblAcao" Visible="false" runat="server"></asp:Label>
        </fieldset>
    </div>
</asp:Content>
