# MaDerDump

## 安裝
```bash
composer require fishingboy/madump
```

## 使用方法
1. 直接輸出
    ```php
    use Fishingboy\MaDump\MaDump; 
    MaDump::dump($product);
    ```
   
    Output:
    ```html
    <pre>
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
    </pre>
    ```

2. 記在 Log (把 output 內容 return 回來)
    ```php
    use Fishingboy\MaDump\MaDump; 
    $product_dump = MaDump::dump($product, true);
    $this->_logger->info("product => " . $product_dump); 
    ```
   
3. 有時候可能需要直接中斷執行，請直接用 exit
    ```php
   use Fishingboy\MaDump\MaDump;
   MaDump::dump($product);
   exit;
   ```
   
4. 通常 trace code 的時候過程會長這樣
    ```php
    MaDump::dump($product);
    ```
   
    ```php
    MaDump::dump($product->getCustomAttributes());
    ```
   
    ```php
    MaDump::dump($product->getCustomAttributes()[0]);
    ```
   
    自己在程式一層一層往下去找

## Output 說明
1. 如果是物件
    ```html
    <pre>
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
    </pre>
    ```
   
2. 如果是陣列
    ```html
    <pre>
    Array(52) => 
    [0] => (Magento\Framework\Api\AttributeValue)
    [10] => (Magento\Framework\Api\AttributeValue)
    [11] => (Magento\Framework\Api\AttributeValue)
    [12] => (Magento\Framework\Api\AttributeValue)
    ...
    </pre>
    ```
   
    或是這樣
    ```html
    <pre>
    Array(2) => 
    [0] => 101
    [1] => 102
    </pre>
    ```
   
3. 如果只是一般的值
    ```html
    <pre>1 (integer)</pre>
    ```

    ```html
    <pre>1 (boolean)</pre>
    ```

    ```html
    <pre>sku-123 (string)</pre>
    ```