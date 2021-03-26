<?php
$id = '160276747322876_4472972082719966';
$token = '';
$crawl ="https://graph.facebook.com/v10.0/$id/comments?fields=from,created_time,message,attachment&limit=500&access_token=$token";
function crawl($link){
        $dataContent =  file_get_contents($link);
        $crawl = json_decode($dataContent);
        $old_content = json_decode(file_get_contents("crawl.json"),true);

        $fp = fopen("crawl.json", 'w');//mở file ở chế độ write-only

        for ($x = 0; $x < count($crawl->data); $x++ ) {
            $oneCmt = [];
            $oneCmt['stt'] = count($old_content) + 1;
            $oneCmt['content'] = $crawl->data[$x]->message;
            $oneCmt['imgUrl'] = $crawl->data[$x]->attachment->media->image->src;
            array_push($old_content, $oneCmt);
        }
            $data = json_encode($old_content, JSON_PRETTY_PRINT);
            fwrite($fp, "$data");
    if(isset($crawl->paging->next)){
        crawl($crawl->paging->next);
    }
    }
    crawl($crawl);




?>


