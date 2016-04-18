<!--On click handler for the drop down menu, redirects the page to the corresponding stock-->
<script>
    function stock_onclick() {
        var url =document.getElementById("stocklist").value;
        location.href = '/stock/picked_stocks/' + url;
    }
    
</script>
<!--The drop down menu-->

{pageselect}

<h2>Stock Info</h2>
{stocktable}

<h2>Movements</h2>
<br />
<br />

{movementtable}
 
<h2>Transactions</h2>
<br />
<br />

{transtable}


<!--The stock movements table-->


