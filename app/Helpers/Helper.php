<?php

use App\Media;

// Save the image
function saveDefaultImage($fileData, $fileName, $fileId) {
    try {
        $storeFile = $fileData->store('public/media/'.$fileName.'/'.$fileId);
        $storeThumbnailFile = $fileData->store('public/media/'.$fileName.'/'.$fileId.'/thumbnail');
        $newThumbnailFile = Image::make($fileData)->orientate();
        $newThumbnailFile->resize(230, 235);

        $newThumbnailFile->stream();
        Storage::put($storeThumbnailFile, $newThumbnailFile);

        $filename = explode('/', $storeFile);
        $fileType = explode('/', $fileData->getMimeType());
        $checkFileType = [
            'image' => 'image',
            'application' => 'document',
            'text' => 'document'
        ];

        $media = Media::create(
            [
                'filename'           => $filename[4],
                'original_filename'  => $fileData->getClientOriginalName(),
                'extension'          => $fileData->getClientOriginalExtension(),
                'mime'               => $fileData->getMimeType(),
                'type'               => $checkFileType[$fileType[0]],
                'file_size'          => $fileData->getClientSize()
            ]
        );

        return $media;

    } catch (\Exception $exception) {
        logger()->error($exception->getMessage());
    }

    return false;
}

// Save the image
function saveImage($fileData, $fileName, $fileId) {
    try {
        $storeFile = $fileData->store('public/media/'.$fileName.'/'.$fileId);
        $storeThumbnailFile = $fileData->store('public/media/'.$fileName.'/'.$fileId.'/thumbnail');

        $newFile = Image::make($fileData)->orientate();
        $newThumbnailFile = Image::make($fileData)->orientate();
        $height =  $newFile->height();
        $width =  $newFile->width();
        $newThumbnailFile = Image::make($fileData)->orientate();

        if($height > $width) {
            $newFile->resize(720, 960, function ($constraint) {
                $constraint->aspectRatio();
            });

        } else {
            $newFile->resize(960, 720, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $newThumbnailFile->resize(230, 235);

        $newFile->stream();
        $newThumbnailFile->stream();

        Storage::put($storeFile, $newFile);
        Storage::put($storeThumbnailFile, $newThumbnailFile);

        $filename = explode('/', $storeFile);
        $fileType = explode('/', $fileData->getMimeType());
        $checkFileType = [
            'image' => 'image',
            'application' => 'document',
            'text' => 'document'
        ];

        $media = Media::create(
            [
                'filename'           => $filename[4],
                'original_filename'  => $fileData->getClientOriginalName(),
                'extension'          => $fileData->getClientOriginalExtension(),
                'mime'               => $fileData->getMimeType(),
                'type'               => $checkFileType[$fileType[0]],
                'file_size'          => $fileData->getClientSize()
            ]
        );

        return $media;

    } catch (\Exception $exception) {
        logger()->error($exception->getMessage());
    }

    return false;
}

// Save the file
function saveFile($fileData, $fileName, $fileId) {
    try {
        $storeFile = $fileData->store('public/media/'.$fileName.'/'.$fileId);
        if($fileData->getClientOriginalExtension() != 'pdf') {
            $storeThumbnailFile = $fileData->store('public/media/'.$fileName.'/'.$fileId.'/thumbnail');

            $newFile = Image::make($fileData)->orientate();
            $newThumbnailFile = Image::make($fileData)->orientate();
            $height =  $newFile->height();
            $width =  $newFile->width();
            $newThumbnailFile = Image::make($fileData)->orientate();

            if($height > $width) {
                $newFile->resize(720, 960, function ($constraint) {
                    $constraint->aspectRatio();
                });

            } else {
                $newFile->resize(960, 720, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $newThumbnailFile->resize(230, 235);

            $newFile->stream();
            $newThumbnailFile->stream();

            Storage::put($storeFile, $newFile);
            Storage::put($storeThumbnailFile, $newThumbnailFile);
        }
        
        $filename = explode('/', $storeFile);
        $fileType = explode('/', $fileData->getMimeType());
        $checkFileType = [
            'image' => 'image',
            'application' => 'document',
            'text' => 'document'
        ];


        $media = Media::create(
            [
                'filename'           => $filename[4],
                'original_filename'  => $fileData->getClientOriginalName(),
                'extension'          => $fileData->getClientOriginalExtension(),
                'mime'               => $fileData->getMimeType(),
                'type'               => $checkFileType[$fileType[0]],
                'file_size'          => $fileData->getClientSize()
            ]
        );

        return $media;

    } catch (\Exception $exception) {
        logger()->error($exception->getMessage());
    }
}

// Remove the file
function removeFile($fileId) {
    try {
        if (Media::find($fileId)) {
            $media = Media::find($fileId);
            $media->delete();

            return $media;
        }
    } catch (\Exception $exception) {
        logger()->error($exception->getMessage());
    }
}

// Change the price format to nepali currency format
function nepaliCurrencyFormat($money){
    $decimal = (string)($money - floor($money));
    $money = floor($money);
    $length = strlen($money);
    $m = '';
    $money = strrev($money);
    for($i=0;$i<$length;$i++){
        if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
            $m .=',';
        }
        $m .=$money[$i];
    }
    $result = strrev($m);
    $decimal = preg_replace("/0\./i", ".", $decimal);
    $decimal = substr($decimal, 0, 3);
    if( $decimal != '0'){
    $result = $result.$decimal;
    }
    return $result;
}

function pagination($data, $loop) {
    return ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1;
}

function reversePagination($data, $loop) {
    return $data->total() + 1 - (($data->currentpage() - 1) * $data->perpage() + $loop->index + 1);
}
   
function getRoute($route_name, $controller_name) {
    Route::resource('/'.$route_name, $controller_name);
    Route::post('/'.$route_name.'/change-status/{id}', $controller_name.'@changeStatus')->name($route_name.'.changeStatus');
}

?>