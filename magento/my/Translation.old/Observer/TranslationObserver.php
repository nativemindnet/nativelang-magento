<?php

namespace SoftDevelopment\Translation\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ObjectManager;
use SoftDevelopment\Translation\Api\GoogleTranslate;
use SoftDevelopment\Translation\Model\Config;

const API_URL = 'https://translation.googleapis.com/language/translate/v3';
const API_TIMEOUT = 500; //500ms
const API_KEY = 'API_KEY_EXAMPLE_123';

class TranslationObserver implements ObserverInterface
{
    // not sure about event, may be controller_action_layout_load_before


    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var GoogleTranslate
     */
    //private $googleTranslate;

    /**
     * TranslationObserver constructor.
     * @param ObjectManager $objectManager
     * @param GoogleTranslate $googleTranslate
     */
    public function __construct(
        ObjectManager $objectManager
        //,GoogleTranslate $googleTranslate
    ) {
        $this->objectManager = $objectManager;
        //$this->googleTranslate = $googleTranslate;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        //IMPORTANT!!! Target language for translation is Locale of current store view !!!
        $storeViewLocale = $this->objectManager->get('Magento\Framework\Locale\Resolver')->getLocale();
        $product = $observer->getEvent()->getProduct();

        //$translatedProduct = $this->translateProduct($product, $storeViewLocale);
        //$translatedCatalog = $this->translateCatalog($product->getCategory(), $storeViewLocale);
        //$translatedReviews = $this->translateReviews($product->getReviews(), $storeViewLocale);

        //set translated values to product, catalog and reviews
        //$event->setProduct($translatedProduct);
        //$event->setProduct($translatedProduct);
        //$event->setProduct($translatedProduct);
    }

    /**
     * Translate Product object and returns entire translated Product object
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $targetLanguage
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function translateProduct(\Magento\Catalog\Model\Product $product, string $targetLanguage): \Magento\Catalog\Model\Product
    {
        $attributes = ['meta_title', 'meta_keyword', 'meta_description', 'short_description', 'description'];

        foreach ($attributes as $attribute) {
            $product->setData($attribute, $this->translateText($product->getData($attribute), Config::DEFAULT_LANGUAGE, $targetLanguage));
        }

        return $product;
    }

    /**
     * Translate Catalog object and returns entire translated Catalog object
     *
     * @param \Magento\Catalog\Model\Category $catalog
     * @param string $targetLanguage
     *
     * @return \Magento\Catalog\Model\Category
     */
    public function translateCatalog(\Magento\Catalog\Model\Category $catalog, string $targetLanguage): \Magento\Catalog\Model\Category
    {
        $attributes = ['meta_title', 'meta_keywords', 'meta_description', 'name', 'description'];

        foreach ($attributes as $attribute) {
            $catalog->setData($attribute, $this->translateText($catalog->getData($attribute), Config::DEFAULT_LANGUAGE, $targetLanguage));
        }

        return $catalog;
    }

    /**
     * Translate a Review object
     *
     * @param \Magento\Review\Model\Review $review
     * @param string $targetLanguage
     *
     * @return \Magento\Review\Model\Review
     */
    public function translateReview(\Magento\Review\Model\Review $review, string $targetLanguage): \Magento\Review\Model\Review
    {
        $translatedTitle = $this->translateText($review->getTitle(), self::SOURCE_LANGUAGE, $targetLanguage);
        $review->setTitle($translatedTitle);

        $translatedNickname = $this->translateText($review->getNickname(), self::SOURCE_LANGUAGE, $targetLanguage);
        $review->setNickname($translatedNickname);

        $translatedDetail = $this->translateText($review->getDetail(), self::SOURCE_LANGUAGE, $targetLanguage);
        $review->setDetail($translatedDetail);

        $translatedSummary = $this->translateText($review->getSummary(), self::SOURCE_LANGUAGE, $targetLanguage);
        $review->setSummary($translatedSummary);

        return $review;
    }

    /**
     * Translate text using Google Translate API
     *
     * @param string $text
     * @param string $sourceLanguage
     * @param string $targetLanguage
     *
     * @return string|null
     */
    public function translateText(string $text, string $sourceLanguage, string $targetLanguage): ?string
    {
        return "translated";
        
        $params = [
            'q' => $text,
            'source' => $sourceLanguage,
            'target' => $targetLanguage,
            'key' => self::API_KEY
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, self::API_TIMEOUT);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);

        if (isset($response['data']['translations'][0]['translatedText'])) {
            return $response['data']['translations'][0]['translatedText'];
        }

        return null;
    }
}
