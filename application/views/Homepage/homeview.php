<div class="container-fluid my-image">
    <!-- your image here -->
    <img src="https://darkjade68.files.wordpress.com/2015/01/stocks.jpeg" alt="" class="img-responsive center-block" />
</div>
<div class="row">

    <h3>{gamenum}</h3>
    <h3>{gamestatus}</h3>
    <div class="col-md-8 ">
        <div class="page-header">
            <h1>
                Recent Stocks
            </h1>
        </div>
        <div>
            {stocktable}
        </div>

        <div class="col-md-2">
            <div class="page-header">
                <h1>
                    Player
                </h1>
            </div>
            {playertable}
        </div>

        <div class="col-md-12">
            <h1>Recent Transactions</h1>
            <div class="page-header"></div>
            {transactiontable}
        </div>
    </div>
</div>




