<?php
$conf['MYSQL']['host']='localhost';
require config.php;
/* in config.php:
$conf['MYSQL']['user']='';
$conf['MYSQL']['pass']='';
$conf['MYSQL']['db']='';
*/
$conf['MYSQL']['table']='latin';
$conf['names']['first']="names".DIRECTORY_SEPARATOR."first-names.txt";
$conf['names']['middle']="names".DIRECTORY_SEPARATOR."middle-names.txt";
$conf['names']['last']="names".DIRECTORY_SEPARATOR."names.txt";
$conf['questions']='questions.csv';
$conf['answer']['wrong']='wrong_answers.csv';
$conf['answer']['right']='right_answers.csv';

function dbCon(){
	global $conf;
	$c=$conf['MYSQL'];
	$con=mysqli_connect($c['host'],$c['user'],$c['pass'],$c['db']);
	mysqli_set_charset($con,'utf8');
	return $con;
}
header('Content-Type: application/json');
$r=$_GET['r'];
$r=explode('/',$r);
if($r[0]=='name'){
	echo '["'.ranName().'"]';
}elseif($r[0]=='info'){
	header('Content-Type: text/plain');
	// echo linecount($conf['names']['first']);
	checkDB();
}elseif($r[0]=='q'){
	echo createWidgetInformation();
}elseif($r[0]=='t'){
	array_shift($r);
	echo testWidget(implode($r));
}elseif($r[0]=='l'){
	array_shift($r);
	$line=intval(implode($r));
	echo createWidgetInformation($line);
}elseif($r[0]=='mysql'){
	header('Content-Type: text/plain');
	$c=$conf['MYSQL'];
	$con=mysqli_connect($c['host'],$c['user'],$c['pass'],$c['db']);
	mysqli_set_charset($con,'utf8');
	echo mysqli_connect_errno().PHP_EOL.mysqli_connect_error();
	echo PHP_EOL.$conf['names']['first'];
}else{
	echo "[]";
	exit;
}
function linecount($file){
	$linecount=0;
	$handle=fopen($file,"r");
	while(!feof($handle)){
		$line=fgets($handle,4096);
		$linecount+=substr_count($line,PHP_EOL);
	}
	fclose($handle);
	return $linecount-1;
}
function testWidget($widget){
	return json_encode(array('widget'=>array('type'=>$widget,'html'=>file_get_contents('res'.DIRECTORY_SEPARATOR.$widget)),'subject'=>'test','message'=>'this is a test','answer'=>'',
	'keys'=>"ID&nbsp;".randstring()."<br>&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i:s:B:UO")."<br>KEY&nbsp;".randstring(13)));
}
function createWidgetInformation($i=-1){
	global $conf;
	$question=str_getcsv(ranLine($conf['questions'],$i),";");
	$widget['widget']['type']=array_shift($question);
	$widget['widget']['html']=file_get_contents("res".DIRECTORY_SEPARATOR.$widget['widget']['type']);
	$con=dbCon();
	list($widget['subject'],$widget['message'],$widget['answer'],$widget['reply']['right'],$widget['reply']['wrong'])=process($question);
	if($widget['reply']['right']!=''){
		$right=str_getcsv($widget['reply']['right'],";");
		$widget['reply']['right']=array();
		list($widget['reply']['right']['subject'],$widget['reply']['right']['message'])=$right;
		$wrong=str_getcsv($widget['reply']['wrong'],";");
		$widget['reply']['wrong']=array();
		list($widget['reply']['wrong']['subject'],$widget['reply']['wrong']['message'])=$wrong;
	}
	$widget['keys']="ID&nbsp;&nbsp;".randstring()."<br>&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i:s:B:UO")."<br>KEY&nbsp;".randstring(13);
	$widget['reply']['right']['keys']="ID&nbsp;&nbsp;".randstring()."<br>&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i:s:B:UO")."<br>KEY&nbsp;".randstring(13);
	$widget['reply']['wrong']['keys']=$widget['reply']['right']['keys'];
	return json_encode($widget);
}
function replace($subject,$type,$word){
	global $conf;
	$search=array();
	$replace=array();
	$search[]='$p';$replace[]=ranName();
	if($type!=''){
		$search[]='$'.$type;$replace[]=$word['value'];
		$search[]='$t';$replace[]=$word['translation'];
		$search[]='$f';$replace[]=$word['f'];
		$search[]='$e';$replace[]=$word['forms'][$word['f']];
	}
	$subject=str_replace($search,$replace,$subject);
	$search[]='$a';$replace[]=$subject[2];
	$subject[]=str_replace($search,$replace,ranLine($conf['answer']['right']));
	$subject[]=str_replace($search,$replace,ranLine($conf['answer']['wrong']));
	return $subject;
}
function ranLine($file,$i=-1){
	$lines=linecount($file);
	if($i>$lines-1||$i<0){
		$i=rand(0,$lines);
	}
	$f=new SplFileObject($file);
	$f->seek($i);
	return $f->current();
}
function ranName(){
	global $conf;
	$c=$conf['names'];
	$name=ranLine($c['first']).' ';
	if(rand(0,10)>5){
		$name.=ranLine($c['middle']).' ';
	}
	$name.=ranLine($c['last']);
	return preg_replace("[\\r\\n]","",$name);
}
function contains(array $arr,$str){
	foreach($arr as $a){
		if(strpos($a,$str)!==false){
			return true;
		}
	}
	return false;
}
function randstring($i=32){
	$characters='0123456789abcdefghijklmnopqrstuvwxyz';
	$randstring='';
	for (;$i>0;$i--) {
		$randstring.=$characters[rand(0,strlen($characters)-1)];
	}
	return $randstring;
}
function process($texts){
	global $conf;
	$p=ranName();
	$first=findFirst($texts);
	$word=newWord($first);
	for($i=0;$i<=2;$i++){
		$text=$texts[$i];
		if(empty($text)){
			continue;
		}
		if($text[0]=='$'){
			$str='';
			$type=$text[1];
			switch($type){
				case 'V':case 'N':case 'S':$word=newWord($type);break;
				case 'v':case 'n':case 's':$str.=$word['value'];break;
				case 't':$str.=$word['translation'];break;
				case 'F':$word['f']=array_rand($word['forms']);
				case 'f':$str.=$word['f'];break;
				case 'E':$word['f']=array_rand($word['forms']);
				case 'e':$str.=$word['forms'][$word['f']];break;
				case 'P':$p=ranName();
				case 'p':$str.=$p;break;
				default:$str.=$type;break;
			}
			$text=explode('$',substr($text,2));
		}else{
			$text=explode('$',$text);
			$str=array_shift($text);
		}
		if(!empty($text)){
			for($j=0;$j<count($text);$j++){
				$tok=$text[$j];
				if($tok==''){
					continue;
				}
				$type=$tok[0];
				if($type!=''){
					switch($type){
						case 'V':case 'N':case 'S':$word=newWord($type);break;
						case 'v':case 'n':case 's':$str.=$word['value'];break;
						case 't':$str.=$word['translation'];break;
						case 'F':$word['f']=array_rand($word['forms']);
						case 'f':$str.=$word['f'];break;
						case 'E':$word['f']=array_rand($word['forms']);
						case 'e':$str.=$word['forms'][$word['f']];break;
						case 'P':$p=ranName();
						case 'p':$str.=$p;break;
						default:$str.=$type;break;
					}
					$str.=substr($tok,1);
				}
			}
		}
		$texts[$i]=$str;
	}
	$texts[]=ranLine($conf['answer']['right']);
	$texts[]=ranLine($conf['answer']['wrong']);
	for($i=3;$i<=4;$i++){
		$text=explode('$',$texts[$i]);
		$str=array_shift($text);
		for($j=0;$j<count($text);$j++){
			$tok=$text[$j];
			$type=$tok[0];
			if($type!=''){
				switch($type){
					case 'V':case 'N':case 'S':$word=newWord($type);break;
					case 'v':case 'n':case 's':$str.=$word['value'];break;
					case 't':$str.=$word['translation'];break;
					case 'F':$word['f']=array_rand($word['forms']);
					case 'f':$str.=$word['f'];break;
					case 'E':$word['f']=array_rand($word['forms']);
					case 'e':$str.=$word['forms'][$word['f']];break;
					case 'P':$p=ranName();
					case 'p':$str.=$p;break;
					case 'a':$str.=$texts[2];break;
					default:$str.='$'.$type;break;
				}
				$str.=substr($tok,1);
			}
		}
		$texts[$i]=$str;
	}
	return $texts;
}
function findFirst($texts){
	if(empty($texts)){
		return null;
	}
	$allow=array('v','n','s');
	foreach ($texts as $text){
		if(empty($text)){
			continue;
		}
		if($text[0]=='$'){
			if(in_array(strtolower($text[1]),$allow)){
				return $text[1];
			}
		}
		$e=explode('$',$text);
		array_shift($e);
		foreach($e as $t){
			if(in_array(strtolower($t[0]),$allow)){
				return $t[0];
			}
		}
	}
	return null;
}
function newWord($type){
	global $conf;
	if($type==null){
		return null;
	}
	$con=dbCon();
	$res=null;
	switch(strtolower($type)){
		case 'v':$res=mysqli_query($con,"SELECT * FROM ".$conf['MYSQL']['table']." WHERE type='verb' ORDER BY RAND() LIMIT 1");break;
		case 'n':$res=mysqli_query($con,"SELECT * FROM ".$conf['MYSQL']['table']." WHERE type='nomen' ORDER BY RAND() LIMIT 1");break;
		case 's':$res=mysqli_query($con,"SELECT * FROM ".$conf['MYSQL']['table']." WHERE type='sentence' ORDER BY RAND() LIMIT 1");break;
		default:return null;
	}
	$word=mysqli_fetch_assoc($res);
	mysqli_close($con);
	$word['forms']=json_decode($word['forms'],true);
	// print_r($word['forms']);
	$word['f']=array_rand($word['forms']);
	return $word;
}
function checkDB(){
	global $conf;
	$con=dbCon();
	$res=mysqli_query($con,"SELECT forms,id FROM ".$conf['MYSQL']['table']);
	mysqli_close($con);
	while($dsatz=mysqli_fetch_assoc($res)){
		$data=json_decode($dsatz['forms'],true);
		if($data==null||$data==false){
			echo "WRONG";
		}else{
			echo "right";
		}
		echo " ID $dsatz[id]\n";
	}
}
