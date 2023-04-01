<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
use \Gumlet\ImageResize;

class ItemShell extends AppShell
{
    public $uses = array('Item');
    public $data;
    
    public function import()
    {   
        $dir = new Folder(ITEMS_IMPORT);
        $files = $dir->find('.*\.jpg');
        
        foreach($files as $key => $file)
        {
            $inputPath = ITEMS_IMPORT . DS . $file;
            $this->data[$key]['user_id'] = 1;
            $this->data[$key]['type'] = 1;
            $this->data[$key]['verification'] = 1;
            $this->data[$key]['verified'] = date('Y-m-d H:i:s');
            $this->data[$key]['publish'] = 1;
            $this->data[$key]['published'] = date('Y-m-d H:i:s');
            
            $width = getimagesize($inputPath)[0];
            $height = getimagesize($inputPath)[1];
            $this->data[$key]['orientation'] = $this->orientation($width, $height);
            
            $image = new ImageResize($inputPath);
            
            // Миниатюра для коллекций на странице items/view
            $thumbs_50x50_path = $this->outputPath($file);
            $image->crop(50, 50);
            if ($image->save(ITEMS . DS . $thumbs_50x50_path)) {
                $this->data[$key]['thumbs_50x50'] = $thumbs_50x50_path;
            }
            
            // Обложка для альбома
            $thumbs_263x180_path = $this->outputPath($file);
            $image->crop(263, 180);
            if ($image->save(ITEMS . DS . $thumbs_263x180_path)) {
                $this->data[$key]['thumbs_263x180'] = $thumbs_263x180_path;
            }
            
            // Оригинал изображения. То что скачивается
            $original_path = $this->outputPath($file);
            $image->resize($width, $height);
            if ($image->save(ITEMS . DS . $original_path)) {
                $this->data[$key]['Photo'][] = array(
                    'path' => $original_path,
                    'scale' => 1,
                    'width' => $width,
                    'height' => $height,
                    'size' => filesize(ITEMS . DS . $original_path)
                );
            }
            
            // Изображение с высотой 200px. Показывается в rowGrids
            $height_200_path = $this->outputPath($file);
            $image->resizeToHeight(200);
            if ($image->save(ITEMS . DS . $height_200_path)) {
                $this->data[$key]['Photo'][] = array(
                    'path' => $height_200_path,
                    'scale' => 2,
                    'width' => getimagesize(ITEMS . DS . $height_200_path)[0],
                    'height' => 200,
                    'size' => filesize(ITEMS . DS . $height_200_path)
                );
            }
            
            // Изображение с высотой 400px. Показывается на странице view
            $height_400_path = $this->outputPath($file);
            $image->resizeToHeight(400);
            if ($image->save(ITEMS . DS . $height_400_path)) {
                $this->data[$key]['Photo'][] = array(
                    'path' => $height_400_path,
                    'scale' => 3,
                    'width' => getimagesize(ITEMS . DS . $height_400_path)[0],
                    'height' => 400,
                    'size' => filesize(ITEMS . DS . $height_400_path)
                );
            }
        }
        
        $this->Item->saveMany($this->data, array('deep' => true));
        
        pr(count($this->data));
    }
    
    private function outputPath($file)
    {
        $dirPath = $this->dirPath();
        $dir = new Folder(ITEMS . DS . $dirPath);
        if (is_null($dir->path)) {
            $dir->create(ITEMS . DS . $dirPath);
        }
        
        return $dirPath . DS . $this->fileName($file);
    }
    
    /*
    Генерация директорий, с указанием глубины
    */
    private function dirPath()
    {
        $dir = '';
        $dir_separator = DS;
        for ($i = 1; $i <= DEPTH; $i++)
        {
            if ($i == DEPTH) {
                $dir_separator = '';
            }
            $dir .= substr(md5(microtime()), mt_rand(0, 30), 2) . $dir_separator;
        }
        
        return $dir;
    }
    
    /*
    Генерация имени файла
    */
    private function fileName($file)
    {
        return md5($file . substr(md5(microtime()), mt_rand(0, 30), 5)) . '.jpg';
    }
    
    /**
     * Определение ориентации изображения
     * @param type $file
     * 
     */
    private function orientation($width, $height)
    {   
        if ($width > $height) {
            $orientation = 1; //горизонтальное
        } elseif ($width < $height) {
            $orientation = 2; //вертикальное
        } else {
            $orientation = 3; //квадратное
        }
        
        return $orientation;
    }
}