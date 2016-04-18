<script>
    function player_redirect() {
        var url =document.getElementById("playerlist").value;
        location.href = '/play/portfolio/' + url;
    }
    
    setTimeout(function(){
   window.location.reload(1);
}, 10000);
</script>
<div class="row">
  <div class="col-md-2">Players: </div>
  <div class="col-md-4">
{select_players}
  </div>
</div>
<div class="row">
    <div class="col-md-6">
        <img width ="100" height = "100" src ={image} />
    </div>
    <div class="col-md-6">

        <dl>
            <dt>Name</dt>
            <dd>{name}</dd>
            
            <dt>Cash</dt>
            <dd>{cash}</dd>
            
            <dt>Equity</dt>
            <dd>{equity}</dd>
        </dl>
        
    </div>
</div>

<h2>Holdings</h2>
<div class="row">
    {holding}
</div>

<h2>Stocks</h2>
<div class="row">
    {stocks}
</div>