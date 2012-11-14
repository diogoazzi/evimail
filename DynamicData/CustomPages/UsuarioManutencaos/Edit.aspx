<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="Edit.aspx.vb" Inherits="Manutencao.UsuarioEdit" %>
<%@ Register Assembly="MessageBox" Namespace="MessageBox" TagPrefix="cc1" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="Server">
    <div id="ctCadastroUsuario">
        <div class="title">
            <h2><asp:Literal ID="ltrlTitulo" runat="server" Text="Cadastrar Novo Usuário"></asp:Literal></h2>
        </div>
        <fieldset>
            <p>
                <asp:Label ForeColor="Red" runat="server" ID="Label1" CssClass="droplist"></asp:Label>
            </p>
            <p>
                <asp:Label ForeColor="Red" runat="server" ID="lblErro" CssClass="droplist"></asp:Label>
            </p>
            <p style="margin-bottom:20px">
                <label>Nome: </label>
                <asp:TextBox ID="txtNomeEdit" runat="server" CssClass="txt" Style="width: 515px" MaxLength="250"></asp:TextBox><br />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ControlToValidate="txtNomeEdit" CssClass="droplist alinhamentoAviso" ErrorMessage="O campo Nome é obrigatório" ValidationGroup="cadastro" Display="Dynamic"></asp:RequiredFieldValidator>
            </p>
             <p style="margin-bottom:20px">
                <label>Email: </label>
                <asp:TextBox ID="txtEmailEdit" runat="server" CssClass="txt" Style="width: 515px" MaxLength="250"></asp:TextBox><br />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" ControlToValidate="txtEmailEdit" ErrorMessage="O campo email é obrigatório" CssClass="droplist alinhamentoAviso" ValidationGroup="cadastro" Display="Dynamic"></asp:RequiredFieldValidator>
                <asp:RegularExpressionValidator ID="RegularExpressionValidator1" runat="server" ControlToValidate="txtEmailEdit" ErrorMessage="O campo email está inválido" CssClass="droplist" ValidationExpression="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" ValidationGroup="cadastro" Display="Dynamic"></asp:RegularExpressionValidator>
            </p>
             <p style="margin-bottom:20px">
                <label>Ativo</label>
                <asp:CheckBox ID="chkAtivo" runat="server" Checked="true" />
            </p>
            <asp:LinkButton ID="lnkEnviar" Text="Inserir" runat="server" ValidationGroup="cadastro" CssClass="botao_link" />
             <asp:HyperLink ID="lnkCancelar" runat="server" NavigateUrl="/UsuarioManutencaos/List.aspx" Text="Cancelar" CssClass="botao_link"></asp:HyperLink>
            <asp:Label ID="lblAcao" Visible="false" runat="server"></asp:Label>
        </fieldset>
    </div>  
</asp:Content> 