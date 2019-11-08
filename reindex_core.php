<?php 
	use Magento\Framework\App\Bootstrap;
	require __DIR__ . '/../app/bootstrap.php'; 
	set_time_limit(0); 
	$status = "";
	$params = $_SERVER;
	$bootstrap = Bootstrap::create(BP, $params);
	$obj = $bootstrap->getObjectManager();
	$state = $obj->get('Magento\Framework\App\State');
	$state->setAreaCode('frontend');
	$indexer = $obj->get('Magento\Indexer\Model\Indexer\CollectionFactory')->create();
	$ids = $indexer->getAllIds();
	if(isset($_GET["index"])){	
		$indexerId = $_GET["index"];
	    $indexer = $obj->get('Magento\Framework\Indexer\IndexerRegistry')->get($indexerId);
	    $indexer->reindexAll($indexerId); // this reindexes all	    
	    //$status = 'Succesfully Reindexed - '.$indexerId;	 
	    header( "Location:/reindex_core.php?status=1" );   
	} 

	if(isset($_GET["reset"])){	
		$indexerId = $_GET["reset"];
	    $indexer = $obj->get('Magento\Framework\Indexer\IndexerRegistry')->get($indexerId);
	    $state = $indexer->getState();
	    $state->setStatus(\Magento\Framework\Indexer\StateInterface::STATUS_INVALID);
	    $state->save(); 
	    //$status = 'Succesfully resetted - '.$indexerId;
	    header( "Location:/reindex_core.php?status=1" );	    
	}

	if(isset($_GET["status"])){	
		$status = 'Successfully done !!!';
	} 

	?>
<html>
<head>
	<meta charset="UTF-8">
	<title>EST Reindexer</title>
</head>
<body>
<div class="reindexerBlock">
<h1><a href="/reindex_core.php">Reindexer</a></h1>
<?php if($status): ?>
<p class="alert"><?php echo $status; ?></p>
<?php endif; ?>
<table>
  <tr>
    <th>Indexer Name</th>
    <th>Click to Reindex</th> 
    <th>Current Status</th>
    <th>Click to Reset</th>  	
  </tr>  
  <?php foreach ($ids as $id) { 
  	$indexer = $obj->get('Magento\Framework\Indexer\IndexerRegistry')->get($id); ?>
	<tr>
	  <td><?php echo $id; ?></td>
	  <td><a class="statusButton" href="?index=<?php echo $id; ?>">Reindex</a></td>	
	  <?php switch ($indexer->getStatus()) {
	  	case 'valid':
	  		$style = "green";
	  		break;	  	
	  	default:
	  		$style = "red";
	  		break;
	  } ?>		
	  <td><a class="statusButton" style="background-color:<?php echo $style; ?>">Status: <?php echo $indexer->getStatus(); ?></a></td>
	  <td><a onclick="resetChecker()" class="resetChecker statusButton" style="background-color:#ec2029" href="?reset=<?php echo $id; ?>">Reset</a></td>
	</tr>
  <?php } ?>
</table>
<style> 
td { 
	padding: 10px; font-size: 18px;
}

.statusButton {
  background-color: black; 
  border: 2px solid blue;
  color: white;
  padding: 7px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 19px;
}

.alert {
  padding: 20px;
  background-color: #4CAF50;
  color: white;
  margin-bottom: 15px;
}

.reindexerBlock{
	width: 1024px;
	margin: 0 auto;
}

</style>
<script>
function resetChecker(){  
  var r = confirm("Sure you want to reset?");
  if (r !== true){
    event.preventDefault();
  }  
}
</script>	
</div>
</body>
</html>