<?
$body = json_decode(file_get_contents('php://input'), true);
$mainFolder = 'img';
if(array_key_exists('page', $body)) {
    $mainFolder = $body['page'];
}

$scan = scandir("{$_SERVER['DOCUMENT_ROOT']}/src/{$mainFolder}");
$arrImg = [];
$arrFolders = [];
$imageFolders = [];
foreach($scan as $value){
    $fullPath = "{$_SERVER['DOCUMENT_ROOT']}/src/{$mainFolder}/{$value}";
    if($value != "." && $value != ".."){
        if (is_dir($fullPath)){
            $arrFolders[] = $value;
        }
        else{
            $arrImg[] = $value;
        }

    }
}
if (count($arrFolders)){
    foreach ($arrFolders as $folder) {
        $scanFolder = scandir("{$_SERVER['DOCUMENT_ROOT']}/src/{$mainFolder}/{$folder}");
        foreach ($scanFolder as $value) {
            if($value != "." && $value != ".."){
                $imageFolders[$folder][] = $value;
            }
        }
    }
}

$arrSend = [];
$arrSend['arrImg'] = json_encode($arrImg);
if($imageFolders) {
    $arrSend['arrFoldersImg'] = json_encode($imageFolders);
}
echo $arrSend = json_encode($arrSend);