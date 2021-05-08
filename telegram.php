<?php
$envs = parse_ini_file('.env');

define('BOT_TOKEN', $envs['BOT_TOKEN'] );
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

$sites = array(
    'https://www.newboxinfo.com.br',
    'https://www.barbaclubeoldschool.com.br',
    'https://www.terraplena.com.br',
    'https://www.barbaclubeoldschool.com.br',
    'https://www.mtlrepresentacoes.com.br',
    'https://www.meconvites.com.br',
    'https://www.valterrodas.com.br/',
    'https://www.hotellegalcapanema.com.br/',
    'https://www.floresdocamporesidencial.com.br/',
    'https://www.torresalamo.com.br/',
    'https://www.totumflex.com.br/',
    'https://www.ldbcontabilidade.cnt.br/',
    'https://www.ebdbelem.com.br/',
    'https://www.imcd.com.br/'
    );

$botId = $envs['BOT_ID']; //id do bot do telegram
$chatId = $envs['CHAT_ID']; //id do chat do telegram

try 
{
    foreach($sites as $site){
        $file_headers = @get_headers($site);
        if((stripos($file_headers[0],"200 OK")) || (stripos($file_headers[7],"200 OK")) || (stripos($file_headers[9],"200 OK")) || (stripos($file_headers[12],"200 OK"))){
            $responseCode = '200';
        } else {
            //print_r($file_headers);
            $msg = '['.date('d/m/Y H:i:s').'] O portal: ' . $site . ' está fora do ar!';
            echo $msg;
            sendMessage("sendMessage", array('chat_id' => $chatId, "text" => $msg)); //envia a mensagem no telegram

        }

    }

} catch (Exception $e){ //capturando o response code caso o sistema retorne 404
    var_dump($e);
}

function sendMessage($method, $parameters) {
    $params = json_encode($parameters);
    $options = array(
        'http' => array(
        'method'  => 'POST',
        'content' => $params,
        'header'=>  "Content-Type: application/json\r\n" .
                  "Accept: application/json\r\n"
        )
    );
     $context  = stream_context_create( $options );
    file_get_contents(API_URL.$method, false, $context );
}