<%@ Page Language="VB" MasterPageFile="~/Site.master" CodeBehind="List.aspx.vb"
    Inherits="Manutencao.UsuarioRecurso" %>

<%@ Register Assembly="MessageBox" Namespace="MessageBox" TagPrefix="cc1" %>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="Server">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />
    <asp:ScriptManagerProxy runat="server" ID="ScriptManagerProxy1" />
        <h2>
            Associar Permissões</h2>
    <asp:UpdatePanel ID="UpdatePanel1" runat="server">
        <ContentTemplate>
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
                HeaderText="List of validation errors" />
            <p>
                <asp:Label ForeColor="Red" runat="server" ID="lblErro"></asp:Label>
            </p>
            <asp:DynamicValidator runat="server" ID="DetailsViewValidator" ControlToValidate="DetailsView1"
                Display="None" />
            <asp:DetailsView Visible="false" ID="DetailsView1" runat="server" DataSourceID="DetailsDataSource"
                CssClass="detailstable" FieldHeaderStyle-CssClass="bold">
                <Fields>
                   
                </Fields>
            </asp:DetailsView>
            <asp:LinqDataSource ID="DetailsDataSource" runat="server" EnableDelete="true">
                <WhereParameters>
                    <asp:DynamicQueryStringParameter Name="codusuariomanutencao"  />
                </WhereParameters>
            </asp:LinqDataSource>
        </ContentTemplate>
    </asp:UpdatePanel>
    <div id="associarRecurso">
        <!--<div style="clear: both">
        </div>
        <span class="dot"></span>-->
        <p>
            <asp:Label ID="lblUsuarioPermissao" Font-Bold="true" Font-Size="Large" Visible="true" runat="server"></asp:Label></p>
            <br />
        <table>
            <tr>
                <td>
                    <p>
                        <label>
                            Permissões Disponíveis</label></p>
                    <p>
                        <asp:ListBox SelectionMode="Multiple" ID="lstRecursos" runat="server" Width="300px"
                            Height="180px" CssClass="txt"></asp:ListBox>
                    </p>
                </td>
                <td style="width: 50px; text-align: center; vertical-align: middle;">
                    <asp:LinkButton ID="lnkBtnIncluirTodos" runat="server" Text=">>" /><br />
                    <asp:LinkButton ID="lnkBtnExcluirTodos" runat="server" Text="<<" /><br />
                </td>
                <td>
                    <p>
                        <label>
                            Permissões do Usuário</label></p>
                    <p>
                        <asp:ListBox SelectionMode="Multiple" ID="lstRecursosUsuario" runat="server" Width="300px"
                            Height="180px" CssClass="txt"></asp:ListBox>
                    </p>
                </td>
            </tr>
        </table>
        <br />
        <a href="../UsuarioManutencaos/List.aspx" class="botao_link">Listar Usuários</a>
        <asp:Label ID="lblCodUsuario" Visible="false" runat="server"></asp:Label>
    </div>
</asp:Content>
