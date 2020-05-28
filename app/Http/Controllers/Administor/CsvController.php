<?php

namespace App\Http\Controllers\Administor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;

class CsvController extends Controller
{
  public function index(){
    $users = User::where('temporary', true)->get();

    $file_id = random_int(100000000000000, 999999999999999);
    $file_name = 'private/csv/'.$file_id.'.csv';

    $csv = fopen(storage_path('app/'.$file_name), 'w');
    if($csv){
      fputcsv($csv, mb_convert_encoding([
        'ログインID',
        '仮パスワード',
        '名前'
      ], 'SJIS', 'UTF-8'));
      foreach($users as $user){
        fputcsv($csv, mb_convert_encoding([
          decryptData($user['login_id'], 'USER_KEY'),
          decryptData($user['temporary_password'], 'TEMP_KEY'),
          decryptData($user['name'], 'USER_KEY')
        ], 'SJIS', 'UTF-8'));
      }
    }
    fclose($csv);

    header('Content-Type: application/octet-stream');
    header('Content-Length: ' . filesize(storage_path('app/'.$file_name)));
    header('Content-Disposition: attachment; filename='.$file_id.'.csv');
    readfile(storage_path('app/'.$file_name));

    Storage::delete($file_name);
  }
}
