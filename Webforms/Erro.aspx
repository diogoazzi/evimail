<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="Erro.aspx.vb" Inherits="WebSiteFrontEnd.Erro" MasterPageFile="~/MasterPage/Master.Master"%>


<asp:Content ID="ContentHead" ContentPlaceHolderID="ContentPlaceHolder_Head" runat="server">
    <script type="text/javascript">
        var strReferrer = document.referrer.toLowerCase();
        var blnSearchReferral = false;
        var blnInsiteReferral = false;
        var str = "";
        var strSite = "";
        if (strReferrer.length==0)
          {
              str+='We think you will find one of the following » links useful:<\/p>';
              str+='<a href="\/home.php"><img src="/images/ » home.gif" alt="Home Page" width="100" height="30" » \/> <\/a>';
              str+='<a href="\/site-map.php"><img src="/images/ »site-map.gif" alt="Site Map" width="100" height= »"30" \/><\/a>';
              str+='<hr \/>';
              str+='<p><strong>You may not be able to find the »page you were after because of:<\/strong><\/p>';
              str+='<ol type="a">';
              str+=' <li>An <strong>out-of-date bookmark\/favorite »<\/strong><\/li>';
              str+=' <li>A search engine that has an <strong>out- »of-date listing for us</strong><\/li>';
              str+=' <li>A <strong>mis-typed address</strong><\/li>';
              str+='<\/ol>';
              document.write(str);
          }
          if (!blnSearchReferral)
          {
              strSite = strReferrer;
              strSite = strSite.split("/");
              strSite = strSite[2];
              document.write("<p>You were incorrectly referred to » this page by: <strong><a href='" + strReferrer + 
              " »'target='_blank'>" + strSite + "</a></strong> »<br />We suggest you try one of the links below: »</p>");
          }
          blnInsiteReferral =((strReferrer.indexOf("http:// »www.mysite.co.uk")>=0)||
            (strReferrer.indexOf("http://www.myothersite.com") >=0))
          if (blnInsiteReferral)
            {
                document.write("<p>This one’s down to us! Please »accept our apologies for this — we’ll see to it »" +
                "that the developer responsible for this broken » link is given 20 lashes (but only after he or »" +
                "she has fixed this problem).<\/p>");
            }
          /*if (strReferrer.length!=0)
          {
              if ((strReferrer.indexOf(".looksmart.co")>0)||
              (strReferrer.indexOf(".ifind.freeserve")>0)||
              (strReferrer.indexOf(".ask.co")>0)||
              (strReferrer.indexOf("google.co")>0)||
              (strReferrer.indexOf("altavista.co")>0)||
              (strReferrer.indexOf("msn.co")>0)||
              (strReferrer.indexOf("yahoo.co")>0))
              {
              blnSearchReferral=true;
              //get site domain — split at the first forward-slash
              var arrSite=strReferrer.split("/");
              // now find search parameters
              var arrParams=strReferrer.split("?"); 
              var strSearchTerms = arrParams[1];
              arrParams=strSearchTerms.split("&");
  
              strSite=arrSite[2];
              var sQryStr="";
  
              //define what search terms are in use by the »different engines
              var arrQueryStrings = new Array();
              arrQueryStrings[0]="q=";  //google, altavista, msn
              arrQueryStrings[1]="p=";  //yahoo
              arrQueryStrings[2]="ask=";  //ask jeeves
              arrQueryStrings[3]="key=";  //looksmart
  
              for (i=0;i<arrParams.length;i++)
              //loop through all the parameters in the referring »page’s URL
                {
                for (q=0;q<arrQueryStrings.length;q++)
                {
                sQryStr = arrQueryStrings[q];
                if (arrParams[i].indexOf(sQryStr)==0)
                  {//we’ve found a search term!
                  strSearchTerms = arrParams[i];
                  strSearchTerms = strSearchTerms.split(sQryStr);
                  strSearchTerms = strSearchTerms[1];
                  strSearchTerms = strSearchTerms.replace("+", " ");
                  }
                }
            }
          //Tell the visitor what site is at fault, what the 
          //search terms were
          document.write ("<p>You did a search on <strong> »<a href='" + 
          strReferrer + 
          "' target='_blank'>»" + strSite + "<\/a> <\/strong> for \"<strong>»" + strSearchTerms + 
          "<\/strong>\". However, »their index appears to be out of date.<\/p> »<h2>All is not lost!<\/h2>" +
          "<p>We think that the »following page(s)on our site will be able to help »you:<\/p>");*/
    </script>
</asp:Content>
