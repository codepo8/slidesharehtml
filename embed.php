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
$current = intval($_GET['current']) ? intval($_GET['current']) : 1;
$width = intval($_GET['width']) ? intval($_GET['width']) : 320;
$large = '';
if($width > 320){
  $large = '&big=1';
}
$url = $_GET['url'];
$url = preg_replace('/.net\//','.net/mobile/',$url);
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.10");
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
  <style type="text/css">
  *{margin:0;padding:0;}
  #slideshare{
    float:left;
    min-width:<?php echo $width;?>px;
    min-height:200px;
    margin:10px;
    position:relative;
    -moz-box-shadow:2px 2px 10px rgba(0,0,0,.6);
    -webkit-box-shadow:2px 2px 10px rgba(0,0,0,.6);
    -o-box-shadow:2px 2px 10px rgba(0,0,0,.6);
    box-shadow:2px 2px 10px rgba(0,0,0,.6);
  }
  .preload{
    position:absolute;
    left:-20000px;
    top:-2000px;
  }
  #fwd{
    position:absolute;
    right:0px;
  }
  #count{
    position:absolute;
    left:42%;
    bottom:5px;
    display:block;
  }
  input{
    font-weight:bold;
    border:none;
    background:none;
    color:#fff;
    background:#333;
    margin:0 5px;
    padding:2px;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    border-radius:3px;
  }
  input.inner{background:#ccc;color:#000;}
  form{
    font-family:helvetica,arial,sans-serif;
    background:#ccc;
    padding-bottom:5px;
    font-size:12px;
    font-weight:bold;
    position:relative;
  }
  #innext,#inprev{
    position:absolute;
    top:<?php echo intval($width/2.7);?>px;
    right:0;
    width:3em;
  }
  #inprev{
    left:0;
  }
  .inner{
    visibility:hidden;
  }
  #img:hover .inner{visibility:visible}
  input:hover{
    background:#393;
  }
  input[disabled]{
    background:#aaa;
  }
  input.inner[disabled]{
    background:#000;
    color:#333;
  }
  #current{width:3em;text-align:center;background:#fff;color:#000;}
  </style>
</head>
<body>
<?php if($yay){ 
 if($current < 1 || $current > $num){
   $current = 1;
 }  
?>

<div id="slideshare"><form id="f"><div id="img">
  <img id="slide" src="<?php echo $slides;?>-slide-<?php echo $current;?>.jpg<?php echo $large;?>" alt="" width="<?php echo $width;?>">
  <input type="button" id="innext" class="inner" value="&#x25B6;">
  <input type="button" id="inprev" class="inner" value="&#x25C0;">
  </div>
  <div>
    <span id="back">
      <!-- 
        <input type="button" id="first" value="first" disabled="disabled"> 
      -->
      <input type="button" id="prev" value="&#x25C0;">
    </span>
    <span id="count"><input type="text" id="current" value="1" name="current"> / <?php echo $num;?></span>
    <span id="fwd">
      <input type="button" value="&#x25B6;" id="next">
      <!-- <input type="button" value="last" id="last"> -->
    </span>
  </div>
</form></div>
<script src="http://yui.yahooapis.com/combo?3.2.0pr1/build/yui/yui-min.js"></script>
<script>
YUI().use('node', function(Y) {
  var current = <?php echo $current;?>,
      all = <?php echo $num;?>,
      img = Y.one('#slide'),
      url = img.get('src').replace(/\d+\.jpg<?php echo $large;?>/,'');
  for(var i=2;i<10;i++){
    var cacheimg = document.createElement('img');
    cacheimg.setAttribute('src',url+i+'.jpg<?php echo $large;?>');
    cacheimg.className = 'preload';
    document.body.appendChild(cacheimg);
  }
  update(current);
  Y.one('#slideshare').delegate('click',function(event){
    var id = this.get('id');
    switch(id){
      case 'next':current++;break;
      case 'prev':current--;break;
      case 'innext':current++;break;
      case 'inprev':current--;break;
      /*case 'last':current = all;break;
      case 'first':current = 1;break;*/
    }
    update(current);
  },'input');
  function update(current){
    Y.one('#current').set('value',current);
    if(current === all){
      /*Y.one('#last').set('disabled','disabled');*/
      Y.one('#next').set('disabled','disabled');
      Y.one('#innext').set('disabled','disabled');
    } else {
      /* Y.one('#last').removeAttribute('disabled');*/
      Y.one('#next').removeAttribute('disabled');
      Y.one('#innext').removeAttribute('disabled');
    }
    if(current === 1){
      /*Y.one('#first').set('disabled','disabled');*/
      Y.one('#prev').set('disabled','disabled');
      Y.one('#inprev').set('disabled','disabled');
    } else {
      /*Y.one('#first').removeAttribute('disabled');*/
      Y.one('#prev').removeAttribute('disabled');
      Y.one('#inprev').removeAttribute('disabled');
    }
    if(current > 9){
      var cacheimg = document.createElement('img');
      cacheimg.setAttribute('src',url+(current+1)+'.jpg<?php echo $large;?>');
      cacheimg.className = 'preload';
      document.body.appendChild(cacheimg);
      var cacheimg2 = document.createElement('img');
      cacheimg2.setAttribute('src',url+(current+2)+'.jpg<?php echo $large;?>');
      cacheimg2.className = 'preload';
      document.body.appendChild(cacheimg2);
    }
    img.set('src',url + current + '.jpg<?php echo $large;?>');
  };
  Y.on('blur',function(e){
    current = Y.one('#current').get('value');
    if(current > 0 && current <= all){
      update(current);
    }
    e.preventDefault();
    return false;
  },'#current');
  Y.on('submit',function(e){
    current = Y.one('#current').get('value');
    if(current > 0 && current <= all){
      update(current);
    }
    e.preventDefault();
    return false;
  },'#f');
});
</script>
<?php }?>
</body>
</html>