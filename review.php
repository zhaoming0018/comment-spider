<?php

include "simple_html_dom.php";

function getHtml($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);     // 1将执行结果保存到返回值中，0直接输出
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法
    return curl_exec($curl);
}

$f = fopen('comment.txt', 'w');
for($i=1;$i<=24;$i++){
    $url = "http://product.dangdang.com/index.php?r=comment%2Flist&productId=25165064&categoryPath=01.12.31.01.00.00&mainProductId=25165064&mediumId=0&pageIndex=".$i."&sortType=1&filterType=1&isSystem=1&tagId=0&tagFilterCount=0&template=publish";
    $tmpInfo = getHtml($url);
    $data = json_decode($tmpInfo);
    // $f = fopen("cur.html", "wa");
    // fwrite($f, $data->data->list->html);
    $htmlRaw = $data->data->list->html;
    $html = str_get_html($htmlRaw);
    foreach($html->find('.describe_detail span') as $comment){
        echo trim($comment->text())."\n";
        fwrite($f, trim($comment->text())."\n");
    }
}
fclose($f);

