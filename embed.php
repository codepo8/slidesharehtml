<?php
/*
  Slideshare HTML Version
  Uses YQL for scraping and conversion
  Homepage: http://github.com/codepo8/slidesharehtml
  Copyright (c) 2010 Christian Heilmann
  Code licensed under the BSD License:
  http://wait-till-i.com/license.txt
*/
if(!ob_start("ob_gzhandler")) ob_start();
error_reporting(0);
$url = $_GET['url'];
$url = preg_replace('/.net\//','.net/mobile/',$url);
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; HTC Desire 1.19.161.5 Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$images = curl_exec($ch); 
curl_close($ch);
preg_match_all('/"baseSlideUrl":"([^"]+)"/',$images,$slides);
preg_match_all('/"totalSlides":(\d+),/',$images,$numbers);
$num = $numbers[1][0];
$slides = $slides[1][0];
$yay = ($num && $slides);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
  <title>HTML Slideshare embed</title>
  <link rel="stylesheet" href="slidesharehtml.css" type="text/css">
</head>
<body>
<?php if($yay){ ?>
<div id="slideshare"><form>
  <img id="slide" src="<?php echo $slides;?>-slide-1.jpg" alt="">
  <div>
    <span id="back">
      <input type="button" id="first" value="first" disabled="disabled">
      <input type="button" id="prev" value="previous" disabled="disabled">
    </span>
    <span id="count">1/<?php echo $num;?></span>
    <span id="fwd">
      <input type="button" value="next" id="next">
      <input type="button" value="last" id="last">
    </span>
  </div>
</form></div>
<script src="http://yui.yahooapis.com/combo?3.2.0pr1/build/yui/yui-min.js"></script>
<script>
YUI().use('node', function(Y) {
  var current = 1,
      all = <?php echo $num;?>,
      img = Y.one('#slide'),
      url = img.get('src').replace(/\d\.jpg/,'');
      for(var i=2;i<10;i++){
        var cacheimg = document.createElement('img');
        cacheimg.setAttribute('src',url+i+'.jpg');
        cacheimg.className = 'preload';
        document.body.appendChild(cacheimg);
      }
  Y.one('#slideshare').delegate('click',function(event){
    var id = this.get('id');
    switch(id){
      case 'next':current++;break;
      case 'prev':current--;break;
      case 'last':current = all;break;
      case 'first':current = 1;break;
    }
    Y.one('#count').set('innerHTML',current+'/'+all);
    if(current === all){
      Y.one('#last').set('disabled','disabled');
      Y.one('#next').set('disabled','disabled');
    } else {
      Y.one('#last').removeAttribute('disabled');
      Y.one('#next').removeAttribute('disabled');
    }
    if(current === 1){
      Y.one('#first').set('disabled','disabled');
      Y.one('#prev').set('disabled','disabled');
    } else {
      Y.one('#first').removeAttribute('disabled');
      Y.one('#prev').removeAttribute('disabled');
    }
    if(current > 9){
      var cacheimg = document.createElement('img');
      cacheimg.setAttribute('src',url+i+'.jpg');
      cacheimg.className = 'preload';
      document.body.appendChild(cacheimg);
    }
    img.set('src',url + current + '.jpg');
  },'input');
});
</script>
<?php }?>
</body>
</html>