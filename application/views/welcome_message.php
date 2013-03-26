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
          <li><a href="mailto:data@cumulizer.eu">Contact</a></li>
        </ul>
        <h3 class="muted logo">Cumulizer</h3>
      </div>

      <hr>

      <div class="jumbotron">
        <h1>Your personal shopping analyzer</h1>
        <p class="lead">This project aims to open and make use of personal data on purchases. We can help you download your shopping receipts through the <a href="http://migros.ch/cumulus">Cumulus</a> program run by <a href="http://migros.ch">Migros</a> and visualize how you spend your money on groceries.</p>
        <a class="btn btn-large btn-success btn-opendata" href="#">How to open your data</a>
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
          <h4>3. Share your data</h4>
          <p>You are now ready to share your personal data with us - <b>anonymously</b>. Your identity is not in the data extract, and we will not store any details about you. At the moment we are not ready to process uploads automatically, but if you would like to participate at this early stage, please send your CSV files <a href="mailto:data@cumulizer.eu">by email</a>.</p>
        </div>
        
        <div class="span2">
        	<a href="mailto:data@cumulizer.eu">
          <img src="img/open-shopping.png" vspace="30"></a>
        </div>

      </div>

      <hr>
      
      <div class="row-fluid dashboard">
      
      	<div class="span2">
		  	<ul class="nav nav-list">
			  <li class="nav-header">Dashboard</li>
			  <li class="active"><a href="#chart-spending-stacked">Spending over time</a></li>
			  <li><a href="#chart-category-pie">Purchases by category</a></li>
			  <li><a href="#stores-heatmap">Heatmap of store usage</a></li>
	  		</ul>
      	</div>
      
      	<div class="tab-content">
      		
		  	<div id="chart-spending-stacked" class="tab-pane active">
				<svg></svg>
			</div>
			
			<div id="chart-category-pie" class="tab-pane">
				<div class="span7"><svg></svg></div>
				<div class="span3">
					<p><span class="badge badge-warning">&#9733;</span></p>
					<p>We are still working on a way of classifying the products by category - it is rather tricky with the information we get. The chart is random. Drop us a line if you can help.</p>
				</div>
			</div>
			
			<div id="stores-heatmap" class="tab-pane">
			  <iframe src="dashboard/heatmap" width="100%" height="740" frameborder="0"></iframe>
			</div>
		
		</div>
		
	</div>
	
	<div class="row-fluid">
      
      <hr>

      <div class="footer">
      	<p style="float:right;width:20em;"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/80x15.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">Cumulizer</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.</p>
      
        <p>&copy; 2013 Christian Studer, Martin Vögeli, Oleg Lavrovsky</p>
        
        <p><a href="http://www.flickr.com/photos/squeegeed/17389724/">Photo</a> <span class="ccIcn ccIcnSmall"><a href="http://creativecommons.org/licenses/by-nc-nd/2.0/"><img src="http://l.yimg.com/g/images/cc_icon_attribution_small.gif" border="0" alt="Attribution" title="Attribution"><img src="http://l.yimg.com/g/images/cc_icon_noncomm_small.gif" border="0" alt="Noncommercial" title="Noncommercial"><img src="http://l.yimg.com/g/images/cc_icon_noderivs_small.gif" border="0" alt="No Derivative Works" title="No Derivative Works"></a></span>
 <a href="http://creativecommons.org/licenses/by-nc-nd/2.0/" title="Attribution-NonCommercial-NoDerivs License">Some rights reserved</a> by <a href="http://www.flickr.com/photos/squeegeed">squeegeed</a></p>
        
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
