<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="ListOLD.aspx.vb" Inherits="Manutencao.ListUsuarios" %>

<%@ Register src="~/DynamicData/Content/GridViewPager.ascx" tagname="GridViewPager" tagprefix="asp" %>
<%@ Register src="~/DynamicData/Content/FilterUserControl.ascx" tagname="DynamicFilter" tagprefix="asp" %>

<%@ Register assembly="Catalyst.Web.DynamicData" namespace="Catalyst.Web.DynamicData" tagprefix="asp" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" Runat="Server">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />

    <h2><%= new Manutencao.util().FormatarNome(table.DisplayName)%></h2>

    <asp:ScriptManagerProxy runat="server" ID="ScriptManagerProxy1" />

    <asp:UpdatePanel ID="UpdatePanel1" runat="server">
        <ContentTemplate>
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
                HeaderText="List of validation errors" />
            <asp:DynamicValidator runat="server" ID="GridViewValidator" ControlToValidate="GridView1" Display="None" />

            <asp:DynamicFilterRepeater ID="DynamicFilterRepeater1" runat="server" 
                DataSourceID="GridDataSource">
        <HeaderTemplate>
            <div>
                Filtro</div>
        </HeaderTemplate>
        <ItemTemplate>
            <div class="field">
                <asp:Label ID="Label1" runat="server" Text='<%# Eval("DisplayName") %>' />
                <asp:DynamicFilterControl ID="DynamicFilter" runat="server" />
            </div>
        </ItemTemplate>
        <FooterTemplate>
            <div>
                <asp:LinkButton ID="SearchButton" runat="server" CommandName="Search" 
                    Text="Buscar" />
                <asp:LinkButton ID="ClearButton" runat="server" CommandName="Clear" 
                    Text="Limpar Filtro" />
            </div>
        </FooterTemplate>
    </asp:DynamicFilterRepeater>

            <asp:GridView ID="GridView1" runat="server" AutoGenerateColumns="false" DataSourceID="GridDataSource"
                AllowPaging="True" DataKeyNames="CodUsuario" AllowSorting="True" CssClass="gridview">
                <Columns>
                    <asp:TemplateField>
                        <ItemTemplate>
                            <asp:HyperLink Visible="false" ID="EditHyperLink" runat="server"
                                NavigateUrl='<%# table.GetActionPath(PageAction.Edit, GetDataItem()) %>'
                            Text="Editar" />&nbsp;<asp:LinkButton ID="DeleteLinkButton" Visible="false" runat="server" CommandName="Delete"
                                CausesValidation="false" Text="Excluir"
                                OnClientClick='return confirm("Deseja realmente excluir este item?");'
                            />
                            <asp:HyperLink Visible="true" ID="DetailsHyperLink" runat="server"
                                NavigateUrl='<%# table.GetActionPath(PageAction.Details, GetDataItem()) %>'
                            Text="Detalhes" />
                        </ItemTemplate>
                    </asp:TemplateField>
                    <asp:BoundField HeaderText="Nome" DataField="Nome" />
                    <asp:BoundField HeaderText="Email" DataField="Email" />
                    <asp:BoundField HeaderText="CPF" DataField="CPF" />
                    <asp:BoundField HeaderText="Data do Cadastro" DataField="DataInclusao"  DataFormatString="{0:dd/MM/yyyy HH:mm:ss}" />
                    <asp:TemplateField HeaderText="Clube"> 
                        <ItemTemplate><asp:Literal ID="ltlClube" runat="server"></asp:Literal></ItemTemplate>
                    </asp:TemplateField>
                </Columns>

                <PagerStyle CssClass="footer"/>        
                <PagerTemplate>
                    <asp:GridViewPager runat="server" />
                </PagerTemplate>
                <EmptyDataTemplate>
                    Nenhuma informação encontrada
                </EmptyDataTemplate>
            </asp:GridView>

            <asp:DynamicLinqDataSource ID="GridDataSource" runat="server" 
                EnableDelete="True">
            </asp:DynamicLinqDataSource>

            <br />

            <div class="bottomhyperlink">
                <asp:HyperLink Visible="false" ID="InsertHyperLink" runat="server"><img runat="server" src="~/DynamicData/Content/Images/plus.gif" alt="Inserir novo item" />Inserir novo item</asp:HyperLink>
            </div>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
