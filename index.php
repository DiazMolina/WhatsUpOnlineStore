<?php
/*
Developed by Habibie
Email: habibieamrullah@gmail.com 
WhatsApp: 6287880334339
WebSite: https://webappdev.my.id
*/

include("config.php");
include("functions.php");
include("uilang.php");

?>

<!DOCTYPE html>
<html>
	<head>
		
		<?php
		
		if(isset($_GET["post"])){
			$postid = mysqli_real_escape_string($connection, $_GET["post"]);
			$sql = "SELECT * FROM $tableposts WHERE postid = '$postid'";
			$result = mysqli_query($connection, $sql);
			if($result){
				$title = shorten_text(mysqli_fetch_assoc($result)["title"], 40, ' ...', false) . " - " . $websitetitle;
			}
			?>
			
			<?php
		}else if(isset($_GET["category"])){
			$title = urldecode($_GET["category"]) . " - " . $websitetitle;
		}else if(isset($_GET["search"])){
			$title = urldecode($_GET["search"]) . " - " . $websitetitle;
		}else{
			$title = $websitetitle;
		}
		
		?>
		
		<title><?php echo $title ?></title>
		
		<meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" href="<?php echo $baseurl ?>favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo $baseurl ?>favicon.ico" type="image/x-icon">
		
		<script
          src="https://code.jquery.com/jquery-3.4.1.min.js"
          integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
          crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?php echo $baseurl ?>assets/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $baseurl ?>slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseurl ?>slick/slick-theme.css"/>
        <script type="text/javascript" src="<?php echo $baseurl ?>slick/slick.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $baseurl ?>sharingbuttons.css"/>
		<?php include("style.php"); ?>
		<script src="<?php echo $baseurl ?>somefunctions.js"></script>
	</head>
	<body>
		<div id="header">
			<div>
				<div class="inlinecenterblock" style="padding: 10px; padding-top: 15px; padding-left: 20px; padding-right: 0px;">
					<div>
						<?php
						$currentlogo = "images/logo.png";
						if($logo != "")
							$currentlogo = "pictures/" . $logo;
						?>
						<a href="<?php echo $baseurl ?>"><img src="<?php echo $baseurl . $currentlogo ?>" style="height: 64px;"></a>
					</div>
					
				</div>
				
				<div class="inlinecenterblock">
					<h1 style="margin: 0px; font-size: 30px; color: <?php echo $maincolor ?>; font-weight: bold;"><a href="<?php echo $baseurl ?>"><?php echo $websitetitle ?></a></h1>
					<div style="font-size: 13px;"><?php echo $about ?></div>
				</div>
				
				<div class="inlinecenterblock floatright">
					<div style="border-radius: 50px; display: table; box-sizing: border-box; width: 100%; border: 2px solid <?php echo $maincolor ?>;">
						<div style="display: table-cell; width: 50px; text-align: center;">
							<i class="fa fa-search"></i>
						</div>
						<div style="display: table-cell">
							<input onkeyup="quicksearch()" id="quicksearch" placeholder="<?php echo uilang("Search") ?>..." style="border: none; background-color: inherit; outline: none; margin: 0px; padding: 10px;">
						</div>
						<div style="display: table-cell; width: 50px; text-align: center; cursor: pointer;" onclick="clearSearchInput()">
							<i class="fa fa-times-circle"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php
		
		//Post (single page)
		
		if(isset($_GET["post"])){
			?>
			<div class="section">
				<div class="posttableblock">
					<div class="postcontent">
						<?php
						$postid = mysqli_real_escape_string($connection, $_GET["post"]);
						if($postid != ""){
							$sql = "SELECT * FROM  $tableposts WHERE postid = '$postid'";
							$result = mysqli_query($connection, $sql);
							if(mysqli_num_rows($result) == 0){
								echo "<p>" .uilang("Nothing found"). "</p>";
							}else{
								$row = mysqli_fetch_assoc($result);
								
								$picture = $row["picture"];
								
								if($picture != ""){
									$picture = $baseurl . "pictures/" . $picture;
								}else{
									$picture = $baseurl . "images/defaultimg.jpg";
								}
								
								$mil = $row["time"];
								$seconds = $mil / 1000;
								$postdate = date("d-m-Y", $seconds);
								?>
								
								<div id="productpic" style="background: url(<?php echo $picture ?>) no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;"></div>
								
								<?php
								$saleprice = $row["normalprice"];
								$oldprice = "";
								if($row["discountprice"] != 0){
									$saleprice = $row["discountprice"];
									$oldprice = "<span style='margin: 0px; margin-top: 20px; text-decoration: line-through; font-size: 20px; margin-right: 10px; color: gray;'>" . $currencysymbol . number_format($row["normalprice"],2) . "</span>";
								}
								?>
								
								<h1><?php echo $row["title"] ?> <i class="fa fa-angle-double-right"></i> <?php echo $oldprice . $currencysymbol . number_format($saleprice,2) ?></h1>
								
								<div>
									<?php echo $row["content"] ?>
								</div>
								
								<!-- Social Share Buttons-->
								<div style="font-size: 12px;">
									<?php
									showSharer($baseurl . "?post/" . $row["postid"], $websitetitle);
									?>
								</div>
								<br><br>
								
								<!-- Facebook Comments Plugin -->
								<div style="width: 100%; box-sizing: border-box; background-color: white; border-radius: 20px; padding: 14px;">
									<div id="fb-root"></div>
									<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&amp;version=v5.0&amp;appId=569420283509636&amp;autoLogAppEvents=1"></script>
									 
									<div class="fb-comments" data-href="<?php echo $baseurl ?>?post/<?php echo $row["postid"] ?>" data-width="100%"  data-numposts="14"></div>
									
								</div>
								
								
								<script>
									function viewedThis(postid){
										$.post("<?php echo $baseurl ?>viewcounter.php", {
											postid : postid
										}, function(data){
											console.log(data)
										})
									}
									//viewedThis("<?php echo $postid ?>")
								</script>
								<?php
							}
						}
						?>
					</div>
					<div class="randomvids">
						<div class="randomvidblock orderblock">
							<h2><?php echo uilang("Order") ?></h2>
							<label><i class="fa fa-plus"></i> <?php echo uilang("Quantity") ?></label>
							<input id="currentQ" type="number" value=1 onchange="updateCurrentTotal()" style="border-radius: 0px;">
							
							<?php
							if($row["options"] != ""){
								?>
								<div id="productoptions" style="display: none"><?php echo $row["options"] ?></div>
								<script>
									var moptions = JSON.parse($("#productoptions").html())
									var productoptions = "<label>" + moptions[0].title + "</label>" 
									productoptions += "<select id='productoptionsselect' onchange='overrideprice()'>"
									for(var i = 0; i < moptions[0].options.length; i++){
										productoptions += "<option value=" +moptions[0].options[i].price+ ">" + moptions[0].options[i].title + "</option>"
									}
									productoptions += "</select>"
									$("#productoptions").html(productoptions).show()
									setTimeout(function(){
										overrideprice()
									}, 1000)
								</script>
								<?php
							}
							?>
							
							<label><i class="fa fa-file-text-o"></i> <?php echo uilang("Notes") ?></label>
							<textarea id="ordernotes" placeholder="<?php echo uilang("Write some notes...") ?>" style="border-radius: 0px;"></textarea>
							<p id="currenttotal" style="font-size: 30px;">Rp. 12345</p>
							<div class="buybutton" onclick="addtocart()"><i class="fa fa-shopping-cart"></i> <?php echo uilang("Add to Cart") ?></div>
							
							<script>
								var currentprice = <?php echo $saleprice ?>;
								var currentTotal = 0
								var currentitem = {
									price : currentprice,
									title : "<?php echo $row["title"] ?>",
									quantity : 0,
									options : "",
									subtotal : 0,
									notes : "",
								}
								
								function overrideprice(){
									currentprice = $("#productoptionsselect").val()
									currentitem.options = $("#productoptionsselect option:selected").text()
									updateCurrentTotal()
								}
								
								function updateCurrentTotal(){
									var currentQ = $("#currentQ").val()
									if(currentQ > 0){
										currentTotal = currentQ * currentprice
									}else{
										$("#currentQ").val("1")
										currentQ = 1
										currentTotal = currentQ * currentprice
									}
									currentitem.quantity = currentQ
									$("#currenttotal").html("<?php echo $currencysymbol ?> " + tSep(currentTotal.toFixed(2)))
								}
								updateCurrentTotal()
								
								function addtocart(){
									currentitem.notes = $("#ordernotes").val()
									currentitem.subtotal = currentTotal
									appdata.orderitems.push(currentitem)
									savedata()
									reloadcartdata()
									loaddata()
									$([document.documentElement, document.body]).animate({
										scrollTop: $(".shoppingcart").offset().top
									}, 1000);
								}
							</script>
							
						</div>
						
						<div class="randomvidblock"><?php echo uilang("You may like:") ?></div>
						<?php
						$sql = "SELECT * FROM $tableposts ORDER BY RAND() LIMIT 5";
						$result = mysqli_query($connection, $sql);
						if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)){
								?>
								<a href="<?php echo $baseurl ?>?post=<?php echo $row["postid"] ?>">
									<div class="randomvidblock">
										<?php
										$imagefile = $row["picture"];
										if($imagefile == ""){
											$imagefile = "images/defaultimg.jpg";
										}else{
											$imagefile = "pictures/" . $imagefile;
										}
										

										$saleprice = $row["normalprice"];
										$oldprice = "";
										if($row["discountprice"] != 0){
											$saleprice = $row["discountprice"];
											$oldprice = "<span style='margin: 0px; margin-top: 20px; text-decoration: line-through; font-size: 12px; margin-right: 10px; color: gray;'>" . $currencysymbol . number_format($row["normalprice"],2) . "</span>";
										}

										
										?>
										<div class="lilimage" style="background: url(<?php echo $baseurl . $imagefile ?>) no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;"></div>
										<div class="lildescr">
											<div class="shorttext" style="font-size: 18px; font-weight: bold;">
												<?php echo $row["title"] ?><br><i class="fa fa-angle-double-right"></i> <?php echo $oldprice. $currencysymbol . number_format($saleprice,2) ?>
											</div>
											<div style="padding-left: 14px;">
												<p><?php echo shorten_text(strip_tags($row["content"]), 75, ' ...', false) ?></p>
											</div>
											<div style="padding-left: 14px;">
												<p style="color: <?php echo $maincolor ?>; font-weight: bold; font-size: 12px;"><i class="fa fa-calendar" style="width: 10px;"></i> <?php echo $postdate ?> <i class="fa fa-tag" style="margin-left: 5px; width: 10px;"></i> <?php echo showCatName($row["catid"]) ?></p>
											</div>
											
										</div>
									</div>
								</a>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
		
		//Home
		
		else{
			?>
			<div class="section" id="categoriesbar">
				<div style="text-align: center;">
					<?php
					$sql = "SELECT * FROM $tablecategories ORDER BY category ASC";
					$result = mysqli_query($connection, $sql);
					if($result){
						?>
						<div onclick="filtercategory('')" class="categoryblock" style="border: 1px solid <?php echo $maincolor ?>;padding: 10px; cursor: pointer;"><i class="fa fa-tag"></i> <?php echo uilang("All") ?></div>
						<?php
						while($row = mysqli_fetch_assoc($result)){
							?>
							<div onclick="filtercategory('<?php echo $row["category"] ?>')" class="categoryblock" style="border: 1px solid <?php echo $maincolor ?>;padding: 10px; cursor: pointer;"><i class="fa fa-tag"></i> <?php echo $row["category"] ?></div>
							<?php
						}
					}
					?>
				</div>
			</div>
			
			<div class="section gridcontainerunscrollable">
				<?php
				$sql = "SELECT * FROM $tableposts ORDER BY id DESC";
				$result = mysqli_query($connection, $sql);
				if($result){
					if(mysqli_num_rows($result) > 0){
						$productindex = 0;
						while($row = mysqli_fetch_assoc($result)){
							
							$imagefile = $row["picture"];
							if($imagefile == ""){
								$imagefile = "images/defaultimg.jpg";
							}else{
								$imagefile = "pictures/" . $imagefile;
							}
							$currentcategory = showCatName($row["catid"]);
							?>
							
							<!-- Thumbnail -->
							<div class="filmblock">
								<div class="categoryname" style="display: none;"><?php echo $currentcategory ?></div>
								<a href="<?php echo $baseurl ?>?post=<?php echo $row["postid"] ?>">
									<div class="productthumbnail" style="cursor: pointer; background: url(<?php echo $baseurl . $imagefile ?>) no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
									</div>
								</a>
								<div class="prodimage" style="display: none;"><?php echo $imagefile ?></div>
								<div>
									
									<?php
									$saleprice = $row["normalprice"];
									$oldprice = "";
									if($row["discountprice"] != 0){
										$saleprice = $row["discountprice"];
										$oldprice = "<span style='margin: 0px; margin-top: 20px; text-decoration: line-through; font-size: 12px; margin-right: 10px; color: gray;'>" . $currencysymbol . number_format($row["normalprice"],2) . "</span>";
									}
									?>
									
									<h2 style="margin-top: 20px;" class="producttitle"><?php echo shorten_text($row["title"], 25, ' ...', false) ?></h2><div class="productoptions" style="display: none"><?php echo $row["options"] ?></div><div style="padding-bottom: 20px; font-size: 25px; font-weight: bold; color: <?php echo $maincolor ?>"><?php echo $oldprice . $currencysymbol . "<span class='thiscurrentpricedisplay'>" . number_format($saleprice) ?></span><span style="display: none;" class="thiscurrentprice"><?php echo $saleprice ?></span> <span style="font-size: 12px;">x</span> <input class="productquantity" type="number" value=1 min=1 style="vertical-align: middle; display: inline-block; width: 40px; padding: 2px; margin: 5px; border-radius: 0px;"></div>
									<div class="morebutton" onclick="addtocart(<?php echo $productindex ?>)"><i class="fa fa-shopping-cart"></i> <?php echo uilang("Add to Cart") ?></div>
									<div style="padding: 20px;"><a onclick="showmore(<?php echo $productindex ?>)" class="textlink whatsmorebutton" style="cursor: pointer; text-decoration: none;"><i class="fa fa-chevron-down"></i> <?php echo uilang("More") ?></a><div class="whatsmorecontent" style="display: none; padding: 5px; font-size: 12px;"><?php echo shorten_text(strip_tags($row["content"]), 50, " ...") ?><br><a class="textlink" href="<?php echo $baseurl ?>?post=<?php echo $row["postid"] ?>">Continue</a></div></div>
								</div>
							</div>
							<?php
							
							$productindex = $productindex + 1;

						}
					}
				}
				
				?>
			</div>
			<?php
		}
		
		?>
		
		<div id="cartbutton">
			<div style="width: 96px; height: 96px; border-radius: 50%; background-color: white; text-align: center; display: table-cell; vertical-align: middle; border: 2px solid <?php echo $maincolor ?>; position: relative;">
				<div style="position: absolute; top: 0; text-align: center; font-size: 20px; left: 0; right: 0; padding: 5px; font-weight: bold;" id="cartcount"></div>
				<i class="fa fa-shopping-cart" style="cursor: pointer;" onclick="showcartui()"></i>
			</div>
		</div>
		
		<div id="imagedisplayer" onclick="hideimagedisplayer()"></div>
		
		
		<!-- Footer -->
		<div class="section footercopyright">
			<span>© <?php echo date("Y"); ?> <?php echo $websitetitle; ?>. All rights reserved.</span>
		</div>
		
		<div id="cartui">
			<div style="max-width: 720px; margin: 0 auto;">
			<h3 onclick='hidecartui()' style='color: <?php echo $maincolor ?>; cursor: pointer;'><i class='fa fa-arrow-left'></i> Back</h3>
				<h1><i class='fa fa-shopping-cart'></i> <?php echo uilang("Shopping Cart") ?></h1>
				<div id="cartdata"></div>
			</div>
		</div>
		
		
		
		<script>
		
			function showimage(img){
				$("#imagedisplayer").html("<img src='<?php echo $baseurl ?>" +img+ "' style='height: 100%;'>").fadeIn()
			}
			
			function hideimagedisplayer(){
				$("#imagedisplayer").fadeOut()
			}
			
			var currentcategory = ""
			
			function filtercategory(catname){
				currentcategory = catname
				if(catname == ""){
					$(".filmblock").fadeIn()
				}else{
					$(".filmblock").hide()
					for(var i = 0; i < $(".filmblock").length; i++){
						if($(".filmblock").eq(i).find(".categoryname").html() == catname)
							$(".filmblock").eq(i).fadeIn()
					}
				}
			}
			
			function showproductoptions(){
				for(var i = 0; i < $(".filmblock").length; i++){
					var po = $(".filmblock").eq(i).find(".productoptions").html()
					if(po != ""){
						var poobject = JSON.parse(po)
						var pocontents = ""
						for(var x = 0; x < poobject[0].options.length; x++){
							if(x == 0){
								var selectedprice = poobject[0].options[x].price
								$(".thiscurrentprice").eq(i).html(selectedprice)
								selectedprice = parseInt(selectedprice)
								$(".thiscurrentpricedisplay").eq(i).html(tSep(selectedprice.toFixed(2)))
							}
							pocontents += "<option value=" +poobject[0].options[x].price + ">" +poobject[0].options[x].title+ "</option>"
						}
						$(".filmblock").eq(i).find(".productoptions").html("<label class='poptionname'>" +poobject[0].title+ "</label><select onchange='overrideprice("+i+")' class='currentproductoption"+i+"' style='padding: 3px; width: 114px; margin: 0 auto;'>" + pocontents + "</select>").show()
					}
				}
			}
			
			showproductoptions()
			
			function showmore(n){
				$(".whatsmorecontent").eq(n).slideToggle()
			}
			
			function overrideprice(n){
				var selectedprice = $(".currentproductoption"+n+" option:selected").val()
				$(".thiscurrentprice").eq(n).html($(".currentproductoption"+n+" option:selected").val())
				selectedprice = parseInt(selectedprice)
				$(".thiscurrentpricedisplay").eq(n).html(tSep(selectedprice.toFixed(2)))
			}
			
			var cartobject = []
			
			function savedata(){
				localStorage.setItem("<?php echo $websitetitle ?>", JSON.stringify(cartobject))
			}
			
			function loaddata(){
				cartobject = JSON.parse(localStorage.getItem("<?php echo $websitetitle ?>"))
			}
			
			if(localStorage.getItem("<?php echo $websitetitle ?>") === null)
				savedata()
			else
				loaddata()
			
			loaddata()
			updatecartcount()
			
			function addtocart(n){
				
				$("#cartbutton").fadeOut(100, function(){
					$("#cartbutton").fadeIn()
				})
				
				var prod = $(".filmblock").eq(n)
				var prodop = prod.find(".currentproductoption"+n+" option:selected").text()
				if(prodop != "")
					prodop = " - " + prodop
				var prodtitle = prod.find(".producttitle").text() + prodop
				var prodprice = parseInt(prod.find(".thiscurrentprice").text())
				var prodquantity = parseInt(prod.find(".productquantity").val())
				var prodimage = prod.find(".prodimage").eq(0).text()
				
				function pushit(){
					cartobject.push({
						id : n,
						title : prodtitle,
						price : prodprice,
						quantity : prodquantity,
						image : prodimage,
					})
					updatecartcount()
					savedata()
				}
				
				if(cartobject.length == 0){
					pushit()
				}else{
					for(var i = 0; i < cartobject.length; i++){
						if(cartobject[i].title == prodtitle && cartobject[i].price == prodprice){
							cartobject[i].quantity += prodquantity
							savedata()
							return
						}
					}
					pushit()
					return
				}				
				
			}
			
			function updatecartcount(){
				$("#cartcount").html(cartobject.length)
			}
			
			var ordermessage = ""
			
			function showcartui(){
				ordermessage = "ORDER ID:" + Math.floor(Math.random() * 9999) + 1000 + "\n"
				var cartdata = ""
				var grandtotal = 0
				for(var i = 0; i < cartobject.length; i++){
					var tmpttl = cartobject[i].price * cartobject[i].quantity
					cartdata += "<div style='margin-bottom: 20px;'><img src='<?php echo $baseurl ?>"+cartobject[i].image+"' style='display: inline-block; vertical-align: middle; max-width: 64px; border-radius: 10px;'> "+cartobject[i].title + " <?php echo $currencysymbol ?>" + tSep(parseInt(cartobject[i].price).toFixed(2)) + " x <input id='cartq"+i+"' onchange='modifycq("+i+")' class='productquantity' type='number' value=" + cartobject[i].quantity + " min=1 style='vertical-align: middle; display: inline-block; width: 40px; padding: 2px; margin: 5px; border-radius: 0px;'> = <?php echo $currencysymbol ?>" + tSep(tmpttl.toFixed(2)) + "</div>"
					grandtotal += tmpttl
					
					ordermessage += cartobject[i].title + " x " + cartobject[i].quantity + " = " + tmpttl + "\n"
				}
				
				ordermessage += "<?php echo uilang("Total") ?> = " + grandtotal + "\n"
				
				cartdata += "<hr style='background-color: white;'><h1><?php echo uilang("Total") ?> = <?php echo $currencysymbol ?>" + tSep(grandtotal.toFixed(2)) + "</h1>"
				cartdata += "<h3><?php echo uilang("Contact Information") ?></h3><label><?php echo uilang("Name") ?></label><input id='cdname' placeholder='<?php echo uilang("Name") ?>'>"
				cartdata += "<label><?php echo uilang("Mobile") ?></label><input id='cdmobile' placeholder='<?php echo uilang("Mobile") ?>'>"
				cartdata += "<label><?php echo uilang("Address") ?></label><input id='cdaddress' placeholder='<?php echo uilang("Address") ?>'>"
				cartdata += "<label><?php echo uilang("Delivery Method") ?></label><select id='cdmethod'><?php echo uilang("Delivery Method") ?><option>Take Away</option><option>Home Delivery</option><option>Dining</option></select>"
				cartdata += "<div style='text-align: center;'><div class='buybutton' onclick='hidecartui()'><i class='fa fa-arrow-left'></i> Back to Shop</div><div class='buybutton' onclick='clearcart()'><i class='fa fa-times'></i> Clear Cart</div><div class='buybutton' onclick='chatnow()'><i class='fa fa-whatsapp'></i> Order on WhatsApp</div></div>"
				$("#cartdata").html(cartdata)
				$("#cartui").fadeIn()
				savedata()
				
			}
			
			function hidecartui(){
				
				$("#cartui").fadeOut()
				
			}
			
			function clearcart(){
				cartobject = []
				showcartui()
			}
			
			function modifycq(n){
				var newvalue = parseInt($("#cartq"+n).val())
				cartobject[n].quantity = newvalue
				showcartui()
			}
			
			function chatnow(){
				var cdname = $("#cdname").val()
				var cdmobile = $("#cdmobile").val()
				var cdaddress = $("#cdaddress").val()
				var cdmethod = $("#cdmethod").val()
				ordermessage += cdname + "\n" + cdmobile + "\n" + cdaddress + "\n" + cdmethod + "\n" 
				$.post("<?php echo $baseurl ?>ordernotes.php", {
					"message" : ordermessage
				}, function(data){
					var omuri = encodeURI(ordermessage)
					location.href = "https://wa.me/<?php echo $adminwhatsapp ?>?text=" + omuri
				})
			}
			
			function quicksearch(){
                var keyword = $("#quicksearch").val();
                keyword = keyword.toLowerCase();
                if(keyword.length > 0){
            		for(var i = 0; i < $(".filmblock").length; i++){
            			if($(".filmblock")[i].innerHTML.toLowerCase().indexOf(keyword) > -1) $(".filmblock")[i].style.display = "inline-block";
            			else $(".filmblock")[i].style.display = "none";
            		}
            	} else $(".filmblock").css({ display : "inline-block" });
				
			}
			
			function clearSearchInput(){
				$("#quicksearch").val("")
				quicksearch()
			}
			
		</script>
	</body>
</html>