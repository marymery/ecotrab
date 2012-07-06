<%-- 
    Document   : index
    Created on : 01-jul-2012, 17:21:23
    Author     : PC
--%>

<%@page import="dataTier.Entities.EpaTasasOcup"%>
<%@page import="java.util.List"%>
<%@page import="BusinessLayer.EPATasasOcupRepository"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="JS/jquery.min.js"></script>
         <script src='JS/jqueryAjaxExample.js'></script>
        <title>Index</title>
    </head>
    <body>
        <select>
            <option onchange="$('#tbl2').show(); $('#tbl1').show();">All </option>
            <option onchange="$('#tbl2').hide(); $('#tbl1').show();">1997</option>    
            <option onselect="$('#tbl1').hide(); $('#tbl2').show();" onchange="$('#tbl1').hide(); $('#tbl2').show();">1996</option>
        </select>
        <h1>EPATasasOcup</h1>

        <%
            EPATasasOcupRepository rep = new EPATasasOcupRepository();
            List<EpaTasasOcup> list = rep.getEpaTasasOcupacion();
            EpaTasasOcup test = list.get(0);
        %>
        
        <table id="tbl1" border="1" cellspacing="1" style='width:50%; margin-left: 25%'>
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                
                    <th>
                        EdadGr
                    </th>
                
                    <th>
                        EstudGr
                    </th>
                
                    <th>
                        ProvResid
                    </th>
                
                    <th>
                        Sexo
                    </th>
                
                    <th>
                        Tocup
                    </th>
                
                    <th>
                        Year
                    </th>
                </tr>
            </thead>
            
            <tbody>
                <% for(int i = 0; i< list.size(); i++){ 
                    test = list.get(i);
                    if(test.getYear() == 1997)
                    {
                %>
                <tr>
                    <td>
                                <%= test.getId() %>
                    </td>   
                    <td>
                                <%= test.getEdadGr() %>
                    </td>
                
                    <td>
                                <%= test.getEstudGr() %>
                    </td>
                    <td>
                                <%= test.getProvResid() %>
                    </td>
                    <td>
                                <%= test.getSexo() %>
                    </td>
                    <td>
                                <%= test.getTocup() %>
                    </td>
                    <td>
                                <%= test.getYear() %>
                    </td>
                </tr>
                <% } } %>
            </tbody>
        </table>
            
        <table id="tbl2" border="1" cellspacing="1" style='width:50%; margin-left: 25%'>
            <thead>
                <tr>
                    <th>
                        ID
                    </th>
                
                    <th>
                        EdadGr
                    </th>
                
                    <th>
                        EstudGr
                    </th>
                
                    <th>
                        ProvResid
                    </th>
                
                    <th>
                        Sexo
                    </th>
                
                    <th>
                        Tocup
                    </th>
                
                    <th>
                        Year
                    </th>
                </tr>
            </thead>
            
            <tbody>
                <% for(int i = 0; i< list.size(); i++){ 
                    test = list.get(i);
                    if(test.getYear() == 1996)
                    {
                %>
                <tr>
                    <td>
                                <%= test.getId() %>
                    </td>   
                    <td>
                                <%= test.getEdadGr() %>
                    </td>
                
                    <td>
                                <%= test.getEstudGr() %>
                    </td>
                    <td>
                                <%= test.getProvResid() %>
                    </td>
                    <td>
                                <%= test.getSexo() %>
                    </td>
                    <td>
                                <%= test.getTocup() %>
                    </td>
                    <td>
                                <%= test.getYear() %>
                    </td>
                </tr>
                <% }} %>
            </tbody>
        </table>
        
    </body>
</html>
