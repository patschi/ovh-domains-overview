<?php
/*

  @Name.....: ovh-domains-overview
  @Author...: Patschi
  @Homepage.: http://pkern.at
  @Source...: https://github.com/patschi/ovh-domains-overview
  @Date.....: 30.06.2013
  @Version..: 1.2
  @Changelog:
     v1.0: Release.
     v1.1: Added this informations on the top of index.php,
           sorting domains after expiration date,
           sorting domains with a click on domain, creation or expiration,
           commented most code in some php files,
           improved nameserver listening with implode(),
           other small improvements.
     v1.2: Added icon in navigation bar for github project page.

*/

// Include required php files
include("./inc/includes.php");

// Check if cache needs an update
run_cache();

// Load domains from cache and put it in the array
$result = load_domains();

?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-style-type" content="text/css" />
    <meta http-equiv="content-language" content="de" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="copyright" content="2013 pkern.at" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>My Domains</title>
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
            <ul class="nav pull-right">
              <li title="Source"><a href="https://github.com/patschi/ovh-domains-overview/" target="_blank"><i class="icon-share icon-white"></i></a></li>
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

// sort domains
switch($_GET["sort"]) {
  case 'domain'    : usort($result, "compare_domain"); break;
  case 'creation'  : usort($result, "compare_creation"); break;
  case 'expiration': usort($result, "compare_expiration"); break;
  case 'expirein'  : usort($result, "compare_expiration"); break;
  default          : usort($result, "compare_expiration"); break;
}

// output domains
foreach($result as $key => $dom)
{
	//print_r($dom); // for debugging
	$creation   = strtotime($dom["creation"]);
	$expiration = strtotime($dom["expiration"]);
	$expire_in  = time2str($expiration - time()); // get expire in 1h 1m 1s format
	$dom["dns"] = implode(", ", $dom["dns"]); // list domains with ","
	echo '
		<tr>
		   <td>#'.$dom["id"].'</td>
		   <td><a href="http://'.$dom["domain"].'" target="_blank" id="dom'.$dom["id"].'">'.$dom["domain"].'</a></td>
		   <td>'.date("d.m.Y", $creation).'</td>
		   <td>'.date("d.m.Y", $expiration).'</td>
		   <td>'.$expire_in.'</td>
		   <td>'.$dom["dns"].'</td>
		</tr>
';
}
?>
	    </table>
	  </p>
    </div>

</body>
</html>