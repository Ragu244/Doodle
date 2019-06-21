<?php

include("config.php");
include("classes/SiteResultsProvider.php");
include("classes/ImageResultsProvider.php");
 
if(isset($_GET["term"]))
{
    $term=$_GET["term"];
}
else{
    exit("You have not entered any item");
}


if(isset($_GET["type"]))
{
    $type=$_GET["type"];
}
else
{
    $type="sites";
}


if(isset($_GET["page"]))
{
    $page=$_GET["page"];
}
else
{
    $page=1;
}
?>


<!DOCTYPE html>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="/PHP free/Doodle/css/style.css" >
<!-- Latest compiled and minified CSS -->
  
<style>


.paginationContainer{
	
	display:flex;
	justify-content:center;
	margin-bottom:25px;
}
.pageButton{
	display:flex;
}

.pageNumberContainer img{
	height:37px;
}

.pageNumberContainer,.pageNumberContainer a{
	display:flex;
	flex-direction:column;
	align-items:center;
	text-decoration:none;
}

.pageNumber{
	color:#000;
	font-size:13px;
}

a .pageNumber{
	color:#4285f4;
}

@media only screen and (max-width:600px){


.tabsContainer{
    margin-left:30px;
}

.mainResultsSection
{
    flex:1;
}

.mainResultsSection .resultsCount
{
    font-size:13px;
    color:#808080;
    margin-left:30px;
}

.mainResultsSection .siteResults{
    margin-left: 30px;
}



 







}	


</style>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  
</head>
<body>
    <div class="wrapper ">
        <div class="header">
            <div class="headerContent">
           
                 <div class="logoContainer">
                     <a href="index.php">
                        <img src="/PHP free/Doodle/img/logoo.png">
                    </a>

                </div>
        

                <div class="searchContainer">
                    <form action="/PHP free/Doodle/search.php" method="GET">
                        <div class="searchBarContainer">
						<input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input type="text" class="searchBox" name="term" value="<?php echo $term;?>">
                            <button class="searchButton">
                            <img src="/PHP free/Doodle/img/search.png">
                            </button>
                        </div>
                    </form>
                </div>
        
            </div>

            <div class="tabsContainer">
                <ul class="tabList">
                    <li class="<?php echo $type == "sites" ? "active" : "" ?>">
                        <a href="<?php echo "search.php?term=$term&type=sites"; ?>">Sites</a>
                    </li>
                    
                </ul>
            </div>

            

        </div>
                <div class="mainResultsSection">
                    <?php
						if($type=="sites")
						{
                        $resultsProvider=new SiteResultsProvider($con);
                        $pageSize=20;
						}
						
						else{
							$resultsProvider=new ImageResultsProvider($con);
                        $pageSize=30;
						}
	
						
						$numResults=$resultsProvider->getNumResults($term);
                        echo "<p class='resultsCount'> $numResults results found </p>";

                        echo $resultsProvider->getResultsHtml($page,$pageSize,$term);
                    
                    ?>
                </div>
				
				<div class="paginationContainer" >
				
				
					<div class="pageButton" >
					
					
						<div class="pageNumberContainer">
							<img src="/PHP free/Doodle/img/pagestart.png">
						</div>
						<?php
						
						$pagesToShow=10;
						$numPages=ceil($numResults/$pageSize);
						$pagesLeft=min($pagesToShow,$numPages);
						
						$currentPage=$page-floor($pagesToShow/2);
						
						if($currentPage<1)
						{
							$currentPage=1;
						}
						
						if($currentPage+$pagesLeft > $numPages +1)
						{
							$currentPage=$numPages+1-$pagesLeft;
						}
						
						while($pagesLeft!=0 && $currentPage <= $numPages){
							
							if($currentPage==$page )
							{
							echo "<div class='pageNumberContainer'>
								<img src='/PHP free/Doodle/img/pageselected.png'>
								<span class='pageNumber'>$currentPage</span>
								</div>";
							}
							else{
								echo "<div class='pageNumberContainer'>
								<a href='search.php?term=$term&type=$type&page=$currentPage'>
								<img src='/PHP free/Doodle/img/page.png'>
								<span class='pageNumber'>$currentPage</span>
								</a>
								</div>";
							}
								
								$currentPage++;
								$pagesLeft--;
						}
						?>
						
						<div class="pageNumberContainer">
							<img src="/PHP free/Doodle/img/pageend.png">
						</div>
						
					</div>
				
				
				</div>
				
				
				
    </div>
	<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
	<script src="/PHP free/Doodle/js/main.js"></script>
</body>
</html> 