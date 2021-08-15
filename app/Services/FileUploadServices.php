<?php
namespace App\Services;

class FileUploadServices
{
  public static function fileUpload($imageFile){
    //ファイル名を取得(拡張子あり)
    $fileNameWithExt = $imageFile->getClientOriginalName();
    //拡張子を除いたファイル名を取得
    //第一引数にパス情報を渡す、第二引数にはPATHINFO_DIRNAME、 
    //PATHINFO_BASENAME、 PATHINFO_EXTENSION、PATHINFO_FILENAMEを渡す
    //PATHINFO_FILENAMEは最後の拡張子だけを取り除く
    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    //拡張子を取得
    $extension = $imageFile->getClientOriginalExtension();
    //ファイル名_時間_拡張子として設定
    $fileNameToStore = $fileName.'_'.time().'.'.$extension;
    //画像ファイル取得→ファイル自体
    $fileData = file_get_contents($imageFile->getRealPath());
    $list = [$extension, $fileNameToStore, $fileData];
    return $list;
  }
}

