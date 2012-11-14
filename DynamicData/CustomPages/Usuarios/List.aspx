<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="List.aspx.vb" Inherits="Manutencao.List2" %>

<%@ Register Src="~/DynamicData/Content/GridViewPager.ascx" TagName="GridViewPager"
  TagPrefix="asp" %>
<%@ Register Src="~/DynamicData/Content/FilterUserControl.ascx" TagName="DynamicFilter"
  TagPrefix="asp" %>
<%@ Register Assembly="Catalyst.Web.DynamicData" Namespace="Catalyst.Web.DynamicData"
  TagPrefix="asp" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="Server">
  <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />
  <h2>
    <%= new Manutencao.util().FormatarNome(table.DisplayName)%></h2>
  <asp:ScriptManagerProxy runat="server" ID="ScriptManagerProxy1" />
  <asp:UpdatePanel ID="UpdatePanel1" runat="server">
    <ContentTemplate>
      <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
        HeaderText="List of validation errors" />
      <asp:DynamicValidator runat="server" ID="GridViewValidator" ControlToValidate="GridView1"
        Display="None" />
      <asp:DynamicFilterRepeater ID="DynamicFilterRepeater1" runat="server" DataSourceID="GridDataSource">
        <HeaderTemplate>
          <div class="div_Filtros">
            <h3>
              Filtro</h3>
            <fieldset>
        </HeaderTemplate>
        <ItemTemplate>
          <p>
            <asp:Label ID="Label1" runat="server" Text='<%# Eval("DisplayName") %>' />
            <asp:DynamicFilterControl ID="DynamicFilter" runat="server" CssClass="textbox" />
          </p>
        </ItemTemplate>
        <FooterTemplate>
          </fieldset>
          <div class="botoes">
            <asp:LinkButton ID="SearchButton" runat="server" CommandName="Search" Text="Buscar"
              CssClass="botao_link" />
            <asp:LinkButton ID="ClearButton" runat="server" CommandName="Clear" Text="Limpar Filtro"
              CssClass="botao_link" />
          </div>
          </div>
        </FooterTemplate>
      </asp:DynamicFilterRepeater>
      <asp:GridView ID="GridView1" runat="server" DataSourceID="GridDataSource" AutoGenerateColumns="false"
        AllowPaging="True" AllowSorting="True" CssClass="gridview">
        <Columns>
          <asp:TemplateField>
            <ItemTemplate>
            <div style="width:50px">
              <asp:HyperLink ID="EditHyperLink" runat="server" CssClass="btn_edit" NavigateUrl='<%# table.GetActionPath(PageAction.Edit, GetDataItem()) %>'
                Text="Editar" />&nbsp;<asp:LinkButton ID="DeleteLinkButton" runat="server" CommandName="Delete"
                  CausesValidation="false" Text="Excluir" CssClass="btn_delete" OnClientClick='return confirm("Deseja realmente excluir este item?");' />
            </div>
            </ItemTemplate>
          </asp:TemplateField>
          <asp:BoundField HeaderText="Nome" DataField="NomeCompleto" />
          <asp:BoundField HeaderText="Login" DataField="Login" />
          <%--<asp:BoundField HeaderText="Ativo" DataField="indAtivo" />--%>
          <asp:TemplateField HeaderText="Ativo">
            <ItemTemplate>
              <asp:CheckBox ID="chkAtivo" runat="server" Checked='<%# Eval("indAtivo") %>' Enabled="false" /></ItemTemplate>
          </asp:TemplateField>
          <asp:BoundField HeaderText="Data Inclusão" DataField="DataInclusao" DataFormatString="{0:dd/MM/yyyy HH:mm:ss}" />
          <asp:BoundField HeaderText="Data Alteração" DataField="DataAlteracao" DataFormatString="{0:dd/MM/yyyy HH:mm:ss}" />
          <%--<asp:BoundField HeaderText="Endereços" DataField="EnderecosUsuarios" />--%>
          <%--<asp:HyperLinkField HeaderText="Endereços" NavigateUrl='/EnderecosUsuarios/List.aspx?CodUsuario=<%# Eval("CodUsuario") %>' Text="Visualizar" />--%>
          <asp:TemplateField HeaderText="Endereços">
            <ItemTemplate>
              <a href='/EnderecosUsuarios/List.aspx?CodUsuario=<%# Eval("CodUsuario") %>'>Visualizar</a></ItemTemplate>
          </asp:TemplateField>
          <%--<asp:BoundField HeaderText="Telefones" DataField="TelefonesUsuarios" />--%>
          <asp:TemplateField HeaderText="Telefones">
            <ItemTemplate>
              <a href='/TelefonesUsuarios/List.aspx?CodUsuario=<%# Eval("CodUsuario") %>'>Visualizar</a></ItemTemplate>
          </asp:TemplateField>
          <%--<asp:BoundField HeaderText="Emails" DataField="UsuarioEmails" />--%>
          <asp:TemplateField HeaderText="Endereços de Emails">
            <ItemTemplate>
              <a href='/UsuarioEmails/List.aspx?CodUsuario=<%# Eval("CodUsuario") %>'>Visualizar</a></ItemTemplate>
          </asp:TemplateField>
          <%--<asp:BoundField HeaderText="Tipo" DataField="TiposUsuario" />--%>
          <asp:TemplateField HeaderText="Tipo">
            <ItemTemplate>
              <asp:Literal ID="ltrTipoUsuario" runat="server" Text='<%# Eval("TiposUsuario.NomeTipoUsuario") %>' /></ItemTemplate>
          </asp:TemplateField>
          <asp:TemplateField HeaderText="Emails Enviados">
            <ItemTemplate>
              <a href='/Emails/List.aspx?CodUsuario=<%# Eval("CodUsuario") %>'>Visualizar</a></ItemTemplate>
          </asp:TemplateField>
          <%--<asp:TemplateField HeaderText="Clube"> 
                        <ItemTemplate><asp:Literal ID="ltlClube" runat="server"></asp:Literal></ItemTemplate>
                    </asp:TemplateField>--%>
        </Columns>
        <PagerStyle CssClass="footer" />
        <PagerTemplate>
          <asp:GridViewPager runat="server" />
        </PagerTemplate>
        <EmptyDataTemplate>
          Nenhuma informação encontrada
        </EmptyDataTemplate>
      </asp:GridView>
      <asp:DynamicLinqDataSource ID="GridDataSource" runat="server" EnableDelete="True">
      </asp:DynamicLinqDataSource>
      <br />
      <div class="bottomhyperlink">
        <asp:HyperLink ID="InsertHyperLink" runat="server"><img runat="server" src="~/DynamicData/Content/Images/plus.gif" alt="Inserir novo item" />Inserir novo item</asp:HyperLink>
      </div>
    </ContentTemplate>
  </asp:UpdatePanel>
</asp:Content>
