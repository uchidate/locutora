<?php
/*pegando duração do vídeo inicio*/
function getDuracaoVideo($id_do_video){
// URL do Feed RSS de vídeos de um usuário, assim buscamos todas as playlists dele
$youTube_UserFeedURL = “http://gdata.youtube.com/feeds/api/videos/ ” .$id_do_video;

// Usa cURL para pegar o XML do feed
$cURL = curl_init(sprintf($youTube_UserFeedURL));
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
$resultado = curl_exec($cURL);
curl_close($cURL);
$xml = new SimpleXMLElement($resultado);
$nameSpaces = $xml->getNameSpaces(TRUE);
$children = $xml->children($nameSpaces[‘media’]);
$children_c = $children->group->content->attributes()->duration;
$pc=$children_c/60;
$parte=explode(“,”,$pc);

$segundos = $children_c;

$horas = floor($segundos / 3600);
$segundos -= $horas * 3600;
$minutos = floor($segundos / 60);
$segundos -= $minutos * 60;

$tempo = “”;
if($horas != 0){
$tempo .=strlen($horas) > 1 ? $horas.”:” : “0”.$horas.”:”;
}

if($minutos != 0){
$tempo .=strlen($minutos) > 1 ? $minutos.”:” : “0”.$minutos.”:”;
}else{
$tempo .=”00:”;
}

if($segundos != 0){
$tempo .=strlen($segundos) > 1 ? $segundos : “0”.$segundos;
}

$duration=$tempo;
return $duration;

}
/*pegando duração do vídeo final*/

/*buscando vídeos do youtube inicio*/
$usuario = “nome do usuário”;
$playlist=”nome da playlist”;
$comeca_pelo=’1′;
$numero_de_resultados=’50′;

//array que irá armazenar os dados do youtube
$videos=array();
// URL do Feed RSS de vídeos de um usuário, assim buscamos todas as playlists dele
$youTube_UserFeedURL = “http://gdata.youtube.com/feeds/api/users/ “.$usuario.” /playlists?v=2″;

// Usa cURL para pegar o XML do feed

$cURL = curl_init(sprintf($youTube_UserFeedURL, $usuario));
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
$resultado = curl_exec($cURL);
curl_close($cURL);

// Inicia o parseamento do XML com o SimpleXML
$xml = new SimpleXMLElement($resultado);

// Passa por todos vídeos no RSS
foreach ($xml->entry AS $video) {

//pega o id da playlist
$partes=explode(‘playlist:’,$video->id);
$id_da_playlist=$partes[1];

//verifica se é a playlist que você declarou para listar os vídeos referentes a ela
if($video->title==$playlist){
$continuar = true;
while($continuar){

$youTube_UserFeedURL = “http://gdata.youtube.com/feeds/api/playlists/ “.$id_da_playlist. ” ?v=2&start-index= ” .$comeca_pelo. ” &max-results= ” .$numero_de_resultados;

// Usa cURL para pegar o XML do feed
$cURL = curl_init(sprintf($youTube_UserFeedURL, $usuario));
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
$resultado = curl_exec($cURL);
curl_close($cURL);

// Inicia o parseamento do XML com o SimpleXML
$xml2 = new SimpleXMLElement($resultado);
$quantidade=0;

foreach ($xml2->entry AS $video) {

$url = (string)$video->link[‘href’];

//Quebra a URL do vídeo para pegar o ID
parse_str(parse_url($url, PHP_URL_QUERY), $params);

$id = $params[‘v’];

$publicado=explode(‘T’,(string)$video->published);

$categorias = array();
foreach($video->category as $cat){
$categorias[] = $cat[‘term’];

}

// Monta um array com os dados do vídeo
$videos[] = array(
‘id’ => $id,
‘publicado’=>$publicado[0],
‘titulo’ => (string)$video->title,
‘thumbnail’ => ‘http://i ‘ . rand(1, 4) . ‘ .ytimg.com/vi/’. $id .’/hqdefault.jpg’,
‘duracao’ => getDuracaoVideo($id),
‘url’ => $url,
‘categorias’ => $categorias
);

}

$comeca_pelo=$comeca_pelo+50;

$youTube_UserFeedURL = “http://gdata.youtube.com/feeds/api/playlists/ ” .$id_da_playlist. ” ?v=2&start-index= ” .$comeca_pelo. ” &max-results= ” .$numero_de_resultados;

// Usa cURL para pegar o XML do feed
$cURL = curl_init(sprintf($youTube_UserFeedURL, $usuario));
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
$resultado = curl_exec($cURL);
curl_close($cURL);

// Inicia o parseamento do XML com o SimpleXML
$xml2 = new SimpleXMLElement($resultado);
$quantidade2=0;
foreach ($xml2->entry AS $video) {
$quantidade2++;
}

if($quantidade2 == 0){
$continuar = false;

}
}

}
}

/*buscando vídeos da do youtube fim*/

/*listando os videos*/

foreach($videos as $v){
echo “Id: “.$v[‘id’];
echo “<br />”;
echo “Publicado: “.$v[‘publicado’];
echo “<br />”;
echo “Título: “.$v[‘titulo’];
echo “<br />”;
echo “Thumbnail: <img src='”.$v[‘thumbnail’].”‘ style=’width:150px;height:150px;’>”;
echo “<br />”;
echo “Duração: “.$v[‘duracao’];
echo “<br />”;
echo “Url: “.$v[‘url’];
echo “<br />”;
echo “Categorias: “;
foreach($v[‘categorias’] as $c){
echo $c.”;”;

}
echo “<br />”;
echo “<br />”;
}

?>