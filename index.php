<?php
  if(isset($_GET['url'])){
    if(!preg_match('/^http:\/\/www.slideshare.net/',$_GET['url'])){
    $url = 'error';
    } else {
      $url = $_GET['url'];
    }
  }
  if(isset($_GET['width'])){
    $width = intval($_GET['width']);
  }
  if(isset($_GET['current'])){
    $current = intval($_GET['current']);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
  <title>Embedding Slideshare presentations as HTML/JavaScript</title>
  <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?2.8.0/build/reset-fonts-grids/reset-fonts-grids.css&2.8.0/build/base/base-min.css">
  <style type="text/css">
  iframe{border:none;}
  textarea{padding:10px;width:700px;border:none;
  -webkit-box-shadow:0px 0px 20px rgba(33,123,232,.8);
  -moz-box-shadow:0px 0px 20px rgba(33,123,232,.8)
  box-shadow:0px 0px 20px rgba(33,123,232,.8)
  }

  html,body{background:#9cf;color:#000}
  #doc{background:#fff;border:1em solid #fff;
  -moz-box-shadow:2px 2px 10px rgba(0,0,0,.8);
  -webkit-box-shadow:2px 2px 10px rgba(0,0,0,.8)
  box-shadow:2px 2px 10px rgba(0,0,0,.8);
  }
  label span{font-size:80%;color:#666;display:block;}
  #url{width:20em;}
  #width{width:3em;text-align:right;}
  #current{width:3em;text-align:right;}
  #ft{font-size:80%;margin-top:3em;text-align:right;}
  h1,h2{font-family:"arial rounded mt bold",arial,sans-serif}
  h1{color:#369;font-size:200%}
  label{float:left;clear:both;font-weight:bold;padding:5px 0;width:13em;}
  label.il{display:inline;font-weight:bold;padding:5px 0;}
  input[type=submit]{margin-right:1em;}
  form div{padding-bottom:5px;overflow:hidden;}
  h2{color:#333;margin:2em 0;}
  .error{color:#c00;margin:2em 0;font-weight:bold;}
  h2 span{color:#fff;background:#393;-moz-border-radius:20px;-webkit--border-radius:20px;border-radius:20px;padding:10px 15px;}
  a{color:#369;}  </style>
</head>
<body class="yui-skin-sam">
<div id="doc" class="yui-t7">

  <div id="hd" role="banner">
    <h1>Creating a Slideshare HTML/JS embed</h1>
  </div>
  <div id="bd" role="main">
    <p>Slideshare is a great system to host presentations for distribution. The thing about it that keeps some folk from using it is that it uses Flash. Fear not, for here you can create a plain HTML/JavaScript/CSS embed version of Slideshare presentations. Simply follow the steps below:</p>
    <h2><span>1</span> Give us the Slideshare presentation settings</h2>
    <form action="index.php">
      <div><label for="url">The Slideshare URL</label><input type="url" name="url" id="url" value="<?php echo $url;?>"><input type="hidden" name="generate" value="yes"></div>
      <div><label for="width" class="il">Slideshow width <span>(leave empty for auto width)</span></label><input type="text" name="width" id="width"  value="<?php echo $width;?>"></div>
      <div><label for="current" class="il">Start with slide #</label><input type="text" name="current" id="current"  value="<?php echo $current;?>"></div>
      <div><input type="submit" value="give me the embed!"></div>
    </form>
<?php if(isset($_GET['generate']) && $url!='error'){?>
  <?php
    if($width > 0){
      $fwidth = $width+50;
      $fheight = intval($fwidth / 1.2);
    } else {
      $fwidth = 500;
      $fheight = 300;
    }

  ?>
<h2><span>2</span> Does the preview look right?</h2>
<iframe style="border:none;width:<?php echo $fwidth;?>px;height:<?php echo $fheight;?>px;" src="embed.php?url=<?php echo $url;if($width>0){echo '&width='.$width;}if($current>0){echo '&current='.$current;}?>"></iframe>
<h2><span>3</span> Your embed for copy+paste:</h2>
<form><textarea>
&lt;iframe style="border:none;width:<?php echo $fwidth;?>px;height:<?php echo $fheight;?>px;" src="http://icant.co.uk/slidesharehtml/embed.php?url=<?php echo $url;if($width>0){echo '&width='.$width;}?><?php if($current>0){echo '&current='.$current;}?>"&gt;&lt;/iframe&gt;
</textarea></form>
<?php } if($url=='error') {?>
  <p class="error">This is not a valid Slideshare url it seems :(</p>
<?php }?>

  </div>
  <div id="ft" role="contentinfo">
    <p>Written by <a href="http://wait-till-i.com">Chris Heilmann</a> - host this yourself <a href="https://github.com/codepo8/slidesharehtml">source is on GitHub</a></p>
  </div>
</div>
</body>
</html>

