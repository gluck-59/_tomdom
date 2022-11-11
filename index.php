<?php

    $youtube = new Youtube();
    $res = $youtube->getVideosbyChannelId('UCndOFkIsRNaO0JyzxFwyR1w');

    echo '<pre>';
    print_r($res);
    echo '</pre>';

    foreach ($res->items as $video) {
        preg_match('/[\d]{5,7}/', $video->snippet->description, $matches);
        $out[$video->id->videoId] = $matches[0];
    }

?>


    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
        <title>Видео</title>
        <link rel="stylesheet" href="//www.w3schools.com/w3css/4/w3.css">
    </head>
    <body>
    <div class="w3-row">
        <div class="w3-half w3-container">
            <table class="w3-table-all">
                <thead>
                    <th>Ссылка</th>
                    <th>Арт. №</th>
                </thead>
                <tbody>
                    <?php
                        foreach ($out as $url => $item) { ?>
                            <tr>
                                <td><a href="https://www.youtube.com/watch?v=<?=$url?>" target="_blank">https://www.youtube.com/watch?v=<?=$url?></a></td>
                                <td><?=$item?></td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    </body>
</html>


<?php
    class Youtube {
        public $videos;

        function __construct() {
            require_once 'settings.php';
        }

        /**
         * тянет ID и описания роликов из заданного youtube-канала
         * возвращает JSON
         *
         * @param string $channelId
         * @return string
         * @throws Exception
         */
        public function getVideosbyChannelId(string $channelId) {
            $curl = curl_init();
            $url = YOUTUBE_URL.'&channelId='.$channelId;

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept:application/json']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            if (($response = curl_exec($curl)) === false) {
                throw new \Exception(curl_error($curl));
            }
            curl_close($curl);

            $this->videos = json_decode($response);
            return $this->videos;
        }
    }


