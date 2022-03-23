# MaDump

## 為什麼需要 MaDump ?

因為 Magento 的物件如果直接用 var_dump() 或是 print_r() ，都會出現記憶體不足的錯誤，所以寫了一個 dump 工具只 dump 出物件的第一層方便開發。

## 安裝
```bash
composer require fishingboy/madump
```

## 使用方法
1. 直接輸出
    ```html
   <pre>
   Magento\Catalog\Model\Product\Interceptor
        ->__construct(Magento\Framework\Model\Context $context, Magento\Framework\Registry $registry, Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, Magento\Store\Model\StoreManagerInterface $storeManager, Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataService, Magento\Catalog\Model\Product\Url $url, Magento\Catalog\Model\Product\Link $productLink, Magento\Catalog\Model\Product\Configuration\Item\OptionFactory $itemOptionFactory, Magento\CatalogInventory\Api\Data\StockItemInterfaceFactory $stockItemFactory, Magento\Catalog\Model\Product\OptionFactory $catalogProductOptionFactory, Magento\Catalog\Model\Product\Visibility $catalogProductVisibility, Magento\Catalog\Model\Product\Attribute\Source\Status $catalogProductStatus, Magento\Catalog\Model\Product\Media\Config $catalogProductMediaConfig, Magento\Catalog\Model\Product\Type $catalogProductType, Magento\Framework\Module\Manager $moduleManager, Magento\Catalog\Helper\Product $catalogProduct, Magento\Catalog\Model\ResourceModel\Product $resource, Magento\Catalog\Model\ResourceModel\Product\Collection $resourceCollection, Magento\Framework\Data\CollectionFactory $collectionFactory, Magento\Framework\Filesystem $filesystem, Magento\Framework\Indexer\IndexerRegistry $indexerRegistry, Magento\Catalog\Model\Indexer\Product\Flat\Processor $productFlatIndexerProcessor, Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor, Magento\Catalog\Model\Indexer\Product\Eav\Processor $productEavIndexerProcessor, Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository, Magento\Catalog\Model\Product\Image\CacheFactory $imageCacheFactory, Magento\Catalog\Model\ProductLink\CollectionProvider $entityCollectionProvider, Magento\Catalog\Model\Product\LinkTypeProvider $linkTypeProvider, Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory, Magento\Catalog\Api\Data\ProductLinkExtensionFactory $productLinkExtensionFactory, Magento\Catalog\Model\Product\Attribute\Backend\Media\EntryConverterPool $mediaGalleryEntryConverterPool, Magento\Framework\Api\DataObjectHelper $dataObjectHelper, Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor, array $data, Magento\Eav\Model\Config $config)
        ->addAttributeUpdate($code, $value, $store)
        ->addCustomOption($code, $value, $product)
        ->addData(array $arr)
        ->addImageToMediaGallery($file, $mediaAttribute, $move, $exclude)
        ->addOption(Magento\Catalog\Model\Product\Option $option)
        ->afterCommitCallback()
        ->afterDelete()
        ->afterDeleteCommit()
        ->formatUrlKey($str)
        ->fromArray(array $data)
        ->getAttributeDefaultValue($attributeCode)
        ->getAttributeSetId() : 16 (string)
        ->getAttributeText($attributeCode)
        ->getAttributes($groupId, $skipSuper)
        ->getAvailableInCategories() : array
        ->getCacheIdTags() : array
        ->getCacheTags() : array
        ->getCalculatedFinalPrice() :  (NULL)
        ->getCategory() :  (NULL)
        ->getCategoryCollection() : Magento\Catalog\Model\ResourceModel\Category\Collection\Interceptor
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
   
4. 通常 Trace Code 的時候過程會長這樣

    step.1
    ```php
    MaDump::dump($product);
    ```
   
    step.2
    ```php
    MaDump::dump($product->getCustomAttributes());
    ```
   
    step.3
    ```php
    MaDump::dump($product->getCustomAttributes()[0]);
    ```
   
    自己在程式一層一層往下去找

## Output 說明
1. 如果是物件
    ```html
    <pre>
    Magento\Catalog\Model\Product\Interceptor
        ->__construct(Magento\Framework\Model\Context $context, Magento\Framework\Registry $registry, Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, Magento\Store\Model\StoreManagerInterface $storeManager, Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataService, Magento\Catalog\Model\Product\Url $url, Magento\Catalog\Model\Product\Link $productLink, Magento\Catalog\Model\Product\Configuration\Item\OptionFactory $itemOptionFactory, Magento\CatalogInventory\Api\Data\StockItemInterfaceFactory $stockItemFactory, Magento\Catalog\Model\Product\OptionFactory $catalogProductOptionFactory, Magento\Catalog\Model\Product\Visibility $catalogProductVisibility, Magento\Catalog\Model\Product\Attribute\Source\Status $catalogProductStatus, Magento\Catalog\Model\Product\Media\Config $catalogProductMediaConfig, Magento\Catalog\Model\Product\Type $catalogProductType, Magento\Framework\Module\Manager $moduleManager, Magento\Catalog\Helper\Product $catalogProduct, Magento\Catalog\Model\ResourceModel\Product $resource, Magento\Catalog\Model\ResourceModel\Product\Collection $resourceCollection, Magento\Framework\Data\CollectionFactory $collectionFactory, Magento\Framework\Filesystem $filesystem, Magento\Framework\Indexer\IndexerRegistry $indexerRegistry, Magento\Catalog\Model\Indexer\Product\Flat\Processor $productFlatIndexerProcessor, Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor, Magento\Catalog\Model\Indexer\Product\Eav\Processor $productEavIndexerProcessor, Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository, Magento\Catalog\Model\Product\Image\CacheFactory $imageCacheFactory, Magento\Catalog\Model\ProductLink\CollectionProvider $entityCollectionProvider, Magento\Catalog\Model\Product\LinkTypeProvider $linkTypeProvider, Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory, Magento\Catalog\Api\Data\ProductLinkExtensionFactory $productLinkExtensionFactory, Magento\Catalog\Model\Product\Attribute\Backend\Media\EntryConverterPool $mediaGalleryEntryConverterPool, Magento\Framework\Api\DataObjectHelper $dataObjectHelper, Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor, array $data, Magento\Eav\Model\Config $config)
        ->addAttributeUpdate($code, $value, $store)
        ->addCustomOption($code, $value, $product)
        ->addData(array $arr)
        ->addImageToMediaGallery($file, $mediaAttribute, $move, $exclude)
        ->addOption(Magento\Catalog\Model\Product\Option $option)
        ->afterCommitCallback()
        ->afterDelete()
        ->afterDeleteCommit()
        ->formatUrlKey($str)
        ->fromArray(array $data)
        ->getAttributeDefaultValue($attributeCode)
        ->getAttributeSetId() : 16 (string)
        ->getAttributeText($attributeCode)
        ->getAttributes($groupId, $skipSuper)
        ->getAvailableInCategories() : array
        ->getCacheIdTags() : array
        ->getCacheTags() : array
        ->getCalculatedFinalPrice() :  (NULL)
        ->getCategory() :  (NULL)
        ->getCategoryCollection() : Magento\Catalog\Model\ResourceModel\Category\Collection\Interceptor
        ...
    </pre>
    ```
   
    如果是 getter method 而且不需要帶參數的話，會直接把呼叫後的值秀出來看。

3. 如果是陣列
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
   
4. 如果只是一般的值
    ```html
    <pre>1 (integer)</pre>
    ```

    ```html
    <pre>true (boolean)</pre>
    ```

    ```html
    <pre>sku-123 (string)</pre>
    ```