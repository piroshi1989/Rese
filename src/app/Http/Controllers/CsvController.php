<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\Genre;
use App\Models\Area;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function showCsvUpload()
    {
        return view('csv_upload');
    }

    public function importCsv(Request $request)
    {
        try {
        $shop = new Shop();
        // CSVファイルが存在するかの確認
        if ($request->hasFile('csvFile')) {
            //拡張子がCSVであるかの確認
            if ($request->csvFile->getClientOriginalExtension() !== "csv") {
                throw new \Exception('不適切な拡張子です。');
            }
            //ファイルの保存
            $newCsvFileName = $request->csvFile->getClientOriginalName();
            $request->csvFile->storeAs('public/csv', $newCsvFileName);
        } else {
            throw new \Exception('CSVファイルの取得に失敗しました。');
        }
        //保存したCSVファイルの取得
        $csv = Storage::disk('local')->get("public/csv/{$newCsvFileName}");
        // OS間やファイルで違う改行コードをexplode統一
        $csv = str_replace(array("\r\n", "\r"), "\n", $csv);
        // $csvを元に行単位のコレクション作成。explodeで改行ごとに分解
        $uploadedData = collect(explode("\n", $csv));

        $header = array('name', 'genre', 'area', 'detail', 'image');
        $uploadedHeader = collect(explode(",", $uploadedData->shift()));
        
        if (count($header) !== count($uploadedHeader) || array_diff($header, $uploadedHeader->toArray())) {
            throw new \Exception('Error: ヘッダーが一致しません');
        }

        // 連想配列を作成
        $shops = $uploadedData->map(function($oneRecord) use ($header) {
            $values = explode(",", $oneRecord);
            $record = [];
            foreach ($header as $index => $key) {
                if (!isset($values[$index])) {
                    throw new \Exception('Error: ヘッダーとデータの要素が一致しないものがあります');
                }
                $record[$key] = $values[$index];
            }
            if (count($header) !== count($record)) {
                throw new \Exception('Error: ヘッダーとデータの要素数が一致しません');
            }
            return $record;
        });

        // 既存データとの重複チェック（nameカラム）
        $duplicateNames = Shop::whereIn('name', $shops->pluck('name'))->pluck('name');
        if (!$duplicateNames->isEmpty()) {
            throw new \Exception("Error: nameの重複 - " . $duplicateNames->implode(', '));
        }



    // 名前からIDを取得
    $genreMap = Genre::whereIn('name', $shops->pluck('genre'))->pluck('id', 'name');
    $areaMap = Area::whereIn('name', $shops->pluck('area'))->pluck('id', 'name');

       // ジャンル名に該当しないものを検出
       $nonExistentGenres = $shops->pluck('genre')->diff($genreMap->keys());
       if ($nonExistentGenres->isNotEmpty()) {
           throw new \Exception('Error: 存在しないジャンル名 - ' . $nonExistentGenres->implode(', '));
       }

       // エリア名に該当しないものを検出
       $nonExistentAreas = $shops->pluck('area')->diff($areaMap->keys());
       if ($nonExistentAreas->isNotEmpty()) {
           throw new \Exception('Error: 存在しないエリア名 - ' . $nonExistentAreas->implode(', '));
       }

    foreach ($shops as $shop) {
        if (empty($shop['name'])) {
            throw new \Exception('Error: 名前が空です。');
        }
    }

    foreach ($shops as $shop) {
        if (empty($shop['detail'])) {
            throw new \Exception('Error: 詳細情報が空です。');
        }
    }

    // 'image'ヘッダーの値が.jpgまたは.pngであることを確認
    $imageHeaderIndex = $uploadedHeader->search('image');
    foreach ($uploadedData as $oneRecord) {
        $values = explode(",", $oneRecord);
        if (!in_array(pathinfo($values[$imageHeaderIndex], PATHINFO_EXTENSION), ['jpg', 'png'], true)) {
            throw new \Exception('Error: "image" の拡張子は.jpgまたは.pngである必要があります');
        }
    }

    // $shops 配列内の各要素にIDを追加
    $shops = $shops->map(function ($shop) use ($genreMap, $areaMap) {
        $shop['genre_id'] = $genreMap[$shop['genre']];
        $shop['area_id'] = $areaMap[$shop['area']];
        unset($shop['genre']);
        unset($shop['area']);
        return $shop;
    });

    $shops->each(function ($shop) {
        if (mb_strlen($shop['name']) > 50) {
            throw new \Exception('Error: ショップ名が50文字を超えています。');
        }

        if (mb_strlen($shop['detail']) > 400) {
            throw new \Exception('Error: 詳細が400文字を超えています。');
        }

    });

    DB::table('shops')->insert($shops->toArray());


    // 成功の場合、リダイレクト
    return redirect('/csv.upload')->with('message', 'csvファイルはアップロードされ、データベースにimportできました');
} catch (\Exception $e) {
    // エラーが発生した場合、エラーメッセージをセッションに保存
    return redirect('/csv.upload')->with('error', $e->getMessage());
    }
    }}
