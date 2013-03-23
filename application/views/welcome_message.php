<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Cumulizer - a Make.OpenData.ch project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Christian Studer, Martin Vögeli, Oleg Lavrovsky">

    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./js/nvd3/nv.d3.css" rel="stylesheet">
    <link href="./css/app.css" rel="stylesheet">
    <link href="./css/bootstrap-responsive.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="./js/html5shiv.js"></script>
    <![endif]-->

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="./ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="./ico/favicon.png">
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="http://make.opendata.ch/wiki/project:cumulizer">About</a></li>
          <li><a href="http://make.opendata.ch/forum">Contact</a></li>
        </ul>
        <h3 class="muted">Cumulizer</h3>
      </div>

      <hr>

      <div class="jumbotron">
        <h1>Liberate your shopping!</h1>
        <p class="lead">This is a <a href="http://make.opendata.ch/wiki/event:2013-03" target="_blank">Make OpenData.ch</a> project aiming to analyze personal data on purchases. We have started by aggregating our own personal data <b>anonymously</b> from the Cumulus purchase points program run by Migros, which is <b>data that we the customers should be able to use and reuse</b>.</p>
        <a class="btn btn-large btn-success btn-opendata" href="#">Open your data</a>
      </div>

      <div class="row-fluid box box-howto hidden">
    	<button type="button" class="close" data-dismiss="alert">&times;</button>
   	
        <div class="span3">
          <h4>1. Access your account</h4>
          <p>Log into the <a href="http://www.migros.ch/cumulus/de/secure/punktestand.html" class="urlextern" title="http://www.migros.ch/cumulus/de/secure/punktestand.html" rel="nofollow">Cumulus program</a> using your customer number and a password on a paper mail-out to create an M-Connect account if you have not already.</p>
          <a href="http://make.opendata.ch/wiki/_detail/project:finance:cumulus-howto.png?id=project%3Acumulizer" class="media" title="project:finance:cumulus-howto.png"><img src="http://make.opendata.ch/wiki/_media/project:finance:cumulus-howto.png?w=100" class="media" alt="" width="200" border="1"></a>
		</div>

        <div class="span3">
          <h4>2. Download receipts</h4>
          <p>Under <strong>Mein Konto - Kassenbons</strong> you can browse and view details of your <a href="https://www.migros.ch/cumulus/de/secure/kassenbons.html" class="urlextern" title="https://www.migros.ch/cumulus/de/secure/kassenbons.html" rel="nofollow">shopping receipts</a>. Browsing month-by-month, and for every page, you need to click <strong>Alle</strong>, and then <strong>Ausgewählte Kassenbons als Excel-Liste (csv)</strong> (not “Übersicht”) to download a file with the details for those shopping trips.</p>
		</div>

        <div class="span3">
          <h4>3. Open your data</h4>
          <p>You are now ready to share your personal data with us. At the moment this application does not process uploads automatically, but if you are really eager to help, please send your CSV files <a href="mailto:data@cumulizer.eu">by email.</p>
          <center><img src="img/opendata-logo-RGB-onlyicon-nocircle.png" width="80"></center></a>
        </div>

      </div>

      <div class="row-fluid well">
          <h4>Categorize Products</h4>
          <p>The productnames that Migros delivers in the CSV-Download look the same as the ones you see on your actual receipt. Like on your receipt, we can't always understand what the product we supposedly bought actually is. Accordingly, we're not able to categorize a lot of the imported products.</p>
          <p>You can help us with that by clicking on the category you think this product belongs to below.</p>
          <div class="row-fluid lead">The product <span id="voteProductName" data-productid=""></span> belongs into the category:</div>
          <div class="row-fluid">
              <div class="span3 category" id="categorySuggestion1" data-categoryid="1">
                  <img src="http://public.api.migipedia.ch/de/image/category/O/1.jpg" />
                  <h5></h5>
              </div>
              <div class="span3 category" id="categorySuggestion2" data-categoryid="2">
                  <img src="http://public.api.migipedia.ch/de/image/category/O/1774.jpg" />
                  <h5></h5>
              </div>
              <div class="span3 category" id="categorySuggestion3" data-categoryid="3">
                  <img src="http://public.api.migipedia.ch/de/image/category/O/1414.jpg" />
                  <h5></h5>
              </div>
              <div class="span3 category" id="categorySuggestionOther" data-categoryid="0">
                  ?
                  <h5>Something else</h5>
              </div>
          </div>
      </div>

      <hr>
      
      <div class="row-fluid dashboard">
      
      	<div id="chart">
			<svg></svg>
		</div>
		
      </div>
      
      <hr>

      <div class="footer">
        <p>By Christian Studer, Martin Vögeli, Oleg Lavrovsky</p>
      </div>

    </div> <!-- /container -->

    <script src="./js/jquery.min.js"></script>
    <!--
    <script src="./js/bootstrap-transition.js"></script>
    <script src="./js/bootstrap-alert.js"></script>
    <script src="./js/bootstrap-modal.js"></script>
    <script src="./js/bootstrap-dropdown.js"></script>
    <script src="./js/bootstrap-scrollspy.js"></script>
    <script src="./js/bootstrap-tab.js"></script>
    <script src="./js/bootstrap-tooltip.js"></script>
    <script src="./js/bootstrap-popover.js"></script>
    <script src="./js/bootstrap-button.js"></script>
    <script src="./js/bootstrap-collapse.js"></script>
    <script src="./js/bootstrap-carousel.js"></script>
    <script src="./js/bootstrap-typeahead.js"></script>
    -->
    
    <script src="js/nvd3/lib/d3.v2.min.js"></script>
    <script src="js/nvd3/lib/fisheye.js"></script>
    <script src="js/nvd3/nv.d3.min.js"></script>
    
    <script src="./js/app.js"></script>

  </body>
</html>
