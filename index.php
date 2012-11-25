<?php

include("./inc/includes.php");
run_cache();
$result = load_domains();

?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-style-type" content="text/css" />
    <meta http-equiv="content-language" content="de" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="copyright" content="2012 pkern.at" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>Domains</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <style type="text/css">
    a { 
        color:black;
    }
    #table th {
        background-color: #333;
        color: white;
    }
	.navbar {
		-webkit-box-shadow:0 2px 3px rgba(0,0,0,.25);
		-moz-box-shadow:0 2px 3px rgba(0,0,0,.25);
		box-shadow:0 2px 3px rgba(0,0,0,.25);
	}
    </style>
  </head>
  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="./">Domains</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="./">Home</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <br /><br /><br />

    <div class="container">
      <h1>Domains</h1>
      <p>

	  <div class="alert alert-success">
	    <i class="icon-globe" style="margin-right:3px;"></i> There are currently <b><?php echo count($result); ?></b> registered domains.
	  </div>

	  <table border="1" id="table" class="table table-hover table-striped table-condensed">
		<tr>
		   <th style="width:16px;">&nbsp;</th>
		   <th style="width:375px;">Domain</th>
		   <th>Created</th>
		   <th>Expiration</th>
		   <th>Expire in</th>
		   <th>DNS</th>
		</tr><?php

foreach($result as $dom)
{
	//print_r($dom);
	$creation = strtotime($dom["creation"]);
	$expiration = strtotime($dom["expiration"]);
	$expire_in = time2str($expiration - time());
	$dns = "";
	foreach($dom["dns"] as $ds)
	{
		$dns .= $ds.", "; 
	}
	$dns = substr($dns, 0, strlen($dns)-2);
	echo '
		<tr>
		   <td>#'.$dom["id"].'</td>
		   <td><a href="http://'.$dom["domain"].'" target="_blank" id="dom'.$dom["id"].'">'.$dom["domain"].'</a></td>
		   <td>'.date("d.m.Y", $creation).'</td>
		   <td>'.date("d.m.Y", $expiration).'</td>
		   <td>'.$expire_in.'</td>
		   <td>'.$dns.'</td>
		</tr>
';
}
?>
	    </table>
	  </p>
    </div>

</body>
</html>
