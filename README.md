# MaDerDump

## 安裝
```
composer require fishingboy/madump
```

## 使用方法
1. 直接輸出
    ```php
    use Fishingboy\MaDump\MaDump; 
    (new MaDump())->dump($product);
    ```
   
    Output:
    ```
    Magento\Catalog\Model\Product\Interceptor
    ->___callParent()
    ->___init()
    ->__call()
    ->__construct()
    ->__sleep()
    ->__toArray()
    ->__wakeup()
    ->addAttributeUpdate()
    ->addCustomOption()
    ->addData()
    ->addImageToMediaGallery()
    ->addOption()
    ->afterCommitCallback()
    ->afterDelete()
    ->afterDeleteCommit()
    ->afterLoad()
    ->afterSave()
    ->beforeDelete()
    ->beforeLoad()
    ->beforeSave()
    ->canAffectOptions()
    ->canBeShowInCategory()
    ->canConfigure()
    ...
    ```

2. 記在 log
    ```php
    use Fishingboy\MaDump\MaDump; 
    $product_dump = (new MaDump())->dump($product, true);
    $this->_logger->info("product => " . $product_dump); 
    ```
   
3. 有時候可能需要直接中斷執行，請直接用 exit
    ```php
   use Fishingboy\MaDump\MaDump;
   (new MaDump())->dump($product);
   exit;
   ```
