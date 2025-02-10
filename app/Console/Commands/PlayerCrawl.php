<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Tools\Curls;
use App\Tools\Image;
use Illuminate\Console\Command;

class PlayerCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:player-crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $page = 1;
        while (true) {
            $jsonData = Curls::send('https://www.pesmaster.com/pes-2021/search/api.php?game=2021&myclub=yes&page=' . $page);

            $data = json_decode($jsonData, true);
            $page++;

            if (!count($data['data'])) continue;

            foreach ($data['data'] as $value) {
                $exists = Player::where(['name_en'=>$value['name'], 'nation'=>$value['nat_name']])->first();
                if ($exists) continue;

                if ($value['nat']) {
                    $nationImg = 'https://www.pesmaster.com' . $value['image_country'];
                    $fileInfos = explode('/', $value['image_country']);
                    $fileName = end($fileInfos);
                    $filePath = 'images/nations/';
                    if (!is_dir(public_path($filePath))) {
                        mkdir(public_path($filePath), 0777, true);
                    }
                    Image::saveFromUrl($nationImg, public_path($filePath . $fileName));
                }

                $nationPath = $value['nat'] ?? 'NONE';
                $headImg = 'https://www.pesmaster.com' . $value['image'];
                $headImg = str_replace('-mobile', '', $headImg);
                $fileInfos = explode('/', $value['image']);
                $fileName = end($fileInfos);
                $filePath = 'images/players/' . $nationPath . '/';
                if (!is_dir(public_path($filePath))) {
                    mkdir(public_path($filePath), 0777, true);
                }
                $fileRes = Image::saveFromUrl($headImg, public_path($filePath . $fileName));

                $player = [];
                $player['code'] = $value['id'];
                $player['name_en'] = $value['name'];
                $player['headimg'] = $fileRes ? $filePath . $fileName : '';
                $player['nation'] = $value['nat_name'] ?? '';
                $player['nation_abbr'] = $value['nat'] ?? '';
                $player['age'] = $value['age'];
                $player['height'] = $value['height'];
                $player['position'] = $value['pos'];
                $player['rating'] = $value['ovr'];

                $playerHTML = Curls::send('https://www.pesmaster.com/r-lewandowski/pes-2021/player/' . $value['id'] . '/');
                $dom = new \DOMDocument();
                @$dom->loadHTML($playerHTML);
                $dom->normalize();
                $xpath = new \DOMXPath($dom);

                $playerInfo = $xpath->query('//table[contains(@class, "player-info")]//td');
                for ($i=0;$i<$playerInfo->length;$i++) {
                    if (trim($playerInfo->item($i)->nodeValue) == 'Full Name') {
                        $player['full_name'] = trim($playerInfo->item($i+1)->nodeValue);
                    }
                    if (trim($playerInfo->item($i)->nodeValue) == 'Stronger Foot') {
                        $player['strong_foot'] = trim($playerInfo->item($i+1)->nodeValue);
                    }
                    if (trim($playerInfo->item($i)->nodeValue) == 'Weight') {
                        $player['weight'] = trim($playerInfo->item($i+1)->nodeValue);
                    }
                }

                $playerData = [];
                $playerDataInfo = $xpath->query('//div[contains(@class, "stats-block-container")]//td[contains(@class, "stat")]/span');
                foreach ($playerDataInfo as $info) {
                    $className = $info->getAttribute('class');
                    $classNameArr = explode('_', $className);
                    $dataKey = '';
                    foreach ($classNameArr as $key => $name) {
                        if ($key > 0) $dataKey .= ' ';
                        $dataKey .= ucfirst($name);
                    }

                    $playerData[$dataKey] = $info->nodeValue;
                }
                $player['data'] = json_encode($playerData);

                $player = Player::create($player);

                echo json_encode($player);
                echo PHP_EOL;
            }

            if (!$data['more_available']) break;
        }
    }
}
