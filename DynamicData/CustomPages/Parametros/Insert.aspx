﻿<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="Insert.aspx.vb" Inherits="Manutencao.ParametroInsert" %>
<%@ Register Assembly="MessageBox" Namespace="MessageBox" TagPrefix="cc1" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="Server">
    <div id="ctCadastroUsuario">
        <div class="title">
            <h2><asp:Literal ID="ltrlTitulo" runat="server" Text="Cadastrar Novo Usuário"></asp:Literal></h2>
        </div>
        <fieldset>
            <p>
                <asp:Label ForeColor="Red" runat="server" ID="Label1"></asp:Label>
            </p>
            <p>
                <asp:Label ForeColor="Red" runat="server" ID="lblErro"></asp:Label>
            </p>
            <p>
                <label>Parâmetro: </label>
                <asp:Literal runat="server" ID="LiteralNomeParametro"></asp:Literal><br /><br />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ControlToValidate="txtNomeEdit" CssClass="droplist" ErrorMessage="O campo Nome é obrigatório" ValidationGroup="cadastro" Display="Dynamic"></asp:RequiredFieldValidator>
            </p>
            <p>
                <label>Valor: </label>
                <asp:TextBox ID="txtValorParametro" runat="server" CssClass="txt" Style="width: 100px" MaxLength="10"></asp:TextBox><br /><br />
                <asp:RequiredFieldValidator ID="rqfValorParametro" runat="server" ControlToValidate="txtValorParametro" ErrorMessage="É preciso especificar um valor para o parâmetro!" CssClass="droplist" ValidationGroup="cadastro" Display="Dynamic"></asp:RequiredFieldValidator>
            </p>
            <asp:LinkButton ID="lnkEnviar" Text="Inserir" runat="server" ValidationGroup="cadastro" CssClass="botao_link" />
            <asp:HyperLink ID="lnkCancelar" runat="server" NavigateUrl="/Parametros/List.aspx" Text="Cancelar" CssClass="botao_link"></asp:HyperLink>
            <asp:Label ID="lblAcao" Visible="false" runat="server"></asp:Label>
        </fieldset>
    </div>
</asp:Content>